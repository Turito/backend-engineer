<?php

namespace CSP\Finance\Domain\Entity;

class RewardPoints
{
    private $id;
    private $isPercent = false;
    private $userRewardAmount = 0;
    private $refererRewardAmount = 0;
    private $advertiserRewardAmount = 0;

    public function getId()
    {
        return $this->id;
    }

    public function setPercent($isPercent)
    {
        $this->isPercent = (bool) $isPercent;
        return $this;
    }

    public function isPercent()
    {
        return (bool) $this->isPercent;
    }

    public function setUserRewardAmount($userRewardAmount)
    {
        $this->userRewardAmount = (double) $userRewardAmount;
        return $this;
    }

    public function getUserRewardAmount()
    {
        return (double) $this->userRewardAmount;
    }

    public function setRefererRewardAmount($refererRewardAmount)
    {
        $this->refererRewardAmount = (double) $refererRewardAmount;
        return $this;
    }

    public function getRefererRewardAmount()
    {
        return (double) $this->refererRewardAmount;
    }

    public function setAdvertiserRewardAmount($advertiserRewardAmount)
    {
        $this->advertiserRewardAmount = (double) $advertiserRewardAmount;
        return $this;
    }

    public function getAdvertiserRewardAmount()
    {
        return (double) $this->advertiserRewardAmount;
    }
}
