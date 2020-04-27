@extends('layouts.master')

@section('title', 'Create Departments')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::open(['action' => 'DepartmentController@store']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id',$sites,null, ['placeholder' => 'Pick a site...', 'class' => 'form-control']) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::text('name', $value = NULL,['class' => 'form-control']) }}
      <small id="siteHelp" class="form-text text-muted">Enter Department name.</small>
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