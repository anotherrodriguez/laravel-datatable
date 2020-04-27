@extends('layouts.master')

@section('title', 'Edit Status')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::model($status,['action'=>['StatusController@update',$status], 'method' => 'put']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id', $sites, $status->department->site->id, ['class' => 'form-control', 'id' => 'site_select']) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::select('department_id', $departments, $status->department->id, ['placeholder' => 'Pick a department...', 'class' => 'form-control', 'id' => 'department_select']) }}
      {{ Form::label('inputDepartment', 'Status')}}
      {{ Form::text('name', $value = NULL,['class' => 'form-control']) }}
    </div>

    <button type="submit" class="btn btn-primary float-right">Update</button>

    {{ Form::close() }}

    {{ Form::model($status,['action'=>['StatusController@destroy',$status], 'method' => 'delete']) }}

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
               }
            });
    });

@endpush