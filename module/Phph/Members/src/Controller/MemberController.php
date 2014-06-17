<?php

namespace Phph\Members\Controller;

use Phph\Members\Service\MemberService;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\EmailAddress;
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

    /**
     * Display index page
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $members = $this->memberService->getMemberList();

        return new ViewModel(
            array(
                'members' => $members,
            )
        );
    }

    /**
     * Register a member
     *
     * @return Response|ViewModel
     */
    public function registerAction()
    {
        if($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost();

            $emailValidator = new EmailAddress();
            $errors = array();

            if (!isset($postData['email']) or !$emailValidator->isValid($postData['email'])) {
                $errors['emailError'] = 'You must enter a valid email address';
            }

            if (!isset($postData['name']) or 0 == strlen(trim($postData['name']))) {
                $errors['nameError'] = 'You must enter a name';
            }

            if (!$this->memberService->addMember($postData)) {

                $errors['generalError'] = 'Unable to register at this time';
            }

            if (0 < count($errors)) {

                return new ViewModel(
                    array(
                        'errors' => $errors,
                    )
                );
            }

            return $this->redirect()->toRoute('member-pending');
        }

        return new ViewModel;
    }

    /**
     * Verify the registration link
     *
     * @return Response|ViewModel
     */
    public function verifyAction()
    {
        $key = $this->getEvent()->getRouteMatch()->getParam('key');
        if (!$this->memberService->verifyMember($key)) {

            return $this->redirect()->toRoute('member-verify-fail');
        }

        return new ViewModel();
    }

    /**
     * Display verification failure page
     *
     * @return ViewModel
     */
    public function verifyFailAction()
    {
        return new ViewModel;
    }

    /**
     * Display registration pending page
     *
     * @return ViewModel
     */
    public function pendingAction()
    {
        return new ViewModel;
    }
}
