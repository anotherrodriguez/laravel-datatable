@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::model($user,['action'=>['UserController@update',$user], 'method' => 'put']) }}

    <div class="form-group">
      {{ Form::label('inputUser', 'User Name')}}
      {{ Form::text('name', $value = NULL,['class' => 'form-control']) }}
      {{ Form::label('inputUser', 'Site')}}
      {{ Form::select('site_id', $sites, $user->site->id, ['class' => 'form-control']) }}
      {{ Form::label('inputUser', 'Role')}}
      {{ Form::select('role_id', $roles, $user->role->id, ['class' => 'form-control']) }}
      {{ Form::hidden('id', $user->id) }}
    </div>

    <button type="submit" class="btn btn-primary float-right">Update</button>

    {{ Form::close() }}

    {{ Form::model($user,['action'=>['UserController@destroy',$user], 'method' => 'delete']) }}


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