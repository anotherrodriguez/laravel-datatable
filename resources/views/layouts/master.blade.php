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

  <!-- Custom styles for FontAwesome -->
  <script src="https://kit.fontawesome.com/4dd735f7dd.js" crossorigin="anonymous"></script>
 
</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Menu </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light"><i class="fad fa-home-alt"></i> Home</a>
        <a href="{{ action('SiteController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Sites</a>
        <a href="{{ action('DepartmentController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Departments</a>
        <a href="{{ action('StatusController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Statuses</a>
        <a href="{{ action('PatientController@index')}}" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Patients</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
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

  <!-- Menu Toggle Script -->
  <script>
  $(document).ready(function() {
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

    $('#patient-table').DataTable({
        order: [[ 1, 'asc' ]],
        dom: 'frt<"bottom"p>',
        responsive: true,
        processing: true,
        serverSide: true,

        @stack('datatableOptions')

    });

    var addButtonLink = '#';

    @stack('jQueryScriptDatatable')

    $('.bottom').append('<a href="'+ addButtonLink +'"><button type="button" class="btn btn-primary">add</button></a>');

@endif

    @stack('jQueryScript')

    
  });

  </script>

</body>

</html>
