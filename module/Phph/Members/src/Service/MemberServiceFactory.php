<?php

namespace Phph\Members\Service;

use Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MemberServiceFactory implements FactoryInterface
{
    /**
     * Build the MemberService
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return MemberService
     * @throws Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        if (!isset($config['phph-site'])) {
            throw new Exception('phph-site config not found');
        }

        if (!isset($config['phph-site']['membersDataPath'])) {
            throw new Exception('Members data path config not found');
        }
        $membersDataPath = $config['phph-site']['membersDataPath'];

        $memberService = new MemberService;
        $memberService->setMembersDataPath($membersDataPath);

        return $memberService;
    }
}
