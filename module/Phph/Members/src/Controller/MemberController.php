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
        if($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost();
            $this->memberService->addMember($postData);

            return $this->redirect('member-pending');
        }

        return new ViewModel;
    }

    public function verifyAction()
    {
        $key = $this->getEvent()->getRouteMatch()->getParam('key');
        $this->memberService->verifyMember($key);

        return new ViewModel();
    }

    public function pendingAction()
    {
        return new ViewModel;
    }
}
