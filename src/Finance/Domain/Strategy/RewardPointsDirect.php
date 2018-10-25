<?php

namespace CSP\Finance\Domain\Strategy;

use CSP\Finance\Domain\Entity\RewardPoints;

class RewardPointsDirect implements RewardPointsInterface
{
	private $rewardPoints;

	public function __construct()
	{
		$this->rewardPoints = new RewardPoints();
	}

	/**
	 * @return RewardPoints
	 */
	public function create()
	{
        return $this->rewardPoints
                    ->setUserRewardAmount(1)
                    ->setRefererRewardAmount(1)
                    ->setAdvertiserRewardAmount(2);
	}
}