<?php
declare(strict_types=1);

namespace App\Entity;

class Talk
{
    /**
     * @var string
     */
    private $speakerName;

    /**
     * @var string
     */
    private $speakerTwitter;

    /**
     * @var string
     */
    private $talkName;

    /**
     * @var string
     */
    private $abstract;

    public function __construct(string $speakerName, string $speakerTwitter, string $talkName, string $abstract = null)
    {
        $this->speakerName = $speakerName;
        $this->speakerTwitter = $speakerTwitter;
        $this->talkName = $talkName;
        $this->abstract = $abstract;
    }

    public function __toString() : string
    {
        $s = $this->getTalkName() . ' &mdash; <em>(by ';

        if ($this->getSpeakerTwitter() !== '') {
            $s .= '<strong><a href="https://twitter.com/' . $this->getSpeakerTwitter() . '">'
                . $this->getSpeakerName()
                . '</a></strong>';
        } else {
            $s .= '<strong>' . $this->getSpeakerName() . '</strong>';
        }

        $s .= ')</em>';

        $abstract = $this->getAbstract();
        if (null !== $abstract && '' !== $abstract) {
            $s .= '<br /><p class="talk-abstract">' . $abstract . '</p>';
        }

        return $s;
    }

    public function setSpeakerName(string $speakerName) : self
    {
        $this->speakerName = $speakerName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpeakerName()
    {
        return $this->speakerName;
    }

    public function setSpeakerTwitter(string $speakerTwitter) : self
    {
        $this->speakerTwitter = $speakerTwitter;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpeakerTwitter() : string
    {
        return $this->speakerTwitter;
    }

    public function setTalkName(string $talkName) : self
    {
        $this->talkName = $talkName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTalkName()
    {
        return $this->talkName;
    }

    public function setAbstract(string $abstract) : self
    {
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbstract()
    {
        return $this->abstract;
    }
}
