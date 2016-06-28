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
     * @ORM\Column(type="string", length=511)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", name="normalized_title", length=127)
     * @var string
     */
    protected $normalizedTitle;

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
     * @return string
     */
    public function getNormalizedTitle()
    {
        return $this->normalizedTitle;
    }

    /**
     * @param string $normalizedTitle
     */
    public function setNormalizedTitle($normalizedTitle)
    {
        $this->normalizedTitle = $normalizedTitle;
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
