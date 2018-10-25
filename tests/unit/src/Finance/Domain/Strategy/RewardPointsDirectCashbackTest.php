<?php

namespace Test\CSP\Finance\Application;

use CSP\Finance\Domain\Strategy\RewardPointsDirectCashback;
use CSP\Finance\Domain\Entity\CashbackReward;
use CSP\Finance\Domain\Entity\RewardPoints;
use CSP\Finance\Domain\Entity\RewardType;
use CSP\Finance\Domain\Entity\RewardState;
use PHPUnit\Framework\TestCase;

class RewardPointsDirectCashbackTest extends TestCase
{
    private $rewardPointsStrategy;

    protected function setUp()
    {
        $rewardPoints = new RewardPoints();
        $rewardPoints
            ->setPercent(true)
            ->setUserRewardAmount(10);

        $rewardState = new RewardState();
        $rewardState->setName(RewardState::PENDING_STATE)
                    ->setIsActive(true)
                    ->setText(RewardState::PENDING_STATE);

        $rewardType = new RewardType();
        $rewardType->setName('cashback')
                    ->setIsPercent(true)
                    ->setText('cashback');

        $reward = new CashbackReward();
        $reward
                ->setState($rewardState)
                ->setType($rewardType)
                ->setRewardPoints($rewardPoints)
                ->setOriginalAmount(50)
                ->setCredit(10);

        $this->rewardPointsStrategy = new RewardPointsDirectCashback($reward);
    }

    public function testCreateRewardPointsStrategy()
    {
        $rewardPoints = $this->rewardPointsStrategy->create();

        $this->assertEquals(1, $rewardPoints->getUserRewardAmount());
    }

    protected function tearDown()
    {
        $this->reward = null;
    }

}
