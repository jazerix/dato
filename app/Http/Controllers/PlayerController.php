<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __invoke()
    {
        $players = Player::orderBy('name')->with('beverages')->get();

        return $players;
    }
}
