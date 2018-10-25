<?php

namespace Test\CSP\Finance\Application;

use CSP\Finance\Application\ChangeRewardStateUseCase;
use CSP\Finance\Application\RewardException;
use CSP\Finance\Domain\Entity\CashbackReward;
use CSP\Finance\Domain\Entity\Reward;
use CSP\Finance\Domain\Entity\RewardPoints;
use CSP\Finance\Domain\Entity\RewardType;
use CSP\Finance\Domain\Entity\RewardState;
use CSP\Finance\Domain\Repository\RewardRepository;
use CSP\Shared\Domain\Service\UserService;
use PHPUnit\Framework\TestCase;

class ChangeRewardStateUseCaseExceptionTest extends TestCase
{
    private $changeRewardStateUseCase;
    private $userId = 112313;

    protected function setUp()
    {
        $rewardRepository = $this
            ->getMockBuilder(RewardRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userService = $this
            ->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->changeRewardStateUseCase = new ChangeRewardStateUseCase($rewardRepository, $userService);
    }

    /**
     * @expectedException CSP\Finance\Application\RewardException
     * @expectedExceptionMessage State not change
     */
    public function testThrowExceptionWhenIsSameState(){
        $rewardState = new RewardState();
        $rewardState->setName('pending')
                    ->setIsActive(true)
                    ->setText('pending');

        $rewardType = new RewardType();
        $rewardType->setName('cashback')
                    ->setIsPercent(true)
                    ->setText('cashback');

        $reward = new CashbackReward();
        $reward
            ->setState($rewardState)
            ->setType($rewardType)
            ->setOriginalAmount(50);

        $rewardPoints = $this->changeRewardStateUseCase->run($this->userId, $reward, $rewardState);
    }

    /**
     * @expectedException CSP\Finance\Application\RewardException
     * @expectedExceptionMessage Reward has not initial State
     */
    public function testThrowExceptionWhenRewardHasNotInitialState(){
        $reward = new CashbackReward();

        $rewardState = new RewardState();
        $rewardState->setName('pending')
                    ->setIsActive(true)
                    ->setText('pending');

        $rewardPoints = $this->changeRewardStateUseCase->run($this->userId, $reward, $rewardState);
    }

    /**
     * @expectedException CSP\Finance\Application\RewardException
     * @expectedExceptionMessage Reward has not initial Type
     */
    public function testThrowExceptionWhenRewardHasNotInitialType(){
        $rewardState = new RewardState();
        $rewardState->setName('pending')
                    ->setIsActive(true)
                    ->setText('pending');

        $reward = new CashbackReward();
        $reward
            ->setState($rewardState);

        $rewardPoints = $this->changeRewardStateUseCase->run($this->userId, $reward, $rewardState);
    }

    protected function tearDown()
    {
        $this->rewardRepository = null;
        $this->userService = null;
        $this->changeRewardStateUseCase = null;
    }
}
