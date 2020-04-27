@extends('layouts.master')

@section('title', 'Create Status')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::open(['action' => 'StatusController@store']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id',$sites,null, ['placeholder' => 'Pick a site...', 'class' => 'form-control', 'id' => 'site_select']) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::select('department_id',[],null, ['placeholder' => 'Pick a department...', 'class' => 'form-control', 'id' => 'department_select']) }}
      {{ Form::text('name', $value = NULL,['class' => 'form-control']) }}
      <small id="siteHelp" class="form-text text-muted">Enter status name.</small>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    {{ Form::close() }}

    @error('name')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror

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

@endpush