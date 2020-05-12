<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Requests\StatusUpdateRequest;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified', 'can:isAdmin'], ['except' => ['getStatuses']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available Sites
        return view('status/list');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $statuses = Status::with(['department.site'])->orderBy('list_order', 'asc')->get();
        return Datatables::of($statuses)->addColumn('action', function ($statuses) {
                return action('StatusController@edit', $statuses->id);
            })->make(true);
    }

    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatuses(Request $request)
    {
        $statuses = Status::where('department_id', $request->department_id)->orderBy('list_order', 'asc')->get();
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
        return view('status/create', ['sites' => $sites]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusStoreRequest $request)
    {
        //        
        $new_statuses = request('new_status');
        $old_statuses = request('status');

        foreach ($new_statuses as $key => $new_status) {
            $department = \App\Department::find(request('department_id'));

            $status = new Status;

            $status->name = $new_status['name'];
            $status->list_order = $new_status['order'];

            $department->status()->save($status);

        }

        if(isset($old_statuses)){

            foreach ($old_statuses as $key => $old_status) {
                
                $status = Status::find($old_status['id']);
                
                $status->update([
                'list_order' => $old_status['order']
                ]);
            }
        }

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
        return view('status/edit', ['status' => $status, 'sites' => $sites, 'departments' => $departments]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(StatusUpdateRequest $request, Status $status)
    {
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
