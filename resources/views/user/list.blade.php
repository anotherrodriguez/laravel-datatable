@extends('layouts.master')

@section('title', 'Users')

@section('content')
        <div class="row justify-content-center table-responsive mx-0">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Site</th>
                <th>Role</th>
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
          ajax: '<?php echo route('user.getData'); ?>',
          columns: [
              { data: 'name'},
              { data: 'site.name'},
              { data: 'role.name'},
          ],
@endpush

@push('jQueryScriptDatatable')


@endpush