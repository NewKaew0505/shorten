<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shortage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 0) {
            $shortages = Shortage::all();
        } else {
            $shortages = Auth::user()->shortages;
        }
        return view('home', ['shortages' => $shortages]);
    }

    public function go($link)
    {
        $shortage = Shortage::where('backhalf', $link)->where('domain', env('DOMAIN'))->first();
        if ($shortage) {
            // dd($shortage);
            return redirect($shortage->destination);
        }
        if (Auth::user()->role == 0) {
            $shortages = Shortage::all();
        } else {
            $shortages = Auth::user()->shortages;
        }
        return view('home', ['shortages' => $shortages]);
    }
}
