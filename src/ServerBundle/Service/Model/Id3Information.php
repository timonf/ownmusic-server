<?php

namespace ServerBundle\Service\Model;

class Id3Information
{
    protected $artist;

    protected $artists;

    protected $title;

    protected $trackNumber;

    protected $playtime;

    protected $bitRate;

    /**
     * @param $ThisFileInfo
     * @return static
     */
    public static function fromGetId3Result($ThisFileInfo)
    {
        \getid3_lib::CopyTagsToComments($ThisFileInfo);
        $instance = new static;
        $instance->artists = isset($ThisFileInfo['comments_html']['artist']) ? $ThisFileInfo['comments_html']['artist'] : [];
        $instance->artist = isset($instance->artists[0]) ? $instance->artists[0] : '';
        $instance->title = isset($ThisFileInfo['comments_html']['title'][0]) ? $ThisFileInfo['comments_html']['title'][0] : '';
        $instance->playtime = isset($ThisFileInfo['playtime_seconds']) ? $ThisFileInfo['playtime_seconds'] : 0;
        $instance->bitRate = isset($ThisFileInfo['audio']['bitrate']) ? $ThisFileInfo['audio']['bitrate'] : null;
        return $instance;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @return mixed
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getTrackNumber()
    {
        return $this->trackNumber;
    }

    /**
     * @return mixed
     */
    public function getPlaytime()
    {
        return $this->playtime;
    }

    /**
     * @return mixed
     */
    public function getBitRate()
    {
        return $this->bitRate;
    }
}
