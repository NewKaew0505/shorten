<?php

namespace App\Http\Controllers;

use App\Models\Shortage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ShortageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string|max:255|unique:shortages,destination',
            'domain' => 'required|string|max:100',
            'backhalf' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = $request->input('user_id');
        if ($user_id == Auth::user()->id) {
            Shortage::create([
                'user_id' => Auth::user()->id,
                'destination' => $request['destination'],
                'title' => $request['title'],
                'domain' => $request['domain'],
                'backhalf' => $request['backhalf'],
            ]);
            return redirect()->back()->with('status', 'Create Successfully');
        }
        return redirect()->back()->with('status', 'Create Error');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shortage  $shortage
     * @return \Illuminate\Http\Response
     */
    public function show(Shortage $shortage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shortage  $shortage
     * @return \Illuminate\Http\Response
     */
    public function edit(Shortage $shortage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shortage  $shortage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain' => 'required|string|max:100',
            'backhalf' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $shortageId = $request->input('shortage');
        $user_id = $request->input('user_id');
        $data = $request->only(['destination', 'title', 'domain', 'backhalf']);
        $shortage = Shortage::find($shortageId);
        if ($shortage && (($user_id == Auth::user()->id && Auth::user()->id == $shortage->user_id) || Auth::user()->role == 0)) {
            $shortage->update($data);
            return redirect()->back()->with('status', 'Edit Successfully');
        }
        return redirect()->back()->with('status', 'Edit Error');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shortage  $shortage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id = $request->input('user_id');
        $id = $request->input('id');
        $shortage = shortage::find($id);
        if ($shortage && (($user_id == Auth::user()->id && Auth::user()->id == $shortage->user_id) || Auth::user()->role == 0)) {
            $shortage->delete();
            return redirect()->back()->with('status', 'Deleted Successfully');
        }
        return redirect()->back()->with('status', 'Deleted Error');
    }
}
