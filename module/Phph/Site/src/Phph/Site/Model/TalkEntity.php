<?php

namespace Phph\Site\Model;

class TalkEntity
{
    protected $speakerName;
    protected $speakerTwitter;
    protected $talkName;

    public function __construct($speakerName, $speakerTwitter, $talkName)
    {
        $this->speakerName = $speakerName;
        $this->speakerTwitter = $speakerTwitter;
        $this->talkName = $talkName;
    }

    public function __toString()
    {
        $s = $this->getTalkName() . ' &mdash; <em>(by ';

        if ($this->getSpeakerTwitter() != '') {
            $s .= '<a href="https://twitter.com/' . $this->getSpeakerTwitter() . '">' . $this->getSpeakerName() . '</a>';
        } else {
            $s .= $this->getSpeakerName();
        }

        $s .= ')</em>';
        return $s;
    }

    public function setSpeakerName($speakerName)
    {
        $this->speakerName = (string)$speakerName;

        return $this;
    }

    public function getSpeakerName()
    {
        return $this->speakerName;
    }

    public function setSpeakerTwitter($speakerTwitter)
    {
        $this->speakerTwitter = (string)$speakerTwitter;

        return $this;
    }

    public function getSpeakerTwitter()
    {
        return $this->speakerTwitter;
    }

    public function setTalkName($talkName)
    {
        $this->talkName = (string)$talkName;

        return $this;
    }

    public function getTalkName()
    {
        return $this->talkName;
    }
}
