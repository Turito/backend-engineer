<?php

namespace CSP\Finance\Domain\Entity;

class Reward
{
    private $id;

    private $credit = 0;

    private $isIndirect = false;

    private $isActive = true;

    private $state;

    private $type;

    private $user;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCredit($credit)
    {
        $this->credit = (double) $credit;
        return $this;
    }

    public function getCredit()
    {
        return (double) $this->credit;
    }

    public function setIsIndirect($isIndirect)
    {
        $this->isIndirect = (bool) $isIndirect;
        return $this;
    }

    public function isIndirect()
    {
        return (bool) $this->isIndirect;
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

    public function setState(RewardState $state)
    {
        $this->state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setType(RewardType $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return boolean
     */
    public function isDirectReward()
    {
        return in_array($this->getType()->getName(), RewardType::DIRECT_REWARD_TYPES);
    }

    /**
     * @return boolean
     */
    public function isRefererReward()
    {
        return in_array($this->getType()->getName(), RewardType::REFERER_REWARD_TYPES);
    }

    /**
     * @return boolean
     */
    public function isCashback()
    {
        return ($this->getType()->getName() == RewardType::REWARD_TYPE_CASHBACK);
    }
}
