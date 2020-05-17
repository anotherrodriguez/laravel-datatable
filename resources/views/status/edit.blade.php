@extends('layouts.master')

@section('title', 'Edit Status')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-sm-6">

    {{ Form::model($status,['action'=>['StatusController@update',$status], 'method' => 'put']) }}

    <div class="form-group">
      {{ Form::label('inputSite', 'Site Name')}}
      {{ Form::select('site_id', $sites, $status->department->site->id, ['class' => 'form-control', 'id' => 'site_select', 'disabled' => 'disabled']) }}
      {{ Form::label('inputDepartment', 'Department Name')}}
      {{ Form::select('department_id', $departments, $status->department->id, ['placeholder' => 'Pick a department...', 'class' => 'form-control', 'id' => 'department_select', 'disabled' => 'disabled']) }}
      {{ Form::label('inputDepartment', 'Status')}}
      {{ Form::text('name', $value = NULL,['class' => 'form-control', 'id' => 'status_name']) }}
      {{ Form::label('inputSite', 'List Order')}}
              <!-- List with handle -->
      <div class="list-group" id="list-defaults">
        <div class="list-group" id="listWithHandle">
        </div>
      </div>

    </div>

    <button type="submit" class="btn btn-primary float-right">Update</button>
    {{ Form::hidden('id', $status->id) }}

    {{ Form::close() }}

    {{ Form::model($status,['action'=>['StatusController@destroy',$status], 'method' => 'delete']) }}

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

@push('jQueryScript')

    var i = 0;

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
        var button = '<button type="button" id="'+status.id+'" class="list-group-item sortable list-group-item-action">'+status.name + hiddenField +'<i class="fas fa-grip-lines float-right mt-1"></i></button>';
        return button;
      }
    };

    function setOrder(){
      var k = 0;
        $.each($('.list-order'), function(key, status){
          status.value = k;
          k++;
        });
     };

    // List with handle
    var sortable = $('#listWithHandle').sortable({
      handle: '.list-group-item',
      onUpdate: setOrder
    });

    $('#status_name').keyup(function(){
      $('#{{ $status->id }}').html($(this).val());

    });

    function loadList(){
      $.ajax({
               type:'POST',
               url:'/getStatuses',
               data:{
               'department_id':$('#department_select').val()
                },
               success:function(data) {
               $('#listWithHandle').html('');
                $.each(data, function(key, status){
                   var hiddenField = '<input name="status['+i+'][id]" value="'+status.id+'" type="hidden">';
                  hiddenField += '<input class="status-order list-order" name="status['+i+'][order]" value="'+status.list_order+'" type="hidden">';
                  hiddenField += '<input class="status-order" name="status['+i+'][name]" value="'+status.name+'" type="hidden">';
                  var button = buttonHtml(status, hiddenField);
                   $('#listWithHandle').append(button);
                   i++;
                });
                $('#{{ $status->id }}').addClass('active');
               }
            });
    };

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
                  options += '<option value="'+department.id+'">'+department.name+'</option>';
                });
                $('#department_select').html(options);
               }
            });
    });

    loadList();

    $('#department_select').change(function(){
      loadList();
    });

    


@endpush