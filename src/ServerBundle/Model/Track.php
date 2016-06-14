<?php

namespace ServerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tracks")
 */
class Track
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\Column
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="integer")
     * @var integer seconds
     */
    protected $duration;

    /**
     * @ORM\OneToMany(targetEntity="ServerBundle\Model\TrackFile", mappedBy="track")
     */
    protected $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @param TrackFile $file
     * @return Track
     */
    public function addFile(TrackFile $file)
    {
        $this->files[] = $file;
    }

    /**
     * @param TrackFile $file
     */
    public function removeFile(TrackFile $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * @return TrackFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }
}
