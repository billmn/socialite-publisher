<?php namespace App\Social;

class TwitterOAuth {

	private $nonceByte = 32;

	/**
	 * GET oauth_nonce
	 */
	public function getOauthNonce()
	{
		$letters = range('A', 'z');

		$randomByte = openssl_random_pseudo_bytes($this->nonceByte);

		$encode = base64_encode($randomByte);

		return preg_replace('/\W/', $letters[rand(0, 57)], $encode);
	}

}