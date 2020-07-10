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

    $result = DB::table('friendships as f1')->select('users.id', 'users.name', 'users.avatar', 'users.email')
      ->where('f1.user_id', $user_id)
      ->join('friendships as f2', function ($join) {
        $join->on('f1.user_id', '=', 'f2.friend_id');
        $join->on('f1.friend_id', '=', 'f2.user_id');
      })
      ->join('users', 'users.id', '=', 'f2.user_id')
      ->get();

    return response()->json([
      'success' => true,
      'message' => 'Successfully fetched friends.',
      'result' => $result
    ]);
  }

  /**
   * API to get friend ids
   */
  public static function getFriendIds(Request $request)
  {
    $user_id = Auth::user()->id;
    return DB::table('friendships as f1')
      ->where('f1.user_id', $user_id)
      ->join('friendships as f2', function ($join) {
        $join->on('f1.user_id', '=', 'f2.friend_id');
        $join->on('f1.friend_id', '=', 'f2.user_id');
      })
      ->join('users', 'users.id', '=', 'f2.user_id')
      ->pluck('users.id');
  }

  /**
   * API to request a friendship
   */
  public function add(Request $request)
  {
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
        }
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
   * API to reject a friendship request
   */
  public function reject(Request $request)
  {
    $user_id = Auth::user()->id;
    $friend_id = $request->input('friend_id');
    try {
      Friendship::where(['user_id' => $friend_id, 'friend_id' => $user_id])->delete();
      return response()->json([
        'success' => true,
        'message' => 'Successfully rejected request.',
        'id' => null
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Failed to reject request.',
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
      $result = Friendship::select('users.id', 'users.name', 'users.avatar', 'users.email')
        ->where('friend_id', $user_id)
        ->leftJoin('user_details', 'user_details.user_id', '=', 'friendships.user_id')
        ->leftJoin('users', 'users.id', '=', 'friendships.user_id')
        ->get();

      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched friend requests.',
        'result' => $result
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Failed to fetch friend requests.',
        'result' => null
      ], 500);
    }
  }

  /**
   * API to search student
   */
  public function search(Request $request)
  {
    // $serial_id = $request->input('serial_id');
    // $name = $request->input('name');

    // if ($serial_id != null) {
    //   return UserDetail::where('serial_id', $serial_id)
    //     ->select('users.id', 'users.name', 'users.avatar', 'users.email')
    //     ->rightJoin('users', 'users.id', '=', 'user_details.user_id')
    //     ->get();
    // } else {
    //   return User::where('name', 'like', '%' . $name . '%')
    //     ->where('role_id', 4)
    //     ->select('users.id', 'users.name', 'users.avatar', 'users.email')
    //     ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
    //     ->get();
    // }
  }

  /**
   * API to get all students
   */
  public function browse(Request $request)
  {
  }

  /**
   * API to get friend detail
   */
  public function detail(Request $request)
  {
    $friend_id = $request->input('friend_id');

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

  public function status(Request $request)
  {
    $user_id = Auth::user()->id;
    $friend_id = $request->input('friend_id');

    $friend = DB::table('friendships as f1')
      ->where(['f1.user_id' => $user_id, 'f1.friend_id' => $friend_id])
      ->join('friendships as f2', function ($join) {
        $join->on('f1.user_id', '=', 'f2.friend_id');
        $join->on('f1.friend_id', '=', 'f2.user_id');
      })
      ->first();

    if ($user_id == $friend_id) {
      return response()->json([
        'status' => 'yourself'
      ]);
    } else if ($friend != null) {
      return response()->json([
        'status' => 'friend'
      ]);
    } else if (Friendship::where(['user_id' => $user_id, 'friend_id' => $friend_id])->pluck('id')->first() != null) {
      return response()->json([
        'status' => 'requesting'
      ]);
    } else if (Friendship::where(['user_id' => $friend_id, 'friend_id' => $user_id])->pluck('id')->first() != null) {
      return response()->json([
        'status' => 'requested'
      ]);
    } else {
      return response()->json([
        'status' => 'not_requested'
      ]);
    }
  }
}
