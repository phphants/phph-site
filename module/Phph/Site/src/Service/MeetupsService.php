<?php

namespace Phph\Site\Service;

use Phph\Site\Model\MeetupEntity;

class MeetupsService
{
    /**
     * @var string
     */
    private $meetupsDataPath;

    /**
     * @var MeetupEntity[]
     */
    private $cachedDirectoryListing;

    /**
     * Assign the meetups data path
     *
     * @param string $meetupsDataPath
     */
    public function __construct($meetupsDataPath)
    {
        $this->meetupsDataPath = (string)$meetupsDataPath;
    }

    /**
     * Get and cache the list of meetups from the data directory, ordered by
     * most recent first.
     *
     * @return array
     */
    public function getMeetupsList()
    {
        if (!is_array($this->cachedDirectoryListing)) {
            $this->cachedDirectoryListing = array();

            $directoryIterator = new \RecursiveDirectoryIterator($this->meetupsDataPath);
            $iteratorIterator = new \RecursiveIteratorIterator($directoryIterator);

            foreach ($iteratorIterator as $file) {
                /* @var $file \DirectoryIterator */
                if (substr($file->getFilename(), -4) == '.php') {
                    $this->cachedDirectoryListing[] = str_replace($this->meetupsDataPath, '', $file->getPathname());
                }
            }

            rsort($this->cachedDirectoryListing);
        }

        return $this->cachedDirectoryListing;
    }

    /**
     * Get the latest meetup entity
     *
     * @return MeetupEntity
     */
    public function getLatestMeetup()
    {
        $meetups = $this->getMeetupsList();

        return $this->getMeetup($meetups[0]);
    }

    /**
     * Get all the future meetups as an array
     *
     * @return array of MeetupEntity objects
     */
    public function getFutureMeetups()
    {
        $meetups = $this->getMeetupsList();

        $now = new \DateTime();

        $future_meetups = array();

        foreach ($meetups as $meetup) {
            $date = $this->extractDateTimeFromMeetupFilename($meetup);
            $diff = $date->diff($now);
            if ($diff->invert || $diff->days == 0) {
                $future_meetups[$date->format('Ymd')] = $this->getMeetup($meetup);
            }
        }

        asort($future_meetups);

        if (count($future_meetups) > 0) {
            return $future_meetups;
        } else {
            return array();
        }
    }

    /**
     * Get all the past meetups as an array
     *
     * @return array of MeetupEntity objects
     */
    public function getPastMeetups()
    {
        $meetups = $this->getMeetupsList();

        $now = new \DateTime();

        $pastMeetups = [];

        foreach ($meetups as $meetup) {
            $date = $this->extractDateTimeFromMeetupFilename($meetup);
            $diff = $date->diff($now);
            if (!$diff->invert) {
                $pastMeetups[$date->format('Ymd')] = $this->getMeetup($meetup);
            }
        }

        arsort($pastMeetups);

        return $pastMeetups;
    }

    /**
     * Do a dumb extraction of the date from a meetup filename
     *
     * @param string $meetup
     * @return \DateTime
     */
    private function extractDateTimeFromMeetupFilename($meetup)
    {
        return new \DateTime(str_replace(".php", "", substr($meetup, strrpos($meetup, '/')+1)));
    }

    /**
     * Load an individual meetup file
     *
     * @param  string       $file The file (from the cached directory list)
     * @throws \Exception
     * @return MeetupEntity
     */
    public function getMeetup($file)
    {
        $fullpath = $this->meetupsDataPath . $file;

        if (!file_exists($fullpath)) {
            throw new \Exception("Could not find meetup data file: {$fullpath}");
        }

        $meetup = include $fullpath;

        if (!($meetup instanceof MeetupEntity)) {
            throw new \Exception("Meetup file {$fullpath} did not return a valid MeetupEntity instance");
        }

        return $meetup;
    }
}
