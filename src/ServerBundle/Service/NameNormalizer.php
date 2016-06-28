<?php

namespace ServerBundle\Service;

class NameNormalizer
{
    const FEATURING = '<FEAT>';

    const TYPE_UNKNOWN = 0;
    const TYPE_SONG_TITLE = 1;
    const TYPE_ARTIST = 2;
    const TYPE_ALBUM_NAME = 3;

    protected $featuringShort = 'ft.';

    protected $translationTable = [
        '@' => 'at',
        '€' => 'eur',
        '$' => 'usd',
        '£' => 'gbp',
        '¹' => '1',
        '²' => '2',
        '³' => '3',
        '—' => '-',
        '–' => '-',
        'ä' => 'ae',
        'ö' => 'oe',
        'ü' => 'ue',
        'ß' => 'ss',
        'µ' => 'mu',
    ];

    protected $featuringReplacements = [
        'ft.' => self::FEATURING,
        'feat.' => self::FEATURING,
        'feat ' => self::FEATURING,
        'featuring ' => self::FEATURING,
    ];

    public function normalize($name, $type = self::TYPE_UNKNOWN)
    {
        return array_values($this->normalizeAsArray($name, $type))[0];
    }

    public function normalizeAsArray($name, $type = self::TYPE_ARTIST)
    {
        $values = [];
        $results = [];

        if ($type == self::TYPE_ARTIST) {
            $values[] = $this->separateFeaturingArtists(strtolower($name));
        } else {
            $values[] = $name;
        }

        foreach ($values as $value) {
            $value = strtolower($value);
            $value = $this->translateCharacters($value);
            $value = $this->removeUnknownCharacters($value);
            $value = $this->singularizeDividers($value);
            $value = $this->normalizeDividers($value);
            $value = trim($value);
            $value = trim($value, '-');
            $results[] = $value;
        }

        return $results;
    }

    protected function translateCharacters($value)
    {
        return str_replace(array_keys($this->translationTable), array_values($this->translationTable), $value);
    }
    
    protected function removeUnknownCharacters($value)
    {
        return preg_replace('/[^a-z0-9_]/i', '_', $value);
    }

    protected function singularizeDividers($value)
    {
        for ($i = 0; ($i < 10 || strpos($value, '__') !== false); $i++) {
            $value = str_replace('__', '_', $value);
        }

        return $value;
    }

    protected function normalizeDividers($value)
    {
        return str_replace('_', '-', $value);
    }

    protected function separateFeaturingArtists($artists)
    {
        $artists = explode(static::FEATURING, $artists);
        $results = [];

        foreach ($artists as $artist) {
            $results[] = trim($artist);
        }

        return $results;
    }
}