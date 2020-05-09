<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use Notification;
use App\Notifications\statusUpdated;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified', ['except' => ['create', 'store', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available Sites
        return view('patient/list');
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
                return action('PatientController@edit', $patients->id);
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
        return view('patient/create', ['sites' => $sites]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientStoreRequest $request)
    {
        //
        $status = \App\Status::find(request('status_id'));

        $patient = new Patient;

        $patient->first_name = request('first_name');
        $patient->last_name = request('last_name');
        $patient->date_of_service = Carbon::createFromFormat('m/d/Y', request('date_of_service'))->format('Y-m-d');

        $status->patient()->save($patient);

        $emails = request('emails');

        foreach ($emails as $key => $email_address) {
            $email = new \App\Email;
            $email->email = $email_address;
            $patient->email()->save($email);
        }

        $message = [
                'text' => "Success: Patient ".$patient->first_name." has been added",
                'type' => "success"
            ];

        return redirect()->action('PatientController@show', $patient)->with('message', $message);
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
        return view('patient/splash');
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
        $patient = Patient::with('status.department.site', 'email')->find($patient->id);
        $patient->date_of_service = Carbon::createFromFormat('Y-m-d', $patient->date_of_service)->format('m/d/Y');

        return view('patient/edit', ['patient' => $patient, 'sites' => $sites, 'departments' => $departments, 'statuses' => $statuses]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(PatientUpdateRequest $request, Patient $patient)
    {
        $status = \App\Status::find(request('status_id'));

        $patient->status()->associate($status);

        $patient->date_of_service = Carbon::createFromFormat('m/d/Y', request('date_of_service'))->format('Y-m-d');

         //Save Patient Data
        $patient->update([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
        ]);

        $message = [
                'text' => "Success: Patient ".$patient->first_name." has been updated",
                'type' => "success"
            ];

        Notification::send($patient, new statusUpdated($patient));

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
