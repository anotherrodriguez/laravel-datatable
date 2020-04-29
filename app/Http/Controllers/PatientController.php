<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available Sites
        return view('patients');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $patients = Patient::with(['status.department.site'])->get();
        return Datatables::of($patients)->addColumn('action', function ($patients) {
                return '<a href="'.action('PatientController@edit', $patients->id).'"><i class="fad fa-pencil-alt"></i></a>';
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
        $sites = \App\Site::pluck('name', 'id')->toArray();
        return view('patients-create', ['sites' => $sites]);
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
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'status_id' => ['required']
        ]);

        $status = \App\Status::find(request('status_id'));

        $patient = new Patient;

        $patient->first_name = request('first_name');
        $patient->last_name = request('last_name');
        $patient->email = request('email');
        $patient->phone_number = request('phone_number');

        $status->patient()->save($patient);

        $message = [
                'text' => "Success: Patient ".$patient->first_name." has been added",
                'type' => "success"
            ];

        return redirect()->action('PatientController@index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
        $sites = \App\Site::pluck('name', 'id')->toArray();
        $departments = \App\Department::pluck('name', 'id')->toArray();
        $statuses = \App\Status::where('department_id', $patient->status->department->id)->pluck('name', 'id')->toArray();
        $patient = Patient::with('status.department.site')->find($patient->id);
        return view('patients-edit', ['patient' => $patient, 'sites' => $sites, 'departments' => $departments, 'statuses' => $statuses]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'phone_number' => ['size:10'],
            'status_id' => ['required']
        ]);

        $status = \App\Status::find(request('status_id'));

        $patient->status()->associate($status);

         //Save Patient Data
        $patient->update([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone_number' => request('phone_number')
        ]);

        $message = [
                'text' => "Success: Patient ".$patient->first_name." has been updated",
                'type' => "success"
            ];

        return redirect()->action('PatientController@index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
        $patient->delete();

        $message = [
                'text' => "Success: Patient ".$patient->first_name." has been deleted",
                'type' => "success"
            ];

        return redirect()->action('PatientController@index')->with('message', $message);
    }
}
