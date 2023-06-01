<?php

namespace App\Http\Controllers;

use App\Models\Lection;
use App\Models\Test;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_admin', '=', 0)->get();

        foreach ($users as $user) {
            $user->created_at = Carbon::parse($user->created_at)->format('d.m.Y H:i');
        }

        $countUsers = User::count();
        $countLections = Lection::count();
        $countTests = Test::count();

        $users['users'] = $countUsers;
        $users['lections'] = $countLections;
        $users['tests'] = $countTests;

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
        ]);

        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return User::destroy($id);
    }


}
