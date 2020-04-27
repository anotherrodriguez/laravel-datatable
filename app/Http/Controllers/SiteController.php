<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available Sites
        return view('sites');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $sites = Site::select(['id', 'name', 'created_at', 'updated_at'])->get();
        return Datatables::of($sites)->addColumn('action', function ($sites) {
                return '<a href="'.action('SiteController@edit', $sites->id).'"><i class="fad fa-pencil-alt"></i></a>';
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Show form to add new Sites
        return view('sites-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Save Site Data
        $validatedData = $request->validate([
            'name' => ['required', 'unique:sites', 'max:255'],
        ]);

        $site = new Site;

        $site->name = request('name');

        $site->save();

        $message = [
            'text' => "Success: Site ".$site->name." has been saved.",
            'type' => "success"
        ];

        return redirect()->action('SiteController@index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
        return view('sites-edit')->with('site', Site::find($site->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        //Save Site Data
        $validatedData = $request->validate([
            'name' => ['required', 'unique:sites', 'max:255'],
        ]);

        $site->update(['name'=>request('name')]);

        $message = [
                'text' => "Success: Site ".$site->name." has been updated",
                'type' => "success"
            ];

        return redirect()->action('SiteController@index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
        try{
            $site->delete();

            $message = [
                'text' => "Success: Site ".$site->name." has been deleted.",
                'type' => "success"
            ];

            return redirect()->action('SiteController@index')->with('message', 'Site deleted');
        }
        catch(\Illuminate\Database\QueryException $e){

            $message = [
                'text' => "Error: Patients, statuses, and/or departments are already assigned to this site.",
                'type' => "error"
            ];

            return redirect()->action('SiteController@index')->with('message', $message);

        }
    }
}
