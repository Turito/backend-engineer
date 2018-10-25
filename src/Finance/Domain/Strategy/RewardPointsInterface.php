<?php

namespace CSP\Finance\Domain\Strategy;

use CSP\Finance\Domain\Entity\RewardPoints;

interface RewardPointsInterface
{
	/**
     * @return RewardPoints
     */
    public function create();
}