<?php

namespace Phph\Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SponsorsController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
