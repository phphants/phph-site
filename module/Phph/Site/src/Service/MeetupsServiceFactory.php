<?php

namespace Phph\Site\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MeetupsServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $service = new MeetupsService(realpath($config['phph-site']['meetupsDataPath']));

        return $service;
    }
}
