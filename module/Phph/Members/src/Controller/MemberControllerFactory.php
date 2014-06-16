<?php

namespace Phph\Members\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MemberControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $memberService = $serviceLocator->getServiceLocator()->get('Phph\Members\Service\MemberService');
        $memberController = new MemberController;
        $memberController->setMemberService($memberService);

        return $memberController;
    }
}