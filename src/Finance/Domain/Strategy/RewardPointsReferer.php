<?php

namespace CSP\Finance\Domain\Strategy;

use CSP\Finance\Domain\Entity\Reward as RewardEntity;
use CSP\Finance\Domain\Entity\RewardPoints;

class RewardPointsReferer implements RewardPointsInterface
{
	private $reward;
	private $rewardPoints;

	public function __construct(RewardEntity $reward)
	{
		$this->reward = $reward;
		$this->rewardPoints = new RewardPoints();
	}

	/**
	 * @return RewardPoints
	 */
	public function create()
	{
		return $this->rewardPoints
					->setUserRewardAmount( ( $this->reward->getCredit() * 10 ) / 100 );
	}
}