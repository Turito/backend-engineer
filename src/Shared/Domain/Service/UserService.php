<?php

namespace CSP\Shared\Domain\Service;

use CSP\Finance\Domain\Entity\RewardPoints;

interface UserService
{
	/**
	* @param int $userId
	* @param Reward $reward
	*/
    public function addPoints($userId, RewardPoints $rewardPoints);

	/**
	* @param int $userId
	* @param Reward $reward
	*/
    public function subPoints($userId, RewardPoints $rewardPoints);
}
