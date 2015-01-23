<?php namespace App\Social\Drivers;

use App\Social\Driver;
use App\Social\Exceptions\ClientException;

use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Exception\RequestException;

class Twitter extends Driver {

	/**
	 * The base Twitter API URL.
	 *
	 * @var string
	 */
	private $url = "https://api.twitter.com";

	/**
	 * The Twitter API version for the request.
	 *
	 * @var string
	 */
	private $version = "1.1";

	/**
	 * {@inheritdoc}
	 */
	public function publish(array $values)
	{
		try
		{
			$url = "{$this->url}/{$this->version}/statuses/update.json";

			$response = $this->getAuthorizedClient()->post($url, [
				'body' => [
					'status' => array_get($values, 'message'),
					'display_coordinates' => false
				],
			]);

			return $response->json();
		}
		catch (RequestException $e)
		{
			$response = $e->getResponse()->json();
			$error    = head($response['errors']);

			throw new ClientException('#' . $error['code'] . ' - ' . $error['message']);
		}
	}

	/**
	 * Get Authorized Http Client
	 * Include headers to communicate with Twitter API
	 *
	 * @return \GuzzleHttp\Client
	 */
	public function getAuthorizedClient()
	{
		$oauth = new Oauth1([
			'consumer_key'    => $this->getKey(),
			'consumer_secret' => $this->getSecret(),
			'token'           => $this->getInfo('token'),
			'token_secret'    => $this->getInfo('tokenSecret'),
		]);

		$this->client->getEmitter()->attach($oauth);
		$this->client->setDefaultOption('auth', 'oauth');

		return $this->client;
	}

}