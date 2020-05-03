@extends('layouts.master')

@section('title', 'Patients')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
                <th></th>
                <th>Patient</th>
                <th>Status</th>
                <th>Site</th>
                <th>Date of Service</th>
                <th>Department</th>
              </tr>
            </thead>
             <tbody>
             </tbody>
          </table>
        </div>
@endsection

@section('datatable', true)

@push('datatableOptions')
          order: [[ 1, 'asc' ]],
          ajax: '<?php echo route('patient.getData'); ?>',
          columns: [
              { data: 'action', name: 'action', orderable: false, searchable: false, width: '30px'},
              { data: 'first_name', 
              render: function ( data, type, row, meta ) {
              return data.substr(0,1)+'. '+row.last_name;
              }},
              { data: 'status.name'},
              { data: 'status.department.site.name'},
              { data: 'date_of_service'},
              { data: 'status.department.name', name: 'name' }
          ]
@endpush

@push('jQueryScriptDatatable')

    addButtonLink = '<?php echo action('PatientController@create'); ?>';

@endpush