<?php

namespace Phph\Site\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MeetupsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller = new MeetupsController();
        $controller->setMeetupsService($serviceLocator->getServiceLocator()->get('MeetupsService'));

        return $controller;
    }
}
