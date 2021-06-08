<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!session()->has('signed_in'))
                return redirect()->route('admin.login');
            return $next($request);
        })->except('login', 'doLogin');
    }

    public function show()
    {
        return view('admin');
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        if ($request->get('password') != "12345")
            return redirect()->back()->withErrors(['password' => 'Wrong password asshole']);
        session()->put('signed_in', true);

        return redirect()->route('admin.home');
    }

    public function addPlayer(Request $request)
    {
        Player::create($request->except('_token'));

        return redirect()->back();
    }

    public function addBeverage(Request $request, Player $player)
    {
        $player->beverages()->create([
            'cost'       => $request->get('beverageCost'),
            'started_at' => now()
        ]);

        return redirect()->back()->with('success', 'Drink started!');
    }

    public function completeBeverage(Request $request, Player $player)
    {
        $beverage = $player->currentlyDrinking;
        $beverage->update([
            'completed_at' => Carbon::createFromTimestamp(strtotime($request->get('completed_at')))
        ]);
        return redirect()->back()->with('success', "Drink completed! $player->name has earned $beverage->cost chips!");
    }

    public function undoBeverage(Player $player)
    {
        $player->currentlyDrinking->delete();
        return redirect()->back()->with('success', "Drink undone! smh rme ffs");
    }

    public function playerInfo(Player $player)
    {
        $endIntervals = [
            'now'        => 'Now',
            '-30 second' => '30 seconds ago',
            '-1 minute'  => '1 minute ago',
            '-3 minute'  => '3 minutes ago',
            '-5 minute'  => '5 minutes ago',
            '-10 minute' => '10 minutes ago'
        ];

        return view('admin', compact('player', 'endIntervals'));
    }
}
