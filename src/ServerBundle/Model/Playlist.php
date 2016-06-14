<?php

namespace ServerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="playlists")
 */
class Playlist
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
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * @ORM\ManyToOne(targetEntity="ServerBundle\Model\User")
     */
    protected $createdBy;

    /**
     * @ORM\ManyToMany(targetEntity="Track")
     * @ORM\JoinTable(name="playlist_has_tracks",
     *      joinColumns={@ORM\JoinColumn(name="playlist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="track_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $tracks;

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
