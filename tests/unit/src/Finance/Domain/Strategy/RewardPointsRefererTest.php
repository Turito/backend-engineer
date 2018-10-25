<?php

namespace Test\CSP\Finance\Application;

use CSP\Finance\Domain\Strategy\RewardPointsReferer;
use CSP\Finance\Domain\Entity\Reward as RewardEntity;
use PHPUnit\Framework\TestCase;

class RewardPointsRefererTest extends TestCase
{
    private $rewardPointsStrategy;

    protected function setUp()
    {

        $reward = new RewardEntity();
        $reward->setCredit(10);

        $this->rewardPointsStrategy = new RewardPointsReferer($reward);
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
