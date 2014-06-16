<?php

namespace Phph\Members\Service;

use Exception;
use Zend\Stdlib\Parameters;

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
     * Get a list of members
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
        if (!isset($postData['email'])) {
            return false;
        }
        $member = array();
        $member['name'] = isset($postData['name'])?$postData['name']:'';
        $member['twitter'] = isset($postData['twitter'])?$postData['twitter']:'';
        $member['email'] = $postData['email'];
        $member['website'] = isset($postData['website'])?$postData['website']:'';
        $member['live'] = false;
        $member['key'] = mt_rand();

        $members = $this->getMemberList();
        $members[] = $member;

        $json = json_encode($members);

        if (!file_put_contents($this->membersDataPath, $json))
        {
            return false;
        }
        $this->sendConfirmation($member);

        return true;
    }

    private function sendConfirmation($member)
    {
        list($firstName, $lastName) = explode(' ', $member['name']);

        $url = 'http://localhost:8000';//@todo
        $path = '/members/verify/';//@todo

        $to = $member['email'];
        $subject = 'Verify registration to PHP Hampshire';

        $message = '';
        $message .= 'Hi ' . $firstName . PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'Someone tried to register as a member to PHP Hampshire using this email address. ' . PHP_EOL;
        $message .= 'If this was you please click the following link to confirm your registration.' . PHP_EOL;
        $message .= PHP_EOL;
        $message .= $url . $path . $member['key'] . PHP_EOL;
        $message .= PHP_EOL;

        $headers = '';
        $headers .= 'From: info@phphants.co.uk' . "\r\n";
        $headers .= 'Reply-To: info@phphants.co.uk' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    public function verifyMember($key)
    {
        $memberList = $this->getMemberList(true);
        $members = array();

        foreach ($memberList as $member)
        {
            if ($key == $member['key']) {
                $member['live'] = true;
            }
            $members[] = $member;
        }
        $json = json_encode($members);
        file_put_contents($this->membersDataPath, $json);
    }
}
