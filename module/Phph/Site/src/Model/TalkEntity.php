<?php

namespace Phph\Site\Model;

class TalkEntity
{
    protected $speakerName;
    protected $speakerTwitter;
    protected $talkName;
    protected $abstract;

    public function __construct($speakerName, $speakerTwitter, $talkName, $abstract = null)
    {
        $this->speakerName = $speakerName;
        $this->speakerTwitter = $speakerTwitter;
        $this->talkName = $talkName;
        $this->abstract = $abstract;
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

        $abstract = $this->getAbstract();
        if (!empty($abstract)) {
            $s .= '<br /><p class="talk-abstract">' . $abstract . '</p>';
        }

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

    public function setAbstract($abstract)
    {
        $this->abstract = (string)$abstract;

        return $this;
    }

    public function getAbstract()
    {
        return $this->abstract;
    }
}
