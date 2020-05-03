@extends('layouts.master')

@section('title', 'Statuses')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
                <th></th>
                <th>Status</th>
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
          order: [[ 3, 'asc' ]],
          ajax: '<?php echo route('status.getData'); ?>',
          columns: [
              { data: 'action', name: 'action', orderable: false, searchable: false, width: '30px'},
              { data: 'name'},
              { data: 'department.site.name'},
              { data: 'department.name'}
          ],
          rowGroup: {
            dataSrc: 'department.name'
        }
@endpush

@push('jQueryScriptDatatable')

    addButtonLink = '<?php echo action('StatusController@create'); ?>';

@endpush