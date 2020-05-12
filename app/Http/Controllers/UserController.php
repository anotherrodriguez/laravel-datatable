<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
     public function __construct()
    {
        $this->middleware(['verified', 'can:isAdmin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available Sites
        return view('user/list');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $user = Auth::user();

        if($user->role->name === 'super_admin'){
            $users = User::with(['role', 'site'])->get();
            return Datatables::of($users)->addColumn('action', function ($users) {
                return action('UserController@edit', $users->id);
            })->make(true);

        }
        else{
            $users = User::with(['role', 'site'])->where('site_id', $user->site_id)->get();
            return Datatables::of($users)->addColumn('action', function ($users) {
                return action('UserController@edit', $users->id);
            })->make(true);

        }
        
    }

    public function edit(User $user)
    {
        //
        $roles = \App\Role::where('name','!=','super_admin')->pluck('name', 'id')->toArray();
        $sites = \App\Site::pluck('name', 'id')->toArray();
        return view('user/edit',['user' => User::find($user->id), 'roles' => $roles, 'sites' => $sites]);
    }

    public function update(Request $request, User $user)
    {
        //Save Department Data
        $role = \App\Role::find(request('role_id'));
        $site = \App\Site::find(request('site_id'));

        $user->role()->associate($role);

        $user->site()->associate($site);

        $user->update(['name'=>request('name')]);

        $message = [
            'text' => "Success: User ".$user->name." has been updated.",
            'type' => "success"
        ];

        return redirect()->action('UserController@index')->with('message', $message);
    }

    public function destroy(User $user)
    {
        //
        try{
            $user->delete();

            $message = [
                'text' => "Success: Status ".$user->name." has been deleted.",
                'type' => "success"
            ];

            return redirect()->action('UserController@index')->with('message', $message);
        }
        catch(\Illuminate\Database\QueryException $e){
            $message = [
                'text' => "Error: Patients are already assigned to this status",
                'type' => "error"
            ];

            return redirect()->action('UserController@index')->with('message', $message);

        }
    }


}
