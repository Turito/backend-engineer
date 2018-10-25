<?php

namespace CSP\Finance\Domain\Entity;

class RewardState
{
    const PENDING_STATE = 'pending';
    const IN_PROGRESS_STATE = 'in_progress';
    const DONE_STATE = 'done';
    const REFUSED_STATE = 'refused';

    protected $id;

    protected $name;

    protected $isActive = true;

    protected $text;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = (bool) $isActive;
        return $this;
    }

    public function getIsActive()
    {
        return (bool) $this->isActive;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }
}
