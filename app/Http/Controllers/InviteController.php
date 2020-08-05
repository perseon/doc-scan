<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Mail\InviteClient;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invites = Invite::with('applications')->get();

        //dd($invites);

        return view("invites.show",compact("invites"));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
        return view("invites.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
        ]);

       // dd($validatedData);

        $invite = new Invite();

        $invite->name = $validatedData['name'];
        $invite->email = $validatedData['email'];
        $invite->link_accessed = false;
        $invite->invited = $request->has('invited');;
        $invite->tracking_id =  Uuid::uuid4();
        $invite->save();

        $application = new \App\Application();

        if($request->has('invited')) Mail::to($invite->email)->send(new InviteClient($invite));


        return redirect(route('invites.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function show(Invite $invite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function edit(Invite $invite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invite $invite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invite $invite)
    {
        //
        $invite->delete();

        return redirect()->back();
    }
}
