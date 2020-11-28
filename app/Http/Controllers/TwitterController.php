<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;

class TwitterController extends Controller
{
    public function login(){


    $sign_in_twitter = true;
	$force_login = false;

	// Make sure we make this request w/o tokens, overwrite the default values in case of login.
	\Twitter::reconfig(['token' => '', 'secret' => '']);
	$token = \Twitter::getRequestToken(route('twitter.callback'));

	if (isset($token['oauth_token_secret']))
	{
		$url = \Twitter::getAuthorizeURL($token, $sign_in_twitter, $force_login);

		Session::put('oauth_state', 'start');
		Session::put('oauth_request_token', $token['oauth_token']);
		Session::put('oauth_request_token_secret', $token['oauth_token_secret']);

		return Redirect::to($url);
	}

    abort(404);
    
    }
    public function callback(){

    if (Session::has('oauth_request_token'))
	{
		$request_token = [
			'token'  => Session::get('oauth_request_token'),
			'secret' => Session::get('oauth_request_token_secret'),
		];

		\Twitter::reconfig($request_token);

		$oauth_verifier = false;

		if (request()->has('oauth_verifier'))
		{
			$oauth_verifier = request()->get('oauth_verifier');
			// getAccessToken() will reset the token for you
			$token = \Twitter::getAccessToken($oauth_verifier);
		}

		if (!isset($token['oauth_token_secret']))
		{
			return Redirect::route('twitter.error')->with('flash_error', 'We could not log you in on Twitter.');
		}

		$credentials = \Twitter::getCredentials();
		$screen_name = $credentials->screen_name;
		$profile_image_normal = $credentials ->profile_image_url_https;
		$profile_image = str_replace('_normal','',$profile_image_normal);
		$followers_count = $credentials->followers_count;
		$statuses_count = $credentials ->statuses_count;
		$created_at = $credentials ->created_at;

		if (is_object($credentials) && !isset($credentials->error))
		{
			
			try
			{
				$max_id = 0;
     			$totalTweets = 180;
				$data = \Twitter::getUserTimeline(['count' => 20, 'format' => 'array','include_entities' => 'true']);
				
				//dd($data);
			}
			catch (Exception $e)
			{
				// dd(Twitter::error());
				dd(Twitter::logs());
			}
			

			//return Redirect::to('/')->with('flash_notice', 'Congrats! You\'ve successfully signed in!');
			return view('twitter.index',compact('data','screen_name','profile_image','followers_count','statuses_count','created_at'));

		}

		abort(404);
    }
}
}
