<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AppController extends Controller
{
    
    function login()
    {
    	return view('login');
    }

    function checklogin()
    {
    	return 'checklogin';
    }

    function showbadges()
    {
    	return view('showbadges');
    }

}
