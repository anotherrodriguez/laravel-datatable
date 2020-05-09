@extends('layouts.master')

@section('title', 'Statuses')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
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
          order: [[ 2, 'asc' ]],
          ajax: '<?php echo route('status.getData'); ?>',
          columns: [
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

    $('.bottom').append('<a href="'+ addButtonLink +'"><button type="button" class="btn btn-primary">add</button></a>');

@endpush