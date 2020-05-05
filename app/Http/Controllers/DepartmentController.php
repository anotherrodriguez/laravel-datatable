<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified', ['except' => ['getDepartments']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available Sites
        return view('departments');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $departments = Department::with('site')->get();
        return Datatables::of($departments)->addColumn('action', function ($departments) {
                return action('DepartmentController@edit', $departments->id);
            })->make(true);
    }

    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments(Request $request)
    {
        $departments = Department::where('site_id', $request->site_id)->get();
        return response()->json($departments);
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
        return view('departments-create', ['sites' => $sites]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreRequest $request)
    {
        //Save Department Data
        $validated = $request->validated();

        $site = \App\Site::find(request('site_id'));

        $department = new Department;

        $department->name = request('name');

        $site->department()->save($department);

        $message = [
            'text' => "Success: Department ".$department->name." has been created.",
            'type' => "success"
        ];

        return redirect()->action('DepartmentController@index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
        $sites = \App\Site::pluck('name', 'id')->toArray();
        $department = Department::with('site')->find($department->id);
        return view('departments-edit', ['department' => $department, 'sites' => $sites]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        //Save Department Data
        $validated = $request->validated();

        $site = \App\Site::find(request('site_id'));

        $department->site()->associate($site);

        $department->update(['name'=>request('name')]);

        $message = [
            'text' => "Success: Department ".$department->name." has been updated.",
            'type' => "success"
        ];

        return redirect()->action('DepartmentController@index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
        try{
            $department->delete();

            $message = [
                'text' => "Sucess: Department ".$department->name." has been deleted.",
                'type' => "success"
            ];

            return redirect()->action('DepartmentController@index')->with('message', $message);
        }
        catch(\Illuminate\Database\QueryException $e){
            $message = [
                'text' => "Error: Status is already assigned to this department.",
                'type' => "error"
            ];

            return redirect()->action('DepartmentController@index')->with('message', $message);

        }

    }
}
