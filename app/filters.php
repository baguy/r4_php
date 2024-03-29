<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	/*

	$identifier = null;

	if (Cookie::get('laravel_access_id'))

		$identifier = "user_{Cookie::get('laravel_access_id')}";

	if (Auth::check() && !Cache::has($identifier))

		Cache::forever($identifier, Auth::user());

  if (!Auth::check() && !Cookie::get('laravel_session') && Cache::has($identifier))

  	Event::fire('auth.logout', Cache::pull($identifier));

  */

});

App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Role Filter
|--------------------------------------------------------------------------
|
| The Role filter is responsible for blocking routes against
| user without access permissions to do it.
|
*/

Route::filter('role', function($route, $request, $role)
{
	if (Auth::guest() or !Auth::user()->hasRole($role))
	{
		App::abort(403, 'Unauthorized action.');
	}
});

Route::filter('is-default-password', function() {

	if(Auth::user()->throttle->is_default_password)

		return Redirect::route('users.change-password', Auth::user()->id);
});