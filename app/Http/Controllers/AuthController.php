<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\SubmitNotice;
use Illuminate\Http\Request;

class AuthController extends Controller
{

	/**
	* Create a new AuthController instance.
	*
	* @return void
	*/

	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['login', 'register']]);
	}

	/**
	* Get a JWT via given credentials.
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	// public function register(Request $request)
	// {
	// 	$this->validate($request, [
	// 		'name' => 'required',
	// 		'email' => 'required|email',
	// 		'password' => 'required|min:6'
	// 	]);

	// 	$user = new User();
	// 	$user->name = $request->name;
	// 	$user->email = $request->email;
	// 	$user->password = bcrypt($request->password);
	// 	$user->save();
	// 	return response()->json(['user' => $user]);
	// }

	/**
	* Get a JWT via given credentials.
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);
		if (! $token = auth('api')->attempt($credentials)) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}
		return $this->respondWithToken($token);
	}

	/**
	* Get the authenticated User.
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	// public function me()
	// {
	// 	return response()->json(auth('api')->user());
	// }

	/**
	* Log the user out (Invalidate the token).
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	public function logout()
	{
		auth('api')->logout();
		return response()->json(['message' => 'Successfully logged out']);
	}

	/**
	* Refresh a token.
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	// public function refresh()
	// {
	// 	return $this->respondWithToken(auth('api')->refresh());
	// }

	/**
	* Get the token array structure.
	*
	* @param string $token
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	protected function respondWithToken($token)
	{
		return response()->json([
			'access_token' => $token,
			'user' => $this->guard()->user(),
			'token_type' => 'bearer',
			'expires_in' => auth('api')->factory()->getTTL() * 60
		]);
	}

	public function guard(){
		return \Auth::Guard('api');
	}

	public function posts($id) {
		$posts = \App\Post::with('user')->where('id','>=',$id)->orderBy('id','asc')->get();
		return response()->json($posts);
	}

	public function create(Request $request) {
		$data = $request->validate([
			'post' => 'required|max:255'
		]);
		$user = $this->guard()->user();
		$post = new \App\Post;
		$post->post = $data['post'];
		$post->user_id = $user->id;
		$post->save();

		event(new SubmitNotice($post->id));
		return response()->json("Post has been created");
	}
}
