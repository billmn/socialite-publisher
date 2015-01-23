<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Social\Social;
use App\Http\Controllers\Controller;
use App\Social\Exceptions\ClientException;

use Illuminate\Http\Request;

class SocialController extends Controller {

	protected $social;

	public function __construct(Social $social)
	{
		$this->social = $social;
	}

	public function login($driver)
	{
		$social = $this->social->driver($driver);

		return $social->authenticate();
	}

	public function callback($driver)
	{
		$social = $this->social->driver($driver);

		// Informazioni utente
		$info = $social->user();

		// Registro le informazioni
		if ($social->saveInfo($info))
		{
			if ($social->is('facebook'))
			{
				return redirect()->route('social.facebook.pages');
			}

			return redirect()->route('social.message', $driver);
		}

		return redirect()->back();
	}

	public function message($driver)
	{
		$driver = strtolower($driver);
		$social = $this->social->driver($driver);

		$info = $social->getInfo();

		if ($social->is('facebook'))
		{
			$info['page'] = $social->getPage($info['page_id']);
		}

		return view("social.{$driver}.message", compact('info'));
	}

	public function publish(Request $request, $driver)
	{
		try
		{
			$values = $request->except('_token');
			$social = $this->social->driver($driver);

			$social->publish($values);

			return redirect()->back()->with('success', 'Published!');
		}
		catch (ClientException $e)
		{
			return redirect()->back()->withInput()->withErrors([
				'message' => $e->getMessage(),
			]);
		}
	}

	public function facebookPages()
	{
		$social = $this->social->driver('facebook');
		$pages  = $social->getPages();

		return view('social.facebook.pages', compact('pages'));
	}

	public function facebookChoosePage(Request $request)
	{
		$social = $this->social->driver('facebook');
		$pageId = $request->get('page_id');

		$pageToken = $social->getPageToken($pageId);

		$social->saveInfo([
			'page_id'    => $pageId,
			'page_token' => $pageToken,
		]);

		return redirect()->route('social.message', 'facebook');
	}

}
