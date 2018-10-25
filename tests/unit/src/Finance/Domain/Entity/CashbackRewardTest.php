<?php

namespace Test\CSP\Finance\Application;

use CSP\Finance\Domain\Entity\CashbackReward;
use CSP\Finance\Domain\Entity\Reward;
use CSP\Finance\Domain\Entity\RewardPoints;
use CSP\Finance\Domain\Entity\RewardType;
use CSP\Finance\Domain\Entity\RewardState;
use PHPUnit\Framework\TestCase;

class CashbackRewardTest extends TestCase
{
    private $reward;

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

        $this->reward = new CashbackReward();
        $this->reward
                ->setState($rewardState)
                ->setType($rewardType)
                ->setRewardPoints($rewardPoints)
                ->setOriginalAmount(50)
                ->setCredit(10);
    }

    public function testCreateRewardPoints()
    {
        $rewardPoints = $this->reward->createRewardPoints();

        $this->assertEquals(1, $rewardPoints->getUserRewardAmount());
    }

    protected function tearDown()
    {
        $this->reward = null;
    }

}
