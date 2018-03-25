<?php
/**
 * Created by PhpStorm.
 * User: dmitrij
 * Date: 19.03.2018
 * Time: 21:10
 */

namespace App\Http\Controllers;

use App\Reply;
use App\Favorite;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorite(auth()->id());

        return back();
    }
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}