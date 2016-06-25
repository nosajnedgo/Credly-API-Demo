<?php

/**
 * API access to Credly to login, read a profile, and badge info.
 *
 * @author Jason Ogden <nosajnedgo@gmail.com>
 */

namespace App\Helpers;

use \GuzzleHttp\Client;

class Credly
{
    
	/**
	* @var string $base_uri URI for Credily API (including version)
	* @var string $key Credly API given Key
	* @var string $secret Credly API given Secret
	*/    
    private $base_uri, $key, $secret;

	/**
     * Constructor for given URI and credentials.
     *
	 * @param string $base_uri URI for Credily API (including version)
	 * @param string $key Credly API given Key
	 * @param string $secret Credly API given Secret
     */
	function __construct($base_uri, $key, $secret)
	{
		$this->base_uri = $base_uri;
		$this->key = $key;
		$this->secret = $secret;
	}

	/**
     * Authenticates a user and get an access token.
     *
     * @param string $email Email address of Credly account
     * @param string $password Password to Credly account
     *
     * @return array 'success' and 'body' attributes for the request.
     */
	public function authenticate($email, $password)
	{
        return $this->request('POST', 'authenticate', [ 
            'auth' => [
                request()->input('email'), 
                request()->input('password')
            ]
        ]);
	}

    /**
     * Get a users's profile information.
     *
     * @param string $access_token Credly token from authentication.
     *
     * @return array 'success' and 'body' attributes for the request.
     */
    public function me($access_token)
    {
        return $this->request('GET', 'me', [ 
            'query' => ['access_token' => $access_token]
        ]);

    }

    /**
     * Get a list of all the badges associate with a given user.
     *
     * @param string $userID Credly User ID
     *
     * @return array 'success' and 'body' attributes for the request.
     */
    public function badges($userID)
    {
        return $this->request('GET', "members/$userID/badges");
    }

	/**
     * Makes a request to the given API resource and returns a custom
     * response array.
     *
     * @param string $method HTTP method to use for call
     * @param string $path Relative path for the API call
     * @param array  $options Optional array of options to merge into request
     *
     * @return array 'success' and 'body' attributes for the request.
     */
    private function request($method, $path, $options = [])
    {
    	$client = new \GuzzleHttp\Client([
    		'base_uri' => $this->base_uri
    	]);
    	$options = array_merge([
    		'headers' => [
		        'X-Api-Key' => $this->key,
		        'X-Api-Secret' => $this->secret,
       		],
            'http_errors' => false,
    	], $options);
        $response = $client->request($method, $path, $options);
        return [
            'success' => $response->getStatusCode() == 200,
            'body' => json_decode($response->getBody())
        ];
    }

}
