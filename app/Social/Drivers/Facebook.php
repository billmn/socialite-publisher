<?php namespace App\Social\Drivers;

use App\Social\Driver;
use App\Social\Exceptions\ClientException;

use GuzzleHttp\Exception\RequestException;
use Laravel\Socialite\Contracts\Factory as Socialite;

class Facebook extends Driver {

	/**
	 * The base Facebook Graph URL.
	 *
	 * @var string
	 */
	private $url = "https://graph.facebook.com";

	/**
	 * The Graph API version for the request.
	 *
	 * @var string
	 */
	private $version = "v2.2";

	public function __construct(Socialite $socialite)
	{
		parent::__construct($socialite);

		$this->provider->scopes(config('services.facebook.scopes'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function saveInfo(array $info)
	{
		$facebookInfo = $info + [
			'page_id'    => array_get($info, 'page_id'),
			'page_token' => array_get($info, 'page_token'),
		];

		return parent::saveInfo($facebookInfo);
	}

	/**
	 * {@inheritdoc}
	 */
	public function publish(array $values)
	{
		try
		{
			$pageId    = $this->getInfo('page_id');
			$pageToken = $this->getInfo('page_token');

			$params = [
				'message' => array_get($values, 'message'),
			];

			if (isset($values['schedule']))
			{
				$params['published'] = false;
				$params['scheduled_publish_time'] = $values['schedule'];
			}

			$response = $this->client->post("{$this->url}/{$this->version}/{$pageId}/feed?access_token={$pageToken}", [
				'body' => $params,
			]);

			return $response->json();
		}
		catch (RequestException $e)
		{
			$response = $e->getResponse()->json();

			throw new ClientException($response['error']['message']);
		}
	}

	/**
	 * Get user's pages
	 *
	 * @return array
	 */
	public function getPages()
	{
		try
		{
			$token    = $this->getInfo('token');
			$response = $this->client->get("{$this->url}/{$this->version}/me/accounts?access_token={$token}");

			$body  = $response->json();
			$pages = $body['data'];

			$pages = array_sort($pages, function($value)
			{
				return $value['name'];
			});

			return $pages;
		}
		catch (RequestException $e)
		{
			throw $e;
		}
	}

	/**
	 * Get user's page informations
	 *
	 * @param  string $pageId
	 * @return array
	 */
	public function getPage($pageId)
	{
		try
		{
			$token    = $this->getInfo('token');
			$response = $this->client->get("{$this->url}/{$this->version}/{$pageId}?access_token={$token}");

			return $response->json();
		}
		catch (RequestException $e)
		{
			throw $e;
		}
	}

	/**
	 * Get user's page token
	 *
	 * @param  string $pageId
	 * @return string
	 */
	public function getPageToken($pageId)
	{
		$page = array_where($this->getPages(), function($key, $value) use($pageId)
		{
			return $value['id'] == $pageId;
		});

		return array_get(head($page), 'access_token', false);
	}

}