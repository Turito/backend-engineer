<?php

namespace CSP\Finance\Application;

use CSP\Finance\Application\RewardException;
use CSP\Finance\Application\Dto\OfferRewardCreatedDto;
use CSP\Finance\Domain\Entity\Reward as RewardEntity;
use CSP\Finance\Domain\Entity\RewardPoints;
use CSP\Finance\Domain\Entity\RewardState;
use CSP\Finance\Domain\Strategy\RewardPointsDirectCashback;
use CSP\Finance\Domain\Strategy\RewardPointsDirect;
use CSP\Finance\Domain\Strategy\RewardPointsReferer;
use CSP\Finance\Domain\Repository\RewardRepository;
use CSP\Shared\Domain\Service\UserService;

/**
 * Multipurpose use case
 * Class ChangeRewardStateUseCase
 * @package CSP\Finance\Application
 */
class ChangeRewardStateUseCase
{
    // Property used only for backend test purpose
    public $events;

    private $rewardRepository;

    private $userService;

    public function __construct(RewardRepository $rewardRepository, UserService $userService)
    {
        $this->rewardRepository = $rewardRepository;
        $this->userService = $userService;
    }

    /**
     * Change state of reward
     * @param int $userId
     * @param Reward $reward
     * @param RewardState $rewardState
     * @return RewardPoints
     */
    public function run($userId, RewardEntity $reward, RewardState $rewardState)
    {
        $this->assertRewardStateCanChange($reward, $rewardState); 

        $rewardOriginalStateName = $reward->getState()->getName();

        $reward->setState($rewardState);
        $this->rewardRepository->saveReward($reward);

        // Prepare user points if we are validating a reward
        if ($reward->isDirectReward()) {
            if ($reward->isCashback()) {
                $rewardPointsStrategy = new RewardPointsDirectCashback($reward);

                $this->createOfferRewardDto($userId, $reward);
            } else {
                $rewardPointsStrategy = new RewardPointsDirect();
            }
        } elseif ($reward->isRefererReward()) {
            $rewardPointsStrategy = new RewardPointsReferer($reward);
        }

        $rewardPoints = $rewardPointsStrategy->create();

        // Add points to the user or remove them depending on state change
        if ($rewardState->getName() == RewardState::DONE_STATE) {
            $this->userService->addPoints(
                $userId,
                $rewardPoints
            );
        } elseif ($rewardOriginalStateName == RewardState::DONE_STATE) {
            $this->userService->subPoints(
                $userId,
                $rewardPoints
            );
        }

        // Finally, find its parent, and change its reward state if needed
        $this->changeRefererRewardState($reward, $rewardState);

        return $rewardPoints;
    }

    /**
     * Validate if can change state of reward. We verify that the state has changed
     * @param Reward $reward
     * @param RewardState $rewardState
     */
    private function assertRewardStateCanChange(RewardEntity $reward, RewardState $rewardState)
    {
        if (empty($reward->getState())) {
            throw RewardException::hasNotState();
        }

        if (empty($reward->getType())) {
            throw RewardException::hasNotType();
        }

        if ($reward->getState() == $rewardState) {
            throw RewardException::notChange();
        }
    }

    /**
     * Publish event and create dto when reward is done and is a direct reward
     * @see ChangeRewardStateUseCase::run
     * @param int $userId
     * @param Reward $reward
     */
    private function createOfferRewardDto($userId, RewardEntity $reward)
    {
        if ($reward->getState()->getName() == RewardState::DONE_STATE && !$reward->isIndirect()) {
            $offerRewardCreateDto = new OfferRewardCreatedDto(
                $reward->getId(),
                $reward->getState()->getName(),
                $reward->getCredit(),
                $userId
            );

            $this->publish('offerRewardStateChanged', $offerRewardCreateDto);
        }
    }
    
    /**
     * Change state of parent referer reward
     * @see ChangeRewardStateUseCase::run
     * @param Reward $reward
     * @param RewardState $rewardState
     * @return RewardPoints
     */
    private function changeRefererRewardState(RewardEntity $reward, RewardState $rewardState)
    {
        $refererReward = $this->rewardRepository->findOneByParent($reward);

        if (!empty($refererReward)) {
            return $this->run($refererReward->getUserId(), $refererReward, $rewardState);
        }
    }

    /**
     * Method used only for backend test purpose
     * @param string $eventName
     * @param $dto
     */
    private function publish($eventName, $dto)
    {
        $this->events[] = ['name' => $eventName, 'data' => $dto];
    }
}