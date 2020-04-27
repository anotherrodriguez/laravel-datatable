@extends('layouts.master')

@section('title', 'Sites')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
              </tr>
            </thead>
             <tbody>
             </tbody>
          </table>
        </div>
@endsection

@section('datatable', true)

@push('datatableOptions')
          ajax: '<?php echo route('site.getData'); ?>',
          columns: [
              { data: 'action', name: 'action', orderable: false, searchable: false, width: '30px'},
              { data: 'id', name: 'id' },
              { data: 'name', name: 'name' }
          ]
@endpush

@push('jQueryScriptDatatable')

    addButtonLink = '<?php echo action('SiteController@create'); ?>';

@endpush