<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\Credly;
use Session;

class AppController extends Controller
{
    
    function login()
    {
    	return view('login');
    }

    function checklogin(Credly $credly)
    {
        $auth = $credly->authenticate(
            request()->input('email'), 
            request()->input('password')
        );

        if ($auth['success']) {
            Session::set('access_token', $auth['body']->data->token);
            return redirect('/showbadges');
        }
        else {
            Session::flash('status', $auth['body']->meta->message);
            return redirect('/')->withInput();
        }
    }

    function showbadges(Credly $credly)
    {
        $me = $credly->me(Session::get('access_token'));
        if (!$me['success']) {
            Session::flash('status', $me['body']->meta->message);
            return redirect('/');
        }

        $userID = $me['body']->data->id;

        $badges = $credly->badges($userID);
        if (!$badges['success']) {
            Session::flash('status', $badges['body']->meta->message);
            return redirect('/');
        }
        return view('showbadges', [
            'user' => $me['body']->data,
            'badges' => $badges['body']->data,
        ]);
    }

    function logout()
    {
        Session::forget('access_token');
        return redirect('/');
    }

}
