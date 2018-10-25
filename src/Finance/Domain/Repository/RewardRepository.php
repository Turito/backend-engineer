<?php

namespace CSP\Finance\Domain\Repository;

use CSP\Finance\Domain\Entity\Reward;

interface RewardRepository
{
    /**
     * @param Reward $reward
     * @return Reward
     */
    public function saveReward(Reward $reward);

    /**
     * @param Reward $reward
     * @return Reward|null
     */
    public function findOneByParent(Reward $reward);

    /**
     * @param array $criteria
     * @return Reward|null
     */
    public function findOneBy(array $criteria);
}