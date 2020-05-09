@extends('layouts.master')

@section('title', 'Sites')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
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
          ajax: '<?php echo route('site.getData'); ?>',
          columns: [
              { data: 'name'},
              { data: 'address'},
              { data: 'city'},
              { data: 'state'},
              { data: 'zip_code'}
          ]
@endpush

@push('jQueryScriptDatatable')

    addButtonLink = '<?php echo action('SiteController@create'); ?>';

    $('.bottom').append('<a href="'+ addButtonLink +'"><button type="button" class="btn btn-primary">add</button></a>');

@endpush