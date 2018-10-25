<?php

namespace Test\CSP\Finance\Application;

use CSP\Finance\Domain\Strategy\RewardPointsDirect;
use CSP\Finance\Domain\Entity\RewardPoints;
use PHPUnit\Framework\TestCase;

class RewardPointsDirectTest extends TestCase
{
    private $rewardPointsStrategy;

    protected function setUp()
    {
        $this->rewardPointsStrategy = new RewardPointsDirect();
    }

    public function testCreateRewardPointsStrategy()
    {
        $rewardPoints = $this->rewardPointsStrategy->create();

        $this->assertEquals(1, $rewardPoints->getUserRewardAmount());
    }

    protected function tearDown()
    {
        $this->rewardPointsStrategy = null;
    }

}
