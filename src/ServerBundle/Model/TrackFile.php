<?php

namespace ServerBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="track_files")
 */
class TrackFile
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\JoinColumn(name="track_id", referencedColumnName="id", nullable=false)
     * @ORM\ManyToOne(targetEntity="ServerBundle\Model\Track", inversedBy="files")
     * @var Track
     */
    protected $track;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $md5sum;

    /**
     * @ORM\Column(type="string", length=2048)
     * @var string
     */
    protected $file;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param Track $track
     */
    public function setTrack(Track $track)
    {
        $this->track = $track;
    }

    /**
     * @return string
     */
    public function getMd5sum()
    {
        return $this->md5sum;
    }

    /**
     * @param string $md5sum
     */
    public function setMd5sum($md5sum)
    {
        $this->md5sum = $md5sum;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
}
