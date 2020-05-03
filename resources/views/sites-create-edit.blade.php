@extends('layouts.master')

@section('title', 'Create Sites')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

@if (isset($edit))
    {{ Form::model($site,['action'=>['SiteController@update',$site], 'method' => 'put']) }}
@else
    {{ Form::open(['action' => 'SiteController@store']) }}
@endif

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::text('name', $value = NULL,['class' => 'form-control']) }}
      {{ Form::label('inputSite', 'Address')}}
      {{ Form::text('address', $value = NULL,['class' => 'form-control']) }}
      {{ Form::label('inputSite', 'City')}}
      {{ Form::text('city', $value = NULL,['class' => 'form-control']) }}
      {{ Form::label('inputSite', 'State')}}
      {{ Form::select('state', $states, null, ['placeholder' => 'Pick a state...', 'class' => 'form-control']) }}
      {{ Form::label('inputSite', 'Zip Code')}}
      {{ Form::text('zip_code', $value = NULL,['class' => 'form-control']) }}
    </div>

@if (isset($edit))
    <button type="submit" class="btn btn-primary float-right">Update</button>
@else
    <button type="submit" class="btn btn-primary">Submit</button>
@endif

    {{ Form::close() }}

@if (isset($edit))
    {{ Form::model($site,['action'=>['SiteController@destroy',$site], 'method' => 'delete']) }}

    <button class="btn btn-danger float-left"><i class="fad fa-trash-alt"></i> Delete</button>

    {{ Form::close() }}
@else
    
@endif

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