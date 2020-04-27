<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available Sites
        return view('statuses');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $statuses = Status::with(['department.site'])->get();
        return Datatables::of($statuses)->addColumn('action', function ($statuses) {
                return '<a href="'.action('StatusController@edit', $statuses->id).'"><i class="fad fa-pencil-alt"></i></a>';
            })->make(true);
    }

    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatuses(Request $request)
    {
        $statuses = Status::where('department_id', $request->department_id)->get();
        return response()->json($statuses);
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Show form to add new Sites
        $sites = \App\Site::pluck('name', 'id')->toArray();
        return view('statuses-create', ['sites' => $sites]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => ['required', 'unique:statuses,name,null,id,department_id,'.request('department_id'), 'max:255'],
        ]);

        $department = \App\Department::find(request('department_id'));

        $status = new Status;

        $status->name = request('name');

        $department->status()->save($status);

        $message = [
                'text' => "Success: Status ".$status->name." has been saved.",
                'type' => "success"
            ];

        return redirect()->action('StatusController@index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
        $sites = \App\Site::pluck('name', 'id')->toArray();
        $departments = \App\Department::where('site_id', $status->department->site->id)->pluck('name', 'id')->toArray();
        return view('statuses-edit', ['status' => $status, 'sites' => $sites, 'departments' => $departments]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:statuses,name,null,id,department_id,'.request('department_id'), 'max:255']
        ]);

        $department = \App\Department::find(request('department_id'));

        $status->department()->associate($department);

         //Save Status Data
        $status->update([
            'name' => request('name')
        ]);

        $message = [
                'text' => "Success: Status ".$status->name." has been updated.",
                'type' => "success"
            ];

        return redirect()->action('StatusController@index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
        try{
            $status->delete();

            $message = [
                'text' => "Success: Status ".$status->name." has been deleted.",
                'type' => "success"
            ];

            return redirect()->action('StatusController@index')->with('message', $message);
        }
        catch(\Illuminate\Database\QueryException $e){
            $message = [
                'text' => "Error: Patients are already assigned to this status",
                'type' => "error"
            ];

            return redirect()->action('StatusController@index')->with('message', $message);

        }
    }
}
