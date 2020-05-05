<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>Patient Notification System</title>

  <!-- Bootstrap core CSS -->
  {{ HTML::style('scripts/bootstrap/css/bootstrap.min.css') }}

  <!-- Custom styles for this template -->
  {{ HTML::style('css/simple-sidebar.css') }}

  <!-- Custom styles for DataTables -->
  {{ HTML::style('scripts/DataTables/datatables.css') }}

    <!-- Custom styles for date picker -->
  {{ HTML::style('css/bootstrap-datepicker3.min.css') }}

  <!-- Custom styles for FontAwesome -->
  <script src="https://kit.fontawesome.com/4dd735f7dd.js" crossorigin="anonymous"></script>
 
</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Menu </div>
      <div class="list-group list-group-flush">
        <a href="{{ action('HomeController@index') }}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-home-alt"></i> Home</a>
@guest
        <a href="{{ action('PatientController@create')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-user-plus"></i> Patient Sign up</a>
@else
        <a href="{{ action('SiteController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Sites</a>

        <a href="{{ action('DepartmentController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Departments</a>

        <a href="{{ action('StatusController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Statuses</a>

        <a href="{{ action('PatientController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Patients</a>

        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-light" id="logout">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
@endguest
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div class="container-fluid">  
    @if (session('message'))
      @if (session('message.type') === 'error')    
        <div class="alert alert-danger">
      @else
        <div class="alert alert-success">
      @endif
            {{ session('message.text') }}
        </div>
    @endif
        <div class="row">
          <span class="p-2" id="menu-toggle" >
            <i class="fad fa-angle-double-left fa-2x"></i>     
          </span>
          <h1>@yield('title')</h1>
        </div>
          @yield('content')
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  {{ HTML::script('scripts/jquery/jquery.min.js') }}
  {{ HTML::script('scripts/bootstrap/js/bootstrap.bundle.min.js') }}

  <!-- DataTables core JavaScript -->
  {{ HTML::script('scripts/DataTables/datatables.min.js') }}

    <!-- Input mask core JavaScript -->
  {{ HTML::script('scripts/jquery/jquery.inputmask.min.js') }}

    <!-- Datepicker JavaScript -->
  {{ HTML::script('scripts/datepicker/bootstrap-datepicker.min.js') }}

    <!-- Datepicker JavaScript -->
  {{ HTML::script('scripts/sortable/Sortable.min.js') }}
  {{ HTML::script('scripts/sortable/jquery-sortable.js') }}

  <!-- Menu Toggle Script -->
  <script>
  $(document).ready(function() {
    $('#logout').click(function(e){
      e.preventDefault();
      $('#logout-form').submit();
    });

    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass(function(){
          if($("#wrapper").hasClass("toggled")){
            $("#menu-toggle").html('<i class="fad fa-angle-double-left fa-2x"></i>');
          }
          else{
            $("#menu-toggle").html('<i class="fad fa-angle-double-right fa-2x"></i>');
          }
          return "toggled";
      });
    });

@hasSection('datatable')

    var table = $('#patient-table').DataTable({
        dom: 'frt<"bottom"p>',
        responsive: true,

        @stack('datatableOptions')

    });

    var addButtonLink = '#';

    $('tbody').on('click', 'td', function(e){
      var colIndex = table.cell( this ).index().columnVisible;
      var data = table.row(this).data();
      if($('#patient-table').hasClass('collapsed')){
        if(colIndex>0){
        window.location.href = data.action;
        }
      }
      else{
        window.location.href = data.action;
      }
      
    });

    @stack('jQueryScriptDatatable')

@endif

    @stack('jQueryScript')

    
  });

  </script>

</body>

</html>
