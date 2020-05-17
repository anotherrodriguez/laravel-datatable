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
use App\Notifications\patientCreated;
use Illuminate\Support\Facades\Auth;
use App\Traits\SiteTrait;

class PatientController extends Controller
{
    use SiteTrait;

    public function __construct()
    {
        $this->middleware(['verified'], ['except' => ['create', 'store', 'show', 'validatePatient']]);
        $this->authorizeResource(Patient::class, 'patient');
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
        $user = Auth::user();
        if($user->isSuperAdmin()){
            $patients = Patient::with(['status.department.site'])->get();
            return Datatables::of($patients)->addColumn('action', function ($patients) {
                return action('PatientController@edit', $patients->id);
            })->make(true);

        }
        else{
            $patients = Patient::with(['status.department.site'])->whereHas('status.department.site', function($q){
            $q->where('id', Auth::user()->site->id);
            })->get();
            return Datatables::of($patients)->addColumn('action', function ($patients) {
                return action('PatientController@edit', $patients->id);
            })->make(true);

        }
        
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
        $status = \App\Status::where([['department_id', request('department_id')], ['name', 'Signed Up']])->firstOrFail();

        $patient = new Patient;

        $patient->first_name = request('first_name');
        $patient->last_name = request('last_name');
        $patient->date_of_service = Carbon::createFromFormat('m/d/Y', request('date_of_service'))->format('Y-m-d');

        $status->patient()->save($patient);

        if ($request->has('emails')) {

            $emails = request('emails');

            foreach ($emails as $key => $email_address) {
                $email = new \App\Email;
                $email->email = $email_address;
                $patient->email()->save($email);
            }
        }

        if ($request->has('phone_numbers')) {

            $phone_numbers = request('phone_numbers');

            foreach ($phone_numbers as $key => $number) {
                $phone_number = new \App\PhoneNumber;
                $phone_number->phone_number = $number;
                $patient->phoneNumber()->save($phone_number);
            }
        }

        $patient->load('email');
        $patient->load('phoneNumber');

        Notification::send($patient, new patientCreated($patient));
        return redirect()->action('PatientController@show', $patient);
    }

    public function validatePatient(PatientStoreRequest $request)
    {
        

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
        $sites = $this->getSites(Auth::user());
        $departments = $this->getDepartments(Auth::user());
        $statuses = \App\Status::where('department_id', $patient->status->department->id)->orderBy('list_order', 'asc')->pluck('name', 'id')->toArray();
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
        $new_status = \App\Status::find(request('status_id'));
        $old_status =  \App\Status::find($patient->status_id);

        if($new_status != $old_status){
            if($new_status->list_order >= $old_status->list_order){
                $patient->status()->associate($new_status);
                $patient->save();
                Notification::send($patient, new statusUpdated($patient));
            }
            else{
                $message = [
                                'text' => "Error: Patient status can not reverse in order",
                                'type' => "error"
                            ];

                return redirect()->action('PatientController@index')->with('message', $message);
            }
        }

        if($request->has('date_of_service')){
            $patient->date_of_service = Carbon::createFromFormat('m/d/Y', request('date_of_service'))->format('Y-m-d');

             //Save Patient Data
            $patient->update([
                'first_name' => request('first_name'),
                'last_name' => request('last_name'),
            ]);

            if ($request->has('emails')) {

                $emails = request('emails');

                foreach ($emails as $key => $email_address) {
                    $email = new \App\Email;
                    $email->email = $email_address;
                    $patient->email()->save($email);
                }
            }

            if ($request->has('phone_numbers')) {

                $phone_numbers = request('phone_numbers');

                foreach ($phone_numbers as $key => $number) {
                    $phone_number = new \App\PhoneNumber;
                    $phone_number->phone_number = $number;
                    $patient->phoneNumber()->save($phone_number);
                }
            }
        }

        $message = [
                'text' => "Success: Patient ".$patient->first_name." has been updated with status of: ".$patient->status->name,
                'type' => "success"
            ];
        

        if($new_status->isComplete()){
            $patient->email()->delete();
            $patient->phoneNumber()->delete();
            $patient->delete();
        }

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
