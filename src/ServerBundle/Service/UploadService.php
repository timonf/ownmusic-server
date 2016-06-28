<?php

namespace ServerBundle\Service;

use Doctrine\ORM\EntityManager;
use ServerBundle\Form\Model\UploadRequest;
use ServerBundle\Model\Track;
use ServerBundle\Model\TrackFile;
use ServerBundle\Service\Model\Id3Information;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var NameNormalizer
     */
    protected $nameNormalizer;

    /**
     * @var string
     */
    protected $targetPath;

    public function __construct(
        EntityManager $entityManager,
        NameNormalizer $nameNormalizer,
        $targetPath
    ) {
        $this->entityManager = $entityManager;
        $this->nameNormalizer = $nameNormalizer;
        $this->targetPath = $targetPath;
    }

    public function uploadFiles(UploadRequest $uploadRequest)
    {
        foreach ($uploadRequest->getFiles() as $uploadedFile) {
            if ($uploadedFile instanceof UploadedFile) {
                $md5sum = md5_file($uploadedFile->getRealPath());
                $trackFile = $this->entityManager->getRepository('ServerBundle:TrackFile')->findOneBy(array('md5sum' => $md5sum));

                if ($trackFile === null) {
                    $this->processFile($uploadedFile, $md5sum);
                }
            }
        }
        $this->entityManager->flush();
    }

    public function processFile(UploadedFile $uploadedFile, $alreadyCalculatedMd5Sum)
    {
        $id3parser = new \getID3();
        $id3parser->encoding = 'UTF-8';
        $id3FileInfo = $id3parser->analyze($uploadedFile->getRealPath());
        $fileInformation = Id3Information::fromGetId3Result($id3FileInfo);

        $track = new Track();
        $track->setTitle($fileInformation->getTitle());
        $track->setNormalizedTitle($this->nameNormalizer->normalize($fileInformation->getTitle(), NameNormalizer::TYPE_SONG_TITLE));
        $track->setDuration($fileInformation->getPlaytime());

        $targetFile = $alreadyCalculatedMd5Sum . '.' . $uploadedFile->getClientOriginalExtension();

        $trackFile = new TrackFile();
        $trackFile->setFile($this->targetPath . DIRECTORY_SEPARATOR . $targetFile);
        $trackFile->setTrack($track);
        $trackFile->setMd5sum($alreadyCalculatedMd5Sum);

        $track->addFile($trackFile);

        $uploadedFile->move($this->targetPath, $targetFile);

        $this->entityManager->persist($track);
        $this->entityManager->persist($trackFile);
    }
}