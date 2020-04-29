@extends('layouts.master')

@section('title', 'Edit Patient')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::model($patient,['action'=>['PatientController@update',$patient], 'method' => 'put']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id', $sites, $patient->status->department->site->id, ['class' => 'form-control', 'id' => 'site_select']) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::select('department_id', $departments, $patient->status->department->id, ['placeholder' => 'Pick a department...', 'class' => 'form-control', 'id' => 'department_select']) }}
      {{ Form::label('inputDepartment', 'Status')}}
      {{ Form::select('status_id', $statuses, $patient->status->id, ['placeholder' => 'Pick a status...', 'class' => 'form-control', 'id' => 'status_select']) }}
      {{ Form::label('inputDepartment', 'First Name')}}
      {{ Form::text('first_name', $value = NULL,['class' => 'form-control']) }}
      {{ Form::label('inputDepartment', 'Last Name')}}
      {{ Form::text('last_name', $value = NULL,['class' => 'form-control']) }}
      {{ Form::label('inputDepartment', 'email')}}
      {{ Form::text('email', $value = NULL,['class' => 'form-control', 'disabled' => 'disabled']) }}
      {{ Form::label('inputDepartment', 'Phone Number')}}
      {{ Form::text('phone_number', $value = NULL,['class' => 'form-control', 'disabled' => 'disabled']) }}
    </div>

    <button type="submit" class="btn btn-primary float-right">Update</button>

    {{ Form::close() }}

    {{ Form::model($patient,['action'=>['PatientController@destroy',$patient], 'method' => 'delete']) }}

    <button class="btn btn-danger float-left"><i class="fad fa-trash-alt"></i> Delete</button>

    {{ Form::close() }}

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  </div>
</div>
@endsection

@push('jQueryScript')

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#site_select').change(function(){
       $.ajax({
               type:'POST',
               url:'/getDepartments',
               data:{
               'site_id':$(this).val()
                },
               success:function(data) {
               var option = '<option selected="selected" value="">Pick a department...</option>';
               var options = option;
               $.each(data, function(key, department){
                  console.log(department.name);
                  options += '<option value="'+department.id+'">'+department.name+'</option>';
                });
                $('#department_select').html(options);
                $('#status_select').html('<option selected="selected" value="">Pick a status...</option>');
               }
            });
    });

    $('#department_select').change(function(){
       $.ajax({
               type:'POST',
               url:'/getStatuses',
               data:{
               'department_id':$(this).val()
                },
               success:function(data) {
               var options = '<option selected="selected" value="">Pick a status...</option>';
               $.each(data, function(key, status){
                  options += '<option value="'+status.id+'">'+status.name+'</option>';
                });
                $('#status_select').html(options);
               }
            });
    })

@endpush