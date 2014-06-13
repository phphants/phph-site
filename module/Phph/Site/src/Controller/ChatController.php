<?php

namespace Phph\Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ChatController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function helpAction()
    {
        return new ViewModel();
    }
}
