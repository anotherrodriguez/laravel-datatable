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
    </div>

    <div class="hide" id="phone-input-block">
      {{ Form::label('inputDepartment', 'Phone Number')}}
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
      $('.email-input').remove();
        $('.phone-input').remove();
        $('#email-input-block').removeClass('hide');
        $("#email-input-block").append(emailHtml);
        $('#phone-input-block').addClass('hide');
        break;
      case 'phone':
        $('.email-input').remove();
        $('.phone-input').remove();
        $('#email-input-block').addClass('hide');
        $('#phone-input-block').removeClass('hide');
        $("#phone-input-block").append(phoneHtml);
        break;
      case 'both':
        $('.email-input').remove();
        $('.phone-input').remove();
        $('#email-input-block').removeClass('hide');
        $('#phone-input-block').removeClass('hide');
        $("#email-input-block").append(emailHtml);
        $("#phone-input-block").append(phoneHtml);
        break;
      default:
        // code block
      } 
  })

  $('.input-group.date').datepicker({
    todayHighlight: true
  });

var emailHtml ='<div class="input-group mb-3 email-input" id="email_1"><input placeholder="Email" class="form-control" name="emails[]" type="email"><div class="input-group-append"><button class="btn btn-outline-secondary" type="button" id="add-email">+</button></div></div>';

var addEmailHtml = '<div class="input-group mb-3 email-input"><input placeholder="Email" class="form-control" name="emails[]" type="email"><div class="input-group-append"><button class="btn btn-outline-secondary minus-email" type="button">-</button></div></div>';

var phoneHtml = '<div class="input-group mb-3 phone-input" id="phone_number_1"><input placeholder="Phone Number" class="form-control phone-number" name="phones[]" type="text" inputmode="text"><div class="input-group-append"><button class="btn btn-outline-secondary" type="button" id="add-phone">+</button></div></div>';

var addPhoneHtml = '<div class="input-group mb-3 phone-input"><input placeholder="Phone Number" class="form-control phone-number" name="phones[]" type="text" inputmode="text"><div class="input-group-append"><button class="btn btn-outline-secondary minus-phone" type="button">-</button></div></div>';
  
    $('#email-input-block').on('click', '#add-email', function(){
      $("#email-input-block").append(addEmailHtml);
    });

    $('#phone-input-block').on('click', '#add-phone', function(){
      $("#phone-input-block").append(addPhoneHtml);
    });

    $('#email-input-block').on('click', '.minus-email', function(){
      $(this).parent().parent().remove();
        });

    $('#phone-input-block').on('click', '.minus-phone', function(){
      $(this).parent().parent().remove();
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

    $(".phone-number").inputmask({
      "mask": "(999) 999-9999",
      onUnMask: function(maskedValue, unmaskedValue) {
      //do something with the value
      return unmaskedValue;
      }
    });

@endpush