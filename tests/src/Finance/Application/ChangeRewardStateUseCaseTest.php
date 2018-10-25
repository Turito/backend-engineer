<?php

namespace Test\CSP\Finance\Application;

use CSP\Finance\Application\ChangeRewardStateUseCase;
use CSP\Finance\Domain\Entity\CashbackReward;
use CSP\Finance\Domain\Entity\Reward as RewardEntity;
use CSP\Finance\Domain\Entity\RewardPoints;
use CSP\Finance\Domain\Entity\RewardType;
use CSP\Finance\Domain\Entity\RewardState;
use CSP\Finance\Domain\Repository\RewardRepository;
use CSP\Shared\Domain\Service\UserService;
use PHPUnit\Framework\TestCase;

class ChangeRewardStateUseCaseTest extends TestCase
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
     * We check the behavior the state changes in a Cashback Reward
     * @return RewardEntity $reward
     */
    public function testChangeCashbackReward()
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
            ->setId(123123)
            ->setState($rewardState)
            ->setType($rewardType)
            ->setOriginalAmount(50)
            ->setCredit(10)
            ->setRewardPoints($rewardPoints)
            ->setIsActive(true)
            ->setIsIndirect(false);

        $rewardState = new RewardState();
        $rewardState->setName(RewardState::DONE_STATE)
                    ->setIsActive(true)
                    ->setText(RewardState::DONE_STATE);

        $rewardPoints = $this->changeRewardStateUseCase->run($this->userId, $reward, $rewardState);

        $this->assertEquals(1, count($this->changeRewardStateUseCase->events));
        $lastEvent = array_pop($this->changeRewardStateUseCase->events);
        $this->assertEquals("offerRewardStateChanged", $lastEvent['name']);

        $offerRewardCreatedDto = $lastEvent["data"];
        $this->assertEquals($reward->getId(), $offerRewardCreatedDto->getOfferId());
        $this->assertEquals($reward->getState()->getName(), $offerRewardCreatedDto->getStateName());
        $this->assertEquals($reward->getCredit(), $offerRewardCreatedDto->getCredit());
        $this->assertEquals($this->userId, $offerRewardCreatedDto->getUserId());


        return $reward;
    }


    /**
     * We check the behavior the state changes in a Direct Reward (but isn't Cashback)
     * @depends testChangeCashbackReward
     * @param RewardEntity $reward
     */
    public function testChangeDirectReward(RewardEntity $reward)
    {

        $rewardType = new RewardType();
        $rewardType->setName('cpc')
                    ->setIsPercent(true)
                    ->setText('cpc');

        $reward->setType($rewardType);

        $rewardState = new RewardState();
        $rewardState->setName(RewardState::PENDING_STATE)
                    ->setIsActive(true)
                    ->setText(RewardState::PENDING_STATE);

        $rewardPoints = $this->changeRewardStateUseCase->run($this->userId, $reward, $rewardState);

        $this->assertEquals(1, $rewardPoints->getUserRewardAmount());

        return $reward;
    }

    /**
     * We check the behavior the state changes in a referred reward
     * @depends testChangeDirectReward
     * @param RewardEntity $reward
     */
    public function testChangeRefererReward(RewardEntity $reward)
    {

        $rewardType = new RewardType();
        $rewardType->setName(RewardType::REWARD_TYPE_REFERER_CASHBACK)
                    ->setIsPercent(true)
                    ->setText(RewardType::REWARD_TYPE_REFERER_CASHBACK)
                    ->setDefaultUserRewardAmount(1)
                    ->setIsActive(true);

        $reward->setType($rewardType);

        $rewardState = new RewardState();
        $rewardState->setName(RewardState::DONE_STATE)
                    ->setIsActive(true)
                    ->setText(RewardState::DONE_STATE);

        $rewardPoints = $this->changeRewardStateUseCase->run($this->userId, $reward, $rewardState);
        
        $result = ($reward->getCredit() * 10) / 100;
        $this->assertEquals($result, $rewardPoints->getUserRewardAmount());
    }

    protected function tearDown()
    {
        $this->rewardRepository = null;
        $this->userService = null;
        $this->changeRewardStateUseCase = null;
    }
}
