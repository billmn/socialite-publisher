<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Social\Social;
use App\Http\Controllers\Controller;

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
		dd($driver);
	}

}
