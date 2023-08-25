<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
// use DataTables;
use Yajra\DataTables\Facades\DataTables;



class UsersController extends Controller
{
    public function showUsersList()
    {
        return view('users.list');
    }

    public function getUsersData()
    {
        // $users = User::select(['id', 'first_name', 'last_name', 'email']);
        // // dd($users->get());
        // return DataTables::eloquent($users)->toJson();
        return Datatables::of(User::select(['id', 'first_name', 'last_name', 'email']))->toJson();

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
