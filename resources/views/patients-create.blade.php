@extends('layouts.master')

@section('title', 'Patient Sign Up')

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

      {{ Form::label('inputDepartment', 'First Name')}}
      {{ Form::text('first_name', $value = NULL, ['placeholder' => 'First Name', 'class' => 'form-control']) }}

      {{ Form::label('inputDepartment', 'Last Name')}}
      {{ Form::text('last_name', $value = NULL,['placeholder' => 'Last Name', 'class' => 'form-control']) }}

      {{ Form::label('inputDepartment', 'Date of Service')}}
      <div class="input-group date">
         <input type="text" name="date_of_service" class="form-control">
          <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button"><i class="far fa-calendar-alt"></i></button>
        </div>
      </div>

      {{ Form::label('inputDepartment', 'Notification Method')}}
      <div class="input-group mb-3">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="notification" id="emailRadio" value="email">
          <label class="form-check-label" for="inlineRadio1">Email</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="notification" id="textRadio" value="phone">
          <label class="form-check-label" for="inlineRadio2">SMS Text</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="notification" id="bothRadio" value="both">
          <label class="form-check-label" for="inlineRadio3">Both</label>
        </div>
      </div>

    <div class="hide" id="email-input-block">
      {{ Form::label('inputDepartment', 'Email')}}
        <div class="input-group mb-3" id="email_1">
        {{ Form::email('email_1', $value = NULL,['placeholder' => 'Email', 'class' => 'form-control']) }}
          <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="add-email">+</button>
        </div>
      </div>

      <div class="input-group mb-3 email-input hide" id="email_2">
        {{ Form::email('email_2', $value = NULL,['placeholder' => 'Email', 'class' => 'form-control']) }}
          <div class="input-group-append">
        <button class="btn btn-outline-secondary minus-email" type="button" id="minus-email_2">-</button>
        </div>
      </div>

      <div class="input-group mb-3 email-input hide" id="email_3">
        {{ Form::email('email_3', $value = NULL,['placeholder' => 'Email', 'class' => 'form-control']) }}
          <div class="input-group-append">
        <button class="btn btn-outline-secondary minus-email" type="button" id="minus-email_3">-</button>
        </div>
      </div>

      <div class="input-group mb-3 hide" id="max-email-message"><small>Maximum Emails Reached</small></div>
    </div>

    <div class="hide" id="phone-input-block">
      {{ Form::label('inputDepartment', 'Phone Number')}}
      <div class="input-group mb-3" id="phone_number_1">
        {{ Form::text('phone_number_1', $value = NULL,['placeholder' => 'Phone Number', 'class' => 'form-control phone-number']) }}
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="add-phone">+</button>
        </div>
      </div>

      <div class="input-group mb-3 phone-input hide" id="phone_number_2">
        {{ Form::text('phone_number_2', $value = NULL,['placeholder' => 'Phone Number', 'class' => 'form-control phone-number']) }}
        <div class="input-group-append">
          <button class="btn btn-outline-secondary minus-phone" type="button" id="minus-phone_number_2">-</button>
        </div>
      </div>

      <div class="input-group mb-3 phone-input hide" id="phone_number_3">
        {{ Form::text('phone_number_3', $value = NULL,['placeholder' => 'Phone Number', 'class' => 'form-control phone-number']) }}
        <div class="input-group-append">
          <button class="btn btn-outline-secondary minus-phone" type="button" id="minus-phone_number_3">-</button>
        </div>
      </div>

      <div class="input-group mb-3 hide" id="max-phone-message"><small>Maximum Phone Numbers Reached</small></div>
    </div>

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

  $('.form-check-input').click(function(){
    switch($(this).val()) {
      case 'email':
        $('#email-input-block').removeClass('hide');
        $('#phone-input-block').addClass('hide');
        break;
      case 'phone':
        $('#email-input-block').addClass('hide');
        $('#phone-input-block').removeClass('hide');
        break;
      case 'both':
        $('#email-input-block').removeClass('hide');
        $('#phone-input-block').removeClass('hide');
        break;
      default:
        // code block
      } 
  })

  $('.input-group.date').datepicker({
    todayHighlight: true
  });


    var emailIds = [];

    function addFields(fieldArray){
      if(fieldArray.length!=0){
          var fieldId = fieldArray[0];
          $('#'+fieldId).css('display', 'flex');
          $('#'+fieldId).addClass('show');
        }
      else{
        $('#max-email-message').css('display', 'flex');
      }
    }
  
    $('#add-email').click(function(){
      emailIds = $(".email-input").not('.show').map(function() { return this.id; });
      addFields(emailIds);
    });

    $('#add-phone').click(function(){
      phoneIds = $(".phone-input").not('.show').map(function() { return this.id; });
      addFields(phoneIds);
    });

    $('.minus-email').click(function(){
       var minusId = $(this).attr('id');
       var emailId = minusId.split('-')[1];
       emailIds.push('#'+emailId);
       $('#'+emailId).css('display', 'none');
       $('#'+emailId).removeClass('show');
       $('#max-email-message').css('display', 'none');
        });

    $('.minus-phone').click(function(){
       var minusId = $(this).attr('id');
       var phoneId = minusId.split('-')[1];
       phoneIds.push('#'+phoneId);
       $('#'+phoneId).css('display', 'none');
       $('#'+phoneId).removeClass('show');
       $('#max-phone-message').css('display', 'none');
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


    $(".phone-number").inputmask({
      "mask": "(999) 999-9999",
      onUnMask: function(maskedValue, unmaskedValue) {
      //do something with the value
      return unmaskedValue;
      }
    });

@endpush