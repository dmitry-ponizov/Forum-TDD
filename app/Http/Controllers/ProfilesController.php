<?php
/**
 * Created by PhpStorm.
 * User: dmitrij
 * Date: 19.03.2018
 * Time: 21:10
 */

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;


class ProfilesController extends Controller
{

    public function show($name)
    {
        $user = User::where('name',$name)->first();

        return view('profiles.show', [
            'profileUser' => $user,
            'activities'=> Activity::feed($user)
        ]);
    }

    /**
     * @param $user
     * @return mixed
     */

}