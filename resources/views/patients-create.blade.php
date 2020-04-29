@extends('layouts.master')

@section('title', 'Create Patients')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::open(['action' => 'PatientController@store']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id',$sites,null, ['placeholder' => 'Pick a site...', 'class' => 'form-control', 'id' => 'site_select']) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::select('department_id',[],null, ['placeholder' => 'Pick a department...', 'class' => 'form-control', 'id' => 'department_select']) }}
      {{ Form::label('inputDepartment', 'Status')}}
      {{ Form::select('status_id',[],null, ['placeholder' => 'Pick a status...', 'class' => 'form-control', 'id' => 'status_select']) }}
      {{ Form::text('first_name', $value = NULL,['class' => 'form-control']) }}
      <small id="siteHelp" class="form-text text-muted">Enter first name.</small>
      {{ Form::text('last_name', $value = NULL,['class' => 'form-control']) }}
      <small id="siteHelp" class="form-text text-muted">Enter last name.</small>
      {{ Form::email('email', $value = NULL,['class' => 'form-control']) }}
      <small id="siteHelp" class="form-text text-muted">Enter email.</small>
      {{ Form::text('phone_number', $value = NULL,['class' => 'form-control', 'id' => 'phone']) }}
      <small id="siteHelp" class="form-text text-muted">Enter phone number.</small>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
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
               var options = '<option selected="selected" value="">Pick a department...</option>';
               $.each(data, function(key, department){
                  console.log(department.name);
                  options += '<option value="'+department.id+'">'+department.name+'</option>';
                });
                $('#department_select').html(options);
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


    $("#phone").inputmask({
      "mask": "(999) 999-9999",
      onUnMask: function(maskedValue, unmaskedValue) {
      //do something with the value
      return unmaskedValue;
      }
    });

@endpush