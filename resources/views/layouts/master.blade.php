<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Patient Notification System</title>

  <!-- Bootstrap core CSS -->
  <link href="scripts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

  <!-- Custom styles for DataTables -->
  <link rel="stylesheet" type="text/css" href="scripts/DataTables/datatables.css"/>

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
        <a href="#" class="list-group-item list-group-item-action bg-light"><i class="fad fa-edit"></i> Manage Sites</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div class="container-fluid">  
        <div class="row">
          <span class="p-2" id="menu-toggle" >
            <i class="fad fa-angle-double-left fa-2x"></i>     
          </span>
          <h1 class="mx-auto pt-3">@yield('title')</h1>
        </div>
          @yield('content')
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="scripts/jquery/jquery.min.js"></script>
  <script src="scripts/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables core JavaScript -->
  <script type="text/javascript" src="scripts/DataTables/datatables.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
  $(document).ready(function() {
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass(function(){
          if($("#wrapper").hasClass("toggled")){
            console.log("was closed");
            $("#menu-toggle").html('<i class="fad fa-angle-double-left fa-2x"></i>');
          }
          else{
            $("#menu-toggle").html('<i class="fad fa-angle-double-right fa-2x"></i>');
          }
          return "toggled";
      });
    });

      $('#patient-table').DataTable({
          dom: 'frt<"bottom"p>',
          responsive: true,
          processing: true,
          serverSide: true,
          initComplete: function(settings, json) {
    $('.pagination').append('<button type="button" class="btn btn-primary">add</button>');;
  },
          @stack('datatableOptions')

  
      });

      @stack('jQueryScript')
  });
  </script>

</body>

</html>
