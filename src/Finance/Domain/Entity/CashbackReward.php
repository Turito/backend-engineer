<?php

namespace CSP\Finance\Domain\Entity;

class CashbackReward extends Reward
{
    private $rewardPoints;

    private $originalAmount;

    public function setRewardPoints(RewardPoints $rewardPoints)
    {
        $this->rewardPoints = $rewardPoints;
        return $this;
    }

    public function getRewardPoints()
    {
        return $this->rewardPoints;
    }

    public function setOriginalAmount($amount)
    {
        $this->originalAmount = $amount;
        return $this;
    }

    public function getOriginalAmount()
    {
        return $this->originalAmount;
    }

    /**
     * Create a new reward points for user
     * @return RewardPoints
     */
    public function createRewardPoints()
    {
        $rewardPoints = $this->getRewardPoints();

        $credit = $rewardPoints->getUserRewardAmount();
        $advertiserCredit = 0;
        
        if ($this->isDirectReward()) {
            $advertiserCredit = $rewardPoints->getAdvertiserRewardAmount();

            if ($rewardPoints->isPercent()) {
                $credit = ( $this->getCredit() * $credit ) / 100;
                $advertiserCredit = ( $this->getCredit() * $advertiserCredit ) / 100;
            }
        }

        $createdRewardPoints = new RewardPoints();

        return $createdRewardPoints
                    ->setUserRewardAmount($credit)
                    ->setRefererRewardAmount($rewardPoints->getRefererRewardAmount())
                    ->setAdvertiserRewardAmount($advertiserCredit);
    }
}
