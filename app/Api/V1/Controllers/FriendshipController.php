<?php

namespace App\Api\V1\Controllers;

use App\Friendship;
use App\Http\Controllers\Controller;
use App\Institution;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FriendshipController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('jwt.auth', []);
  }

  public function get(Request $request)
  {
    $user_id = Auth::user()->id;

    try {
      $friends = DB::table('friendships as f1')
        ->select('users.id')
        ->where('f1.user_id', $user_id)
        ->join('friendships as f2', function ($join) {
          $join->on('f1.user_id', '=', 'f2.friend_id');
          $join->on('f1.friend_id', '=', 'f2.user_id');
        })
        ->join('users', 'users.id', '=', 'f2.user_id')
        ->get();

      $result = array();
      foreach ($friends as $friend) {
        $user = User::find($friend->id);
        $friend_result = array();
        $friend_result['id'] = $user->id;
        $friend_result['name'] = $user->name;
        $friend_result['email'] = $user->email;
        $friend_result['phone'] = $user->phone;
        $friend_result['image'] = url('storage/' . $user->image);
        $friend_result['email_verified_at'] = $user->email_verified_at;
        $friend_result['date_of_birth'] = $user->date_of_birth;
        $friend_result['gender'] = $user->gender;
        $friend_result['address'] = $user->address;
        $friend_result['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
        $friend_result['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
        $friend_result['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
        $friend_result['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
        $friend_result['role'] = $user->getRoleNames()[0];
        $friend_result['created_at'] = $user->created_at;
        $friend_result['updated_at'] = $user->updated_at;
        array_push($result, $friend_result);
      }

      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched friends.',
        'result' => $result
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  /**
   * API to request a friendship
   */
  public function add(Request $request)
  {
    $credentials = $request->only('friend_id');

    $rules = [
      'friend_id' => 'required',
    ];

    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
      $errorString = implode(",", $validator->messages()->all());
      return response()->json(['success' => false, 'message' => $errorString, 'result' => null], 428);
    }

    $user_id = Auth::user()->id;
    $friend_id = $request->input('friend_id');

    if ($user_id == $friend_id) {
      return response()->json([
        'success' => false,
        'message' => 'Error.',
        'result' => null
      ], 428);
    } else {
      try {
        $existed = Friendship::where('user_id', $user_id)->where('friend_id', $friend_id)->first();
        if ($existed == null) {
          $friendship = Friendship::create(['user_id' => $user_id, 'friend_id' => $friend_id]);
          return response()->json([
            'success' => true,
            'message' => 'Successfully added.',
            'result' => $friendship
          ], 200);
        } else {
          return response()->json([
            'success' => false,
            'message' => 'You have been requested it.',
            'result' => null
          ], 428);
        }
      } catch (Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage(),
          'result' => null
        ], 500);
      }
    }
  }

  /**
   * API to accept a friendship request
   */
  public function accept(Request $request)
  {
    $credentials = $request->only('friend_id');

    $rules = [
      'friend_id' => 'required',
    ];

    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
      $errorString = implode(",", $validator->messages()->all());
      return response()->json(['success' => false, 'message' => $errorString, 'result' => null], 428);
    }

    $user_id = Auth::user()->id;
    $friend_id = $request->input('friend_id');

    try {
      $friendship_request = Friendship::where(['user_id' => $friend_id, 'friend_id' => $user_id])->first();
      if ($friendship_request != null) {
        $existed_friendship = Friendship::where(['user_id' => $user_id, 'friend_id' => $friend_id])->first();
        if ($existed_friendship == null) {
          $friendship = Friendship::create(['user_id' => $user_id, 'friend_id' => $friend_id]);
          return response()->json([
            'success' => true,
            'message' => 'Successfully accepted.',
            'id' => $friendship
          ], 200);
        } else {
          return response()->json([
            'success' => false,
            'message' => 'Already accepted.',
            'id' => null
          ], 428);
        }
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Error.',
          'id' => null
        ], 428);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Failed to accept friend.',
        'id' => null
      ], 500);
    }
  }

  /**
   * API to get friendship requests
   */
  public function requests(Request $request)
  {
    $user_id = Auth::user()->id;

    try {
      $requests = Friendship::select('users.id', 'users.name', 'users.email', 'users.image')
        ->where('friend_id', $user_id)
        ->leftJoin('users', 'users.id', '=', 'friendships.user_id')
        ->get();

        $result = array();
        foreach ($requests as $friend) {
          $user = User::find($friend->id);
          $friend_result = array();
          $friend_result['id'] = $user->id;
          $friend_result['name'] = $user->name;
          $friend_result['email'] = $user->email;
          $friend_result['phone'] = $user->phone;
          $friend_result['image'] = url('storage/' . $user->image);
          $friend_result['email_verified_at'] = $user->email_verified_at;
          $friend_result['date_of_birth'] = $user->date_of_birth;
          $friend_result['gender'] = $user->gender;
          $friend_result['address'] = $user->address;
          $friend_result['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
          $friend_result['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
          $friend_result['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
          $friend_result['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
          $friend_result['role'] = $user->getRoleNames()[0];
          $friend_result['created_at'] = $user->created_at;
          $friend_result['updated_at'] = $user->updated_at;
          array_push($result, $friend_result);
        }

      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched friend requests.',
        'result' => $result
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  /**
   * API to get friend detail
   */
  public function detail($friend_id)
  {
    $user = User::find($friend_id)->toArray();
    $user['email_verified_at'] = Carbon::parse(User::find($friend_id)->email_verified_at)->format('d/m/Y');
    $user['date_of_birth'] = Carbon::parse(User::find($friend_id)->date_of_birth)->format('d/m/Y');
    $user['image'] = url('storage/' . User::find($friend_id)->image);
    $user['village'] = User::find($friend_id)->village != null ? ucwords(strtolower(User::find($friend_id)->village->name)) : null;
    $user['district'] = User::find($friend_id)->village != null ? ucwords(strtolower(User::find($friend_id)->village->district->name)) : null;
    $user['regency'] = User::find($friend_id)->village != null ? ucwords(strtolower(User::find($friend_id)->village->district->regency->name)) : null;
    $user['province'] = User::find($friend_id)->village != null ? ucwords(strtolower(User::find($friend_id)->village->district->regency->province->name)) : null;
    $user['roles'] = User::find($friend_id)->getRoleNames();
    $user['institutions'] = Institution::whereIn('id', User::find($friend_id)->institutions->pluck('institution_id'))->pluck('name');
    $user['created_at'] = Carbon::parse(User::find($friend_id)->created_at)->format('d/m/Y');
    $user['updated_at'] = Carbon::parse(User::find($friend_id)->updated_at)->format('d/m/Y');

    try {
      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched user data',
        'user' => $user
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'user' => null
      ], 500);
    }
  }

  public function status($friend_id)
  {
    $user_id = Auth::user()->id;

    $friend = DB::table('friendships as f1')
      ->where(['f1.user_id' => $user_id, 'f1.friend_id' => $friend_id])
      ->join('friendships as f2', function ($join) {
        $join->on('f1.user_id', '=', 'f2.friend_id');
        $join->on('f1.friend_id', '=', 'f2.user_id');
      })
      ->first();

    if ($user_id == $friend_id) { // If itself
      return response()->json([
        'success' => true,
        'message' => 'This is yourself',
        'result' => 0
      ]);
    } else if ($friend != null) { // If friend
      return response()->json([
        'success' => true,
        'message' => 'Friend',
        'result' => 1
      ]);
    } else if (Friendship::where(['user_id' => $user_id, 'friend_id' => $friend_id])->pluck('id')->first() != null) { // If user requested to friend
      return response()->json([
        'success' => true,
        'message' => 'Requested.',
        'result' => 2
      ]);
    } else if (Friendship::where(['user_id' => $friend_id, 'friend_id' => $user_id])->pluck('id')->first() != null) { // If friend is requested to user
      return response()->json([
        'success' => true,
        'message' => 'Requesting',
        'result' => 3
      ]);
    } else { // If not at all
      return response()->json([
        'success' => true,
        'message' => 'Not at all.',
        'result' => 4
      ]);
    }
  }
}
