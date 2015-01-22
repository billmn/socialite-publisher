<?php namespace App\Social;

use Laravel\Socialite\Contracts\Factory as Socialite;

abstract class Driver {

	protected $social;

	public function __construct(Socialite $social)
	{
		$driver = $this->getDriver();

		// Set redirect URL
		config([
			"services.{$driver}.redirect" => route('social.callback', $driver)
		]);

		$this->social = $social->driver($this->getDriver());
	}

	public function getDriver()
	{
		$class = class_basename(get_class($this));

		return strtolower($class);
	}

	public function authenticate()
	{
		return $this->social->redirect();
	}

}