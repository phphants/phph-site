<?php

namespace Phph\Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Phph\Site\Service\MeetupsService;
use Sabre\VObject\Component\VCalendar;

class MeetupsController extends AbstractActionController
{
    /**
     * @var \Phph\Site\Service\MeetupsService
     */
    protected $meetupsService;

    /**
     * Assign the Meetups Service
     *
     * @param \Phph\Site\Service\MeetupsService
     * @return void
     */
    public function setMeetupsService(MeetupsService $meetupsService)
    {
        $this->meetupsService = $meetupsService;
    }

    /**
     * Meetups Index
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'future_meetups' => $this->meetupsService->getFutureMeetups(),
        ];
    }

    public function icalAction()
    {
        $cal = new VCalendar();

        $meetups = $this->meetupsService->getFutureMeetups();

        foreach ($meetups as $meetup) {
            $from = $meetup->getFromDate();
            $from->setTimezone(new \DateTimeZone('Europe/London'));

            $month = $from->format('F');
            $year = $from->format('Y');

            $cal->add('VEVENT', array(
                'SUMMARY' => sprintf('PHP Hampshire %s %d Meetup', $month, $year),
                'DTSTART' => $from,
                'DTEND' => $meetup->getToDate(),
            ));
        }

        $response = $this->getResponse();
        $response->setContent($cal->serialize());
        $response->getHeaders()->addHeaderLine('Content-Type', 'text/calendar');
        return $response;
    }

    public function subscribeAction()
    {
        return $this->redirect()->toUrl('http://eepurl.com/DaINX')->setStatusCode(302);
    }
}
