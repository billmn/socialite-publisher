<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],

	/*
	|--------------------------------------------------------------------------
	| Socialite
	|--------------------------------------------------------------------------
	*/

	'twitter' => [
		'client_id'     => env('TWITTER_KEY'),
		'client_secret' => env('TWITTER_SECRET'),
		'redirect'      => '',
	],

	'facebook' => [
		'client_id'     => env('FACEBOOK_ID'),
		'client_secret' => env('FACEBOOK_SECRET'),
		'redirect'      => '',
		'scopes'        => ['email', 'manage_pages', 'publish_actions'],
	]

];
