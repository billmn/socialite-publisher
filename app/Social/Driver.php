<?php namespace App\Social;

use GuzzleHttp\Client;
use Laravel\Socialite\Contracts\Factory as Socialite;

abstract class Driver {

	protected $client;
	protected $driver;
	protected $provider;
	protected $socialite;

	public function __construct(Socialite $socialite)
	{
		$this->driver = $this->getDriver();

		// Set redirect URL
		config([
			"services.{$this->driver}.redirect" => route('social.callback', $this->driver)
		]);

		$this->client    = new Client;
		$this->provider  = $socialite->driver($this->getDriver());
		$this->socialite = $socialite;
	}

	public function getDriver()
	{
		$class = class_basename(get_class($this));

		return strtolower($class);
	}

	public function is($driver)
	{
		return strtolower($driver) === $this->driver;
	}

	public function authenticate()
	{
		return $this->provider->redirect();
	}

	public function user()
	{
		return (array) $this->provider->user();
	}

	public function getClient()
	{
		return $this->client;
	}

	public function getProvider()
	{
		return $this->provider;
	}

	public function getSocialite()
	{
		return $this->socialite;
	}

	public function getToken()
	{
		return $this->getInfo('token');
	}

	public function getInfo($key = null)
	{
		$file    = app('filesystem.disk');
		$content = $file->get("{$this->driver}.json");

		$info = json_decode($content, true);

		return $key ? array_get($info, $key) : $info;
	}

	public function saveInfo(array $info)
	{
		$file    = app('filesystem.disk');
		$content = $info + $this->getInfo();

		if ($file->put("{$this->driver}.json", json_encode($content)))
		{
			return $this->getInfo();
		}

		return false;
	}


	abstract public function publish(array $values);

}