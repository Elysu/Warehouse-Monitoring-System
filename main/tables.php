<?php
  session_start();

  if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] == false){
    header("location: loginForm/login.php");
    exit();
  }

  if (isset($_SESSION['output'])) {
    unset($_SESSION['output']);
  }

  $page = $_SERVER["REQUEST_URI"];
  $_SESSION['page'] = $page;

  require_once("config.php");

  $output = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    WMS
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <p class="simple-text logo-mini">
          
          </p>
          <a class="simple-text logo-normal">
            <?php echo $_SESSION["username"]; ?>
          </a>
        </div>
        <ul class="nav">
          <li>
            <a href="./dashboard.php">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="./user.php">
              <i class="tim-icons icon-single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li class="active ">
            <a href="./tables.php">
              <i class="tim-icons icon-puzzle-10"></i>
              <p>Items</p>
            </a>
          </li>
          <li>
            <a href="./insert.php">
              <i class="tim-icons icon-align-center"></i>
              <p>insert</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)">All Items</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="search-bar input-group">
                <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split" ></i>
                  <span class="d-lg-none d-md-block">Search</span>
                </button>
              </li>
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="../assets/img/anime3.png" alt="Profile Photo">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    Log out
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link"><a href="user.php" class="nav-item dropdown-item">Profile</a></li>
                  <li class="dropdown-divider"></li>
                  <li class="nav-link"><a href="loginForm/logout.php" class="nav-item dropdown-item">Log out</a></li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <form action="tables.php" method="post">
                <input type="text" class="form-control" name="searchField" id="inlineFormInputGroup" placeholder="SEARCH ITEM">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="tim-icons icon-simple-remove"></i>
                </button> -->
                <button class="close" id="startSearch" name="searchButton" type="submit">
                  <i class="tim-icons icon-zoom-split"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h4 class="card-title">ITEMS</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table tablesorter " id="Table_List">
                    <thead class="text-primary cursorPointer">
                      <tr>
                        <th onclick="sortTable(0)" >ID</th>
                        <th onclick="sortTable(1)" >Name</th>
                        <th onclick="sortTable(2)" >Quantity</th>
                        <th onclick="sortTable(3)" >Time In</th>
                        <th onclick="sortTable(4)" >Time Out</th>
                        <th onclick="sortTable(5)" >From</th>
                        <th onclick="sortTable(6)" >To</th>
                        <th onclick="sortTable(7)" >Status</th>
                        <th onclick="sortTable(8)" >Delivery Person</th>
                        <th onclick="sortTable(9)" >Staff In-Charge</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      // if user click search
                      if (isset($_POST['searchField'])) {
                        $searchq = $_POST['searchField'];
                    
                        $searchSQL = "SELECT * FROM item WHERE i_name LIKE '%$searchq%' OR i_id LIKE '%$searchq%' OR i_status LIKE '%$searchq%'";
                        $resultSearch = $link->query($searchSQL);
                        $countSearch = mysqli_num_rows($resultSearch);
                    
                        if ($countSearch > 0) {
                          while($row = $resultSearch->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row["i_id"]."</td>";
                            echo "<td>".$row["i_name"]."</td>";
                            echo "<td>".$row["i_quantity"]."</td>";
                            echo "<td>".$row["i_time_in"]."</td>";
                            echo "<td>".$row["i_time_out"]."</td>";
                            echo "<td>".$row["i_from"]."</td>";
                            echo "<td>".$row["i_to"]."</td>";
                            echo "<td>".$row["i_status"]."</td>";
                            echo "<td>".$row["i_dp"]."</td>";
                            echo "<td>".$row["i_staff"]."</td>";
                            echo "<td>";
                              echo "<form action='itemEdit.php' method='post'>
                                      <input type='hidden' name='itemId' value='".$row["i_id"]."'>
                                      <button class='form-control btnHover' type='submit' name='submit'>EDIT</button>
                                    </form>";
                            echo "</td>";
                            echo "</tr>";
                          }
                        } else {
                          $output = "No search results!";

                          echo "<tr>";
                            echo "<td colspan=10>".$output."</td>";
                          echo "</tr>";
                        }
                      
                      //default table
                      } else {

                        $sql = "SELECT * FROM item";
                        $result = $link->query($sql);

                        while($row = $result->fetch_assoc()) {
                          echo "<tr>";
                            echo "<td>".$row["i_id"]."</td>";
                            echo "<td>".$row["i_name"]."</td>";
                            echo "<td>".$row["i_quantity"]."</td>";
                            echo "<td>".$row["i_time_in"]."</td>";
                            echo "<td>".$row["i_time_out"]."</td>";
                            echo "<td>".$row["i_from"]."</td>";
                            echo "<td>".$row["i_to"]."</td>";
                            echo "<td>".$row["i_status"]."</td>";
                            echo "<td>".$row["i_dp"]."</td>";
                            echo "<td>".$row["i_staff"]."</td>";
                            echo "<td>";
                              echo "<form action='itemEdit.php' method='post'>
                                      <input type='hidden' name='itemId' value='".$row["i_id"]."'>
                                      <button class='form-control btnHover' type='submit' name='submit'>EDIT</button>
                                    </form>";
                            echo "</td>";
                          echo "</tr>";
                        }

                      }

                      mysqli_close($link);
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        
      </footer>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
      
    function sortTable(n) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("Table_List");
      switching = true;
      //Set the sorting direction to ascending:
      dir = "asc"; 
      /*Make a loop that will continue until
      no switching has been done:*/
      while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
          //start by saying there should be no switching:
          shouldSwitch = false;
          /*Get the two elements you want to compare,
          one from current row and one from the next:*/
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          /*check if the two rows should switch place,
          based on the direction, asc or desc:*/
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /*If a switch has been marked, make the switch
          and mark that a switch has been done:*/
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          //Each time a switch is done, increase this count by 1:
          switchcount ++;      
        } else {
          /*If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again.*/
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }

  </script>
</body>

</html>