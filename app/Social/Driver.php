<?php namespace App\Social;

use GuzzleHttp\Client;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

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

		$this->client    = $this->getClient();
		$this->provider  = $socialite->driver($this->driver);
		$this->socialite = $socialite;
	}

	/**
	 * Get driver name
	 *
	 * @return string
	 */
	public function getDriver()
	{
		$class = class_basename(get_class($this));

		return strtolower($class);
	}

	/**
	 * Check current driver
	 *
	 * @param  string  $driver Driver name
	 * @return boolean
	 */
	public function is($driver)
	{
		return strtolower($driver) === $this->driver;
	}

	/**
	 * Social Authentication
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function authenticate()
	{
		return $this->provider->redirect();
	}

	/**
	 * Authenticated User
	 *
	 * @return array
	 */
	public function user()
	{
		return (array) $this->provider->user();
	}

	/**
	 * Get Http Client
	 *
	 * @return \GuzzleHttp\Client
	 */
	public function getClient()
	{
		return new Client;
	}

	/**
	 * Instance of current provider
	 *
	 * @return mixed
	 */
	public function getProvider()
	{
		return $this->provider;
	}

	/**
	 * Instance of Socialite
	 *
	 * @return \Laravel\Socialite\Contracts\Factory
	 */
	public function getSocialite()
	{
		return $this->socialite;
	}

	/**
	 * Get Consumer Key
	 *
	 * @return string
	 */
	public function getKey()
	{
		return config("services.{$this->driver}.client_id");
	}

	/**
	 * Get Consumer Secret
	 *
	 * @return string
	 */
	public function getSecret()
	{
		return config("services.{$this->driver}.client_secret");
	}

	/**
	 * Get Social information (user fields, token, ...)
	 *
	 * @param  null|string $key
	 * @return mixed
	 */
	public function getInfo($key = null)
	{
		$file     = app('filesystem.disk');
		$fileName = "{$this->driver}.json";

		if ($file->exists($fileName))
		{
			$content = $file->get($fileName);
			$info    = app('encrypter')->decrypt($content);

			return $key ? array_get($info, $key) : $info;
		}

		return [];
	}

	/**
	 * Save Social informations
	 *
	 * @param  array  $info
	 * @return array|false
	 */
	public function saveInfo(array $info)
	{
		$file = app('filesystem.disk');

		$content = $info + $this->getInfo();
		$content = app('encrypter')->encrypt($content);

		if ($file->put("{$this->driver}.json", $content))
		{
			return $this->getInfo();
		}

		return false;
	}

	/**
	 * Publish to a Social Network
	 *
	 * @param  array  $values
	 * @return mixed
	 */
	abstract public function publish(array $values);

}