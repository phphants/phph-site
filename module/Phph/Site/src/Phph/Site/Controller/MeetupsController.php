<?php

namespace Phph\Site\Controller;

use Phph\Site\Service\MeetupsService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MeetupsController extends AbstractActionController
{
    /**
     * Assign the Meetups Service
     *
     * @param Phph\Site\Service\MeetupsService
     * @return void
     */
    public function setMeetupsService(MeetupsService $meetupsService)
    {
        $this->meetupsService = $meetupsService;
    }

    /**
     * Meetups Index
     *
     * @return Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            array(
                'future_meetups' => $this->meetupsService->getFutureMeetups(),
            )
        );
    }
}
