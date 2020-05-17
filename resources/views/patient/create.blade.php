@extends('layouts.master')

@section('title', 'Patient Sign Up')

@php
$first_name_invalid = '';
$site_id_invalid = '';
$department_id_invalid = '';



if($errors){
$error = $errors->messages();
//dd($error);
if(isset($error['site_id'])){
  $site_id_invalid = 'is-invalid';
}

if(isset($error['department_id'])){
  $department_id_invalid = 'is-invalid';
}

if(isset($error['first_name'])){
  $first_name_invalid = 'is-invalid';
}

if(isset($error['last_name'])){
  $last_name_invalid = 'is-invalid';
}

if(isset($error['date_of_service'])){
  $date_of_service_invalid = 'is-invalid';
}

}

//
@endphp


@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::open(['action' => 'PatientController@store']) }}

    <div class="form-group">
      <div class="form-group row">
        {{ Form::select('site_id',$sites,null, ['placeholder' => 'Pick a site...', 'class' => 'form-control form-control-lg', 'id' => 'site_id']) }}

            <span class="invalid-feedback hide" role="alert">
                <strong id="site_id-error-message">test</strong>
            </span>
      </div>

      <div class="form-group row">
        {{ Form::select('department_id',[],null, ['placeholder' => 'Pick a department...', 'class' => 'form-control form-control-lg', 'id' => 'department_id']) }}

            <span class="invalid-feedback hide" role="alert">
                <strong id="department_id-error-message">test</strong>
            </span>

      </div>

      <div class="form-group row">
        {{ Form::text('first_name', $value = NULL, ['placeholder' => 'First Name', 'class' => 'form-control form-control-lg', 'id' => 'first_name']) }}
            <span class="invalid-feedback hide" role="alert">
                <strong id="first_name-error-message">test</strong>
            </span>
      </div>

      <div class="form-group row">
        {{ Form::text('last_name', $value = NULL,['placeholder' => 'Last Name', 'class' => 'form-control form-control-lg',  'id' => 'last_name']) }}
          <span class="invalid-feedback hide" role="alert">
              <strong id="last_name-error-message">test</strong>
          </span>
      </div>

      
      <div class="form-group row">
        <div class="input-group date">
           <input id="date_of_service" type="text" name="date_of_service" placeholder="Date of Service" class="form-control form-control-lg">
            <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button"><i class="far fa-calendar-alt"></i></button>
          </div>
        </div>
          <span class="invalid-feedback hide" role="alert">
              <strong id="date_of_service-error-message">test</strong>
          </span>
       </div> 

      <div class="form-group row">
        {{ Form::label('inputDepartment', 'Notification Method')}}
        <div class="input-group mb-3">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="notification" id="emailRadio" is-invalid value="email">
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
          <span class="invalid-feedback hide" role="alert">
            <strong id="notification-error-message">test</strong>
          </span>
      </div>

      <div class="hide" id="email-input-block"></div>

      <div class="hide" id="phone-input-block"></div>

        <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="hippa" name="hippa">
      <label class="form-check-label" for="gridCheck">
       I hereby authorize Case Follow to release limited information via phone or email to the following representatives. 
       I have reviewed the medical record information release (HIPPA) information included
      </label>
       <span class="invalid-feedback hide" role="alert">
            <strong id="hippa-error-message">test</strong>
          </span>
    </div>
  </div>
    </div>

      <button type="submit" class="btn btn-primary float-right">Submit</button>
      {{ Form::close() }}

    </div>

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

var emailHtml ='<div class="form-group row email-input"><div class="input-group" ><input placeholder="Email" class="form-control form-control-lg emails" name="emails[]" id="emails_0" type="email"><div class="input-group-append"><button class="btn btn-outline-secondary" type="button" id="add-email">+</button></div></div><span class="invalid-feedback hide" role="alert"><strong id="emails_0-error-message">test</strong></span></div>';

var i = 0;

var addEmailHtml = '<div class="form-group row email-input"><div class="input-group"><input placeholder="Email" class="form-control form-control-lg additionalEmails" name="emails[]" type="email"><div class="input-group-append"><button class="btn btn-outline-secondary minus-email" type="button">-</button></div></div><span class="invalid-feedback hide" role="alert"><strong id="emails_1-error-message">test</strong></span></div>';

var phoneHtml = '<div class="form-group row phone-input"><div class="input-group"><input placeholder="Phone Number" class="form-control phone-number form-control-lg" id="phone_numbers_0" name="phone_numbers[]" type="text" inputmode="text"><div class="input-group-append"><button class="btn btn-outline-secondary" type="button" id="add-phone">+</button></div></div><span class="invalid-feedback hide" role="alert"><strong id="phone_numbers_0-error-message">test</strong></span></div>';

var addPhoneHtml = '<div class="form-group row phone-input"><div class="input-group"><input placeholder="Phone Number" class="form-control form-control-lg phone-number additionalPhones" name="phone_numbers[]" type="text" inputmode="text"><div class="input-group-append"><button class="btn btn-outline-secondary minus-phone" type="button">-</button></div></div><span class="invalid-feedback hide" role="alert"><strong id="phone_numbers_1-error-message">test</strong></span></div>';

    function reorderIds(){
      var i=0;
      $.each($('.additionalEmails'), function(){
        i++;
        $(this).attr('id', 'emails_'+i);
        $(this).parent().next().children().attr('id', 'emails_'+i+'-error-message');
      });

      i=0;
      $.each($('.additionalPhones'), function(){
        i++;
        $(this).attr('id', 'phone_numbers_'+i);
        $(this).parent().next().children().attr('id', 'phone_numbers_'+i+'-error-message');
      });


    };
  
    $('#email-input-block').on('click', '#add-email', function(){
      $("#email-input-block").append(addEmailHtml);
      reorderIds();
    });

    $('#phone-input-block').on('click', '#add-phone', function(){
      $("#phone-input-block").append(addPhoneHtml);
      reorderIds();
    });

    $('#email-input-block').on('click', '.minus-email', function(){
      $(this).parent().parent().parent().remove();
      reorderIds();
    });

    $('#phone-input-block').on('click', '.minus-phone', function(){
      $(this).parent().parent().parent().remove();
      reorderIds();
    });

    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#site_id').change(function(){
       $.ajax({
               type:'POST',
               url:'/getDepartments',
               data:{
               'site_id':$(this).val()
                },
               success:function(data) {
               var options = '<option selected="selected" value="">Pick a department...</option>';
               $.each(data, function(key, department){
                  options += '<option value="'+department.id+'">'+department.name+'</option>';
                });
                $('#department_id').html(options);
               }
            });
    });


    
    $( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      var $form = $(this);
      var data = $form.serialize() 
       $.ajax({
               type:'POST',
                url:'/validatePatient',
               data: data
                ,
               success:function(data) {
                $form.off('submit').submit();
               },
               error: function (err) {
                if (err.status == 422) { // when status code is 422, it's a validation issue

                    // you can loop through the errors object and show it to the user
                    
                    // display errors on each form field
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').addClass('hide');
                    console.log(err.responseJSON.errors);
                    $.each(err.responseJSON.errors, function (index, error) {
                        index = index.replace(".", "_");
                        $('#'+index).addClass('is-invalid');
                        $('#'+index+'-error-message').html(error);
                        $('#'+index+'-error-message').parent().removeClass('hide');
                    });
                }
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