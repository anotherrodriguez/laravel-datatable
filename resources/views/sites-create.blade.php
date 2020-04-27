@extends('layouts.master')

@section('title', 'Create Sites')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::open(['action' => 'SiteController@store']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::text('name', $value = NULL,['class' => 'form-control']) }}
      <small id="siteHelp" class="form-text text-muted">Enter Site name.</small>
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