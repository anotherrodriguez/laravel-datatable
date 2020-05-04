@extends('layouts.master')

@section('title', 'Edit Department')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::model($department,['action'=>['DepartmentController@update',$department], 'method' => 'put']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id', $sites, $department->site->id, ['class' => 'form-control']) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::text('name', $value = NULL,['class' => 'form-control']) }}
      {{ Form::hidden('id', $department->id) }}
    </div>

    <button type="submit" class="btn btn-primary float-right">Update</button>

    {{ Form::close() }}

    {{ Form::model($department,['action'=>['DepartmentController@destroy',$department], 'method' => 'delete']) }}

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