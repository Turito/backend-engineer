<?php
namespace CSP\Finance\Application;

class RewardException extends \Exception
{

	/**
	* @return string
	*/
	public static function hasNotState()
	{
		return new self(
			"Reward has not initial State"
		);
	}
	
	/**
	* @return string
	*/
	public static function hasNotType()
	{
		return new self(
			"Reward has not initial Type"
		);
	}

	/**
	* @return string
	*/
	public static function notChange()
	{
		return new self(
			"State not change"
		);
	}
}