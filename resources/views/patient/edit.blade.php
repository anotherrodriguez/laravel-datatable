@extends('layouts.master')

@section('title', 'Edit Patient')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">
@php    
$disabled = true;

if($patient->status->list_order==0){
   $disabled = false;
}
@endphp

    {{ Form::model($patient,['action'=>['PatientController@update',$patient], 'method' => 'put']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id', $sites, $patient->status->department->site->id, ['class' => 'form-control', 'id' => 'site_select', 'disabled' => $disabled]) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::select('department_id', $departments, $patient->status->department->id, ['placeholder' => 'Pick a department...', 'class' => 'form-control', 'id' => 'department_select', 'disabled' => $disabled]) }}

      {{ Form::label('inputDepartment', 'Status')}}
      {{ Form::select('status_id', $statuses, $patient->status->id, ['placeholder' => 'Pick a status...', 'class' => 'form-control', 'id' => 'status_select']) }}

      {{ Form::label('inputDepartment', 'First Name')}}
      {{ Form::text('first_name', $value = NULL,['class' => 'form-control', 'disabled' => $disabled]) }}
      {{ Form::label('inputDepartment', 'Last Name')}}
      {{ Form::text('last_name', $value = NULL,['class' => 'form-control', 'disabled' => $disabled]) }}
      {{ Form::label('inputDepartment', 'Date of Service')}}
      <div class="input-group date">
         <input type="text" name="date_of_service" value="{{$patient->date_of_service}}" class="form-control" @if($disabled) disabled @endif>
          <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button"><i class="far fa-calendar-alt"></i></button>
        </div>
      </div>
 
@forelse ($patient->email as $email)
      {{ Form::label('inputDepartment', 'email')}}
      {{ Form::text('email[]', $email->email,['class' => 'form-control', 'disabled' => true]) }}
@empty
    
@endforelse

@forelse ($patient->phoneNumber as $phoneNumber)
      {{ Form::label('inputDepartment', 'phoneNumber')}}
      {{ Form::text('phoneNumber[]', $phoneNumber->phone_number,['class' => 'form-control', 'disabled' => true]) }}
@empty
    
@endforelse

    </div>

    <div id="submit-button">
      <button type="submit" class="btn btn-primary float-right">Save changes</button>
    </div>

        <!-- Button trigger modal -->
    <div id="modal-button" class="hide">
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
        Save changes
      </button>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        The patient will be removed from the list
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

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

  $('.input-group.date').datepicker({
    todayHighlight: true
  });

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

    var modalHtml = $('#modal-button').html();
    var submitHtml = $('#submit-button').html();

    $('#status_select').change(function(){

      if($('#status_select option:selected').text() === 'Complete'){
        $('#submit-button').html(modalHtml);
      }
      else{
        $('#submit-button').html(submitHtml);
      }    
       
    })

@endpush