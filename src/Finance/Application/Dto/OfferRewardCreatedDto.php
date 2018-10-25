<?php

namespace CSP\Finance\Application\Dto;

class OfferRewardCreatedDto
{
    private $offerId;
    private $stateName;
    private $credit;
    private $userId;

    public function __construct(
        $offerId,
        $stateName,
        $credit,
        $userId
    ) {
        $this->offerId = $offerId;
        $this->stateName = $stateName;
        $this->credit = $credit;
        $this->userId = $userId;
    }

    public function getOfferId()
    {
        return $this->offerId;
    }

    public function getStateName()
    {
        return $this->stateName;
    }

    public function getCredit()
    {
        return $this->credit;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
