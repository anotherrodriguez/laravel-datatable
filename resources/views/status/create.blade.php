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
      {{ Form::label('inputSite', 'Status Name')}}

        <div class="input-group mb-3">
      {{ Form::text('nameInput', $value = NULL,['class' => 'form-control', 'id' => 'statusName']) }}
          <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="add-status">+</button>
        </div>
      </div>

      {{ Form::label('inputSite', 'List Order')}}
        <!-- List with handle -->
      <div class="list-group" id="list-defaults">
        <div class="list-group" id="listWithHandle">
        </div>
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

    function buttonHtml(status, hiddenField){
      if(status.name=='Signed Up' | status.name=='Complete'){
        var button = '<button type="button" class="list-group-item list-group-item-action">'+status.name + hiddenField +'</button>';
        if(status.name=='Signed Up'){
          $('#listWithHandle').before(button);
        }
        else{
          $('#listWithHandle').after(button);
        }
      }
      else{
        var button = '<button type="button" class="list-group-item sortable list-group-item-action">'+status.name + hiddenField +'</button>';
        $('#listWithHandle').append(button);
      }
    };

    function setOrder(){
      var k = 0;
        $.each($('.status-order'), function(key, status){
          status.value = k;
          k++;
        });
     };

    // List with handle
    var sortable = $('#listWithHandle').sortable({
      handle: '.list-group-item',
      onUpdate: setOrder
    });

    var i = 0;

    $('#add-status').click(function(){
      var minusButton = '<span class="float-right minus-status"><i class="fas fa-minus"></i></span>';
      var buttonData = $('#statusName').val() + minusButton;
      var status = {'name': $('#statusName').val()};
      var hiddenField = '<input name="new_status['+i+'][name]" value="'+$('#statusName').val()+'" type="hidden">';
      hiddenField += '<input class="status-order" name="new_status['+i+'][order]" value="3" type="hidden">';
      var button = buttonHtml(status, minusButton+hiddenField);
      ++i;
      setOrder();
    });

    $('.list-group').on('click', '.minus-status', function(){
      $(this).parent().remove();
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
               $('#listWithHandle').html('');
                $.each(data, function(key, status){
                  
                  var hiddenField = '<input name="status['+i+'][id]" value="'+status.id+'" type="hidden">';
                  hiddenField += '<input class="status-order" name="status['+i+'][order]" value="'+status.list_order+'" type="hidden">';
                  
                  var button = buttonHtml(status, hiddenField);
                  
                   
                   i++;
                });
               }
            });
    });

@endpush