<?php

namespace App\Http\Controllers\Api;
use App\Mail\UserPubblicationMail;
use App\Mail\UserNotifyProjectMail;
use App\Models\Userform;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nome"=>"required|string|min:2|max:15",
            "email"=>"required|string|unique:userforms",
            "messaggio"=>"required",
        ]);
        $user = new Userform;
        $user->nome = $request->input("nome");
        $user->email = $request->input("email");
        $user->messaggio = $request->input("messaggio");
        $user->newsletter = $request->input("newsletter");
        $user->save();
       
            $email = new UserPubblicationMail($user);
            $user_email = $request->input("email");
            Mail::to($user_email)->send($email);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}