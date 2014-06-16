<?php

namespace Phph\Members\Service;

use Zend\Filter\StripTags;
use Zend\Stdlib\Parameters;
use Zend\Validator\EmailAddress;

class MemberService
{
    /**
     * @var string
     */
    protected $membersDataPath;

    /**
     * @param string $membersDataPath
     *
     * @return MemberService
     */
    public function setMembersDataPath($membersDataPath)
    {
        $this->membersDataPath = $membersDataPath;

        return $this;
    }

    /**
     * Get a list of live members, or all members if $showAll is true
     *
     * @param bool $showAll
     *
     * @return array
     */
    public function getMemberList($showAll = false)
    {
        $filePath = $this->membersDataPath;

        if (!file_exists($filePath)) {

            return array();
        }
        $json = file_get_contents($filePath);
        $memberData = json_decode($json);

        if(!is_array($memberData)) {

            return array();
        }

        $members = array();

        foreach($memberData as $row) {
            $member = array();
            $member['name'] = $row->name;
            $member['twitter'] = $row->twitter;
            $member['email'] = $row->email;
            $member['website'] = $row->website;
            $member['live'] = $row->live;
            $member['key'] = $row->key;

            if ($row->live || $showAll) {
                $members[] = $member;
            }
        }

        return $members;
    }

    /**
     * Add a member
     *
     * @param Parameters $postData
     *
     * @return bool
     */
    public function addMember($postData)
    {
        $emailValidator = new EmailAddress();
        $stripTags = new StripTags();


        if (!isset($postData['email']) or !$emailValidator->isValid($postData['email'])) {

            return false;
        }
        $member = array();
        $member['name'] = isset($postData['name'])?$stripTags->filter($postData['name']):'';
        $member['twitter'] = isset($postData['twitter'])?$stripTags->filter($postData['twitter']):'';
        $member['email'] = $postData['email'];
        $member['website'] = isset($postData['website'])?$stripTags->filter($postData['website']):'';
        $member['live'] = false;
        $member['key'] = mt_rand();

        $members = $this->getMemberList();
        $members[] = $member;

        $json = json_encode($members);

        if (!file_put_contents($this->membersDataPath, $json))
        {
            return false;
        }

        return $this->sendConfirmation($member);
    }

    /**
     * Send email confirmation with verification link
     *
     * @param array $member
     * @return bool
     */
    private function sendConfirmation($member)
    {
        if (!isset($member['email'])) {

            return false;
        }
        $nameParts = explode(' ', $member['name']);
        $firstName = $nameParts[0];
        $verifyLink = $_SERVER['HTTP_HOST'] . '/members/verify/';

        $to = $member['email'];
        $subject = 'Verify registration to PHP Hampshire';

        $message = '';
        $message .= 'Hi ' . $firstName . PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'Someone tried to register as a member to PHP Hampshire using this email address. ' . PHP_EOL;
        $message .= 'If this was you please click the following link to confirm your registration.' . PHP_EOL;
        $message .= PHP_EOL;
        $message .= $verifyLink . $member['key'] . PHP_EOL;
        $message .= PHP_EOL;

        $headers = '';
        $headers .= 'From: info@phphants.co.uk' . "\r\n";
        $headers .= 'Reply-To: info@phphants.co.uk' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        return mail($to, $subject, $message, $headers);
    }

    /**
     * Update the status of a member with matching key, to live.
     * Return true if the key matches a record.
     *
     * @param string $key
     * @return bool
     */
    public function verifyMember($key)
    {
        $memberList = $this->getMemberList(true);
        $members = array();
        $hit = false;

        foreach ($memberList as $member)
        {
            if ($key == $member['key']) {
                $member['live'] = true;
                $hit = true;
            }
            $members[] = $member;
        }
        $json = json_encode($members);
        file_put_contents($this->membersDataPath, $json);

        return $hit;
    }
}
