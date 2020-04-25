@extends('layouts.master')

@section('title', 'Sites')

@section('content')
        <div class="table-responsive">
          <table id="patient-table" class="table table-striped display nowrap" style="width:100%">
            <thead>
              <tr>
                <th>Patient ID</th>
                <th>Department</th>
                <th>Check in Date</th>
                <th>Status</th>
                <th>Edit</th>
              </tr>
            </thead>
             <tbody>
             </tbody>
          </table>
        </div>
@endsection

@push('datatableOptions')
          ajax: '<?php echo route('site.getData'); ?>',
          columns: [
              { data: 'id', name: 'id' },
              { data: 'name', name: 'name' },
              { data: 'created_at', name: 'created_at' },
              { data: 'updated_at', name: 'updated_at' },
              { data: 'action', name: 'action', orderable: false, searchable: false}
          ]
@endpush

@push('jQueryScript')



@endpush