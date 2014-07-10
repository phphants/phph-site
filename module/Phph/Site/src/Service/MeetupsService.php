<?php

namespace Phph\Site\Service;

use Phph\Site\Model\MeetupEntity;

use Zend\Mvc\Controller\AbstractActionController;

class MeetupsService extends AbstractActionController
{
    private $meetupsDataPath;
    private $cachedDirectoryListing;

    /**
     * Assign the meetups data path
     *
     * @param  string $meetupsDataPath
     * @return void
     */
    public function setMeetupsDataPath($meetupsDataPath)
    {
        $this->meetupsDataPath = (string) $meetupsDataPath;
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

            $directoryIterator = new \DirectoryIterator($this->meetupsDataPath);

            foreach ($directoryIterator as $file) {
                /* @var $file \DirectoryIterator */
                if (substr($file->getFilename(), -4) == '.php') {
                    $this->cachedDirectoryListing[] = $file->getFilename();
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
            $date = new \DateTime(str_replace(".php", "", $meetup));
            $diff = $date->diff($now);
            if ($diff->invert || $diff->days == 0) {
                $future_meetups[$date->format('Ymd')] = $this->getMeetup($meetup);
            }
        }

        asort($future_meetups);

        if (count($future_meetups) > 0) {
            return array(reset($future_meetups));
        } else {
            return array();
        }
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
