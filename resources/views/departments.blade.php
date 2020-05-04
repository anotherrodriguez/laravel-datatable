@extends('layouts.master')

@section('title', 'Departments')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
                <th></th>
                <th>Site</th>
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
          ajax: '<?php echo route('department.getData'); ?>',
          columns: [
              { data: 'action', name: 'action', orderable: false, searchable: false, width: '30px'},
              { data: 'site.name'},
              { data: 'name', name: 'name' }
          ]
@endpush

@push('jQueryScriptDatatable')

    addButtonLink = '<?php echo action('DepartmentController@create'); ?>';

    $('.bottom').append('<a href="'+ addButtonLink +'"><button type="button" class="btn btn-primary">add</button></a>');

@endpush