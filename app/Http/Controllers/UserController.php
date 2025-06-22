<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'user_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'email.unique' => 'Email Id Already Exists!'
            ]
        );

        $photoPath = null;

        if ($request->hasFile('user_photo')) {

            $file = $request->file('user_photo');
            $timestamp = Carbon::now()->format('Ymd_His');
            $username = Str::slug($validated['name']); // safe slug like "john-doe"
            $filename = $username . '_' . $timestamp . '.' . $file->getClientOriginalExtension();

            $photoPath = $file->storeAs('user_photos', $filename, 'public');
        }

        // Inside store()
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_photo' => $photoPath,
        ]);

        Auth::login($user); // Log the user in

        return redirect()->route('dashboard');
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
