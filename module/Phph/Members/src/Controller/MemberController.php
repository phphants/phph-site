<?php

namespace Phph\Members\Controller;

use Phph\Members\Service\MemberService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MemberController extends AbstractActionController
{
    /**
     * @var MemberService $memberService
     */
    protected $memberService;

    /**
     * Assign the MemberService
     *
     * @param MemberService $memberService
     *
     * @return MemberController
     */
    public function setMemberService(MemberService $memberService)
    {
        $this->memberService = $memberService;

        return $this;
    }

    public function indexAction()
    {
        $members = $this->memberService->getMemberList();

        return new ViewModel(
            array(
                'members' => $members,
            )
        );
    }

    public function registerAction()
    {
        $postData = array(
            'name' => 'Richard Holloway',
            'twitter' => 'richardjh_org',
            'email' => 'richard@webok.co.uk',
            'website' => 'http://richardjh.org',
        );

        $this->memberService->addMember($postData);

        return new ViewModel();
    }

    public function confirmAction()
    {
        $key = $this->getEvent()->getParam('key');
        $this->memberService->confirmMember($key);

        return new ViewModel();
    }
}