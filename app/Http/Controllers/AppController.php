<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \GuzzleHttp\Client;
use Session;

class AppController extends Controller
{
    
    function login()
    {
    	return view('login');
    }

    function checklogin()
    {
        $response = $this->credlyRequest('POST', 'authenticate', [ 
            'auth' => [
                request()->input('email'), 
                request()->input('password')
            ]
        ]);
        if ($response['success']) {
            Session::set('access_token', $response['body']->data->token);
            return redirect('/showbadges');
        }
        else {
            Session::flash('status', $response['body']->meta->message);
            return redirect('/')->withInput();
        }
    }

    function logout()
    {
        Session::forget('access_token');
        return redirect('/');
    }


    function showbadges()
    {
        $meRequest = $this->credlyRequest('GET', 'me', [ 
            'query' => ['access_token' => Session::get('access_token')]
        ]);
        if (!$meRequest['success']) {
            Session::flash('status', $meRequest['body']->meta->message);
            return redirect('/');
        }

        $userID = $meRequest['body']->data->id;

        $badgeRequest = $this->credlyRequest('GET', "members/$userID/badges");
        if (!$badgeRequest['success']) {
            Session::flash('status', $meRequest['body']->meta->message);
            return redirect('/');
        }
        return view('showbadges', [
            'user' => $meRequest['body']->data,
            'badges' => $badgeRequest['body']->data,
        ]);
    }


    private function credlyRequest($method, $path, $options = [])
    {
    	$client = new \GuzzleHttp\Client([
    		'base_uri' => config('services.credly.url')
    	]);
    	$options = array_merge([
    		'headers' => [
		        'X-Api-Key' => config('services.credly.key'),
		        'X-Api-Secret' => config('services.credly.secret'),
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
