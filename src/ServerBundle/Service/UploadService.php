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
    protected $entityManager;

    protected $targetPath;

    public function __construct(
        EntityManager $entityManager,
        $targetPath
    ) {
        $this->entityManager = $entityManager;
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
        $id3FileInfo = $id3parser->analyze($uploadedFile->getRealPath());
        $fileInformation = Id3Information::fromGetId3Result($id3FileInfo);

        $track = new Track();
        $track->setTitle($fileInformation->getTitle());
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