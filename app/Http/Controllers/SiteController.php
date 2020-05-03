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
        $sites = Site::select(['id', 'name', 'address', 'city', 'state', 'zip_code'])->get();
        return Datatables::of($sites)->addColumn('action', function ($sites) {
                return '<a href="'.action('SiteController@edit', $sites->id).'"><i class="fad fa-pencil-alt"></i></a>';
            })->make(true);
    }

    public static $states = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming'             
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Show form to add new Sites
        return view('sites-create-edit', ['states' => self::$states]);
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
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'zip_code' => ['required']
        ]);

        $site = new Site;

        $site->name = request('name');
        $site->address = request('address');
        $site->city = request('city');
        $site->state = request('state');
        $site->zip_code = request('zip_code');

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
        return view('sites-create-edit',['site' => Site::find($site->id), 'states' => self::$states, 'edit' => true]);
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

        $site->update([
            'name'=>request('name'),
            'address'=>request('address'),
            'city'=>request('city'),
            'state'=>request('state'),
            'zip_code'=>request('zip_code'),
        ]);

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
