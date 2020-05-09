@extends('layouts.master')

@section('title', 'Patients')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
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
          order: [[ 0, 'asc' ]],
          ajax: '<?php echo route('patient.getData'); ?>',
          columns: [
              { data: 'first_name', 
              render: function ( data, type, row, meta ) {

                var first_name = data;
                var last_name = row.last_name;
                var display_name = first_name.substr(0,1)+'. '+last_name;

                if(type==='display'){
                  data = display_name;
                }
                if(type==='filter' || type==='type'){
                  data = first_name+' '+last_name+' '+display_name;
                }
                return data;
              }},
              { data: 'status.name'},
              { data: 'status.department.site.name'},
              { data: 'date_of_service'},
              { data: 'status.department.name', name: 'name' }
          ]
@endpush