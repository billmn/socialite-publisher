<?php namespace App\Social;

use Laravel\Socialite\Contracts\Factory as Socialite;

class Social {

	protected $socialite;

	public function __construct(Socialite $socialite)
	{
		$this->socialite = $socialite;
	}

	public function driver($driver)
	{
		$class = __NAMESPACE__ . "\\Drivers\\" . studly_case($driver);

		return new $class($this->socialite);
	}

	public function getSocialite()
	{
		return $this->socialite;
	}

}