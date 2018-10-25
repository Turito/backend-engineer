<?php

namespace CSP\Finance\Domain\Entity;

class RewardType
{
    const REWARD_TYPE_CPC = 'cpc';
    const REWARD_TYPE_CPM = 'cpm';
    const REWARD_TYPE_CPL = 'cpl';
    const REWARD_TYPE_CASHBACK = 'cashback';
    const REWARD_TYPE_REFERER_CPC = 'referer_cpc';
    const REWARD_TYPE_REFERER_CPM = 'referer_cpm';
    const REWARD_TYPE_REFERER_CPL = 'referer_cpl';
    const REWARD_TYPE_REFERER_CASHBACK = 'referer_cashback';

    const DIRECT_REWARD_TYPES = array(
        self::REWARD_TYPE_CPC,
        self::REWARD_TYPE_CPM,
        self::REWARD_TYPE_CPL,
        self::REWARD_TYPE_CASHBACK,
    );

    const REFERER_REWARD_TYPES = array(
        self::REWARD_TYPE_REFERER_CPC,
        self::REWARD_TYPE_REFERER_CPM,
        self::REWARD_TYPE_REFERER_CPL,
        self::REWARD_TYPE_REFERER_CASHBACK
    );

    private $id;

    private $name;

    private $defaultUserRewardAmount = 0;

    private $isActive = true;

    private $text;

    private $isPercent;

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

    public function setDefaultUserRewardAmount($defaultUserRewardAmount)
    {
        $this->defaultUserRewardAmount = (double) $defaultUserRewardAmount;
        return $this;
    }

    public function getDefaultUserRewardAmount()
    {
        return (double) $this->defaultUserRewardAmount;
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

    public function setIsPercent($isPercent)
    {
        $this->isPercent = (bool) $isPercent;
        return $this;
    }

    public function isPercent()
    {
        return (bool) $this->isPercent;
    }
}
