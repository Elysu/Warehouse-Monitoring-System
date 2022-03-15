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

    require_once('config.php');

    $output = '';
    $id = '';
    $delete = 0;
    $isValid = true;

    if (isset($_POST["i_id"])) {
      $id = $_POST["i_id"];
    } else {
      $output = "Item ID is not set!";
      $isValid = false;
    }

    if (isset($_POST["delNo"])) {
      $_SESSION["i_id"] = $_POST["i_id"];
      header("location: itemEdit.php");
    }

    if (isset($_POST["delYes"])) {
      $delete = 2;
      $sqlDelete = 'DELETE FROM item WHERE i_id = '.$id;

      $result = $link->query($sqlDelete);

      if ($result) {
        //suceeded
        $resultResetSlot = slotReset($id, $link);

        if ($resultResetSlot) {
          $output = "Item has been removed.";
        } else {
          $output = "Item has been removed but slot reset error.";
        }
      } else {
        //failed
        $output = "Item remove error: ".$link->error;
      }
    }

    if(isset($_POST['save']))
    {
        //validation
        $i_datetime_out = '';

        if ($_POST["i_date_out"] == '') {
          $i_date_out = '';

          if ($_POST["i_timeOut_h"] != '' || $_POST["i_timeOut_m"] != '') {
            $output = "Date Out is required if Time Out was set!";
            $isValid = false;
          }
        } else {
          $hour = '';
          $min = '';

          if ($_POST["i_timeOut_h"] == '' || $_POST["i_timeOut_m"] == '') {
            $output = "Both Time Out hour and minutes are required if Date Out was set!";
            $isValid = false;
          } else {
            if ($_POST["i_to"] == '') {
              $output = "'To' field is require if Date and TIme was set!";
              $isValid = false;
            } else {
              $hour = $_POST["i_timeOut_h"];
              $min = $_POST["i_timeOut_m"];
              $i_date_out = $_POST["i_date_out"]." ".$hour.":".$min;
              $i_datetime_out = date('Y-m-d H:i:s', strtotime($i_date_out));
            }
          }
        }

        if ($_POST["i_to"] != '') {
          if ($_POST["i_date_out"] == '') {
            $output = "Please set Date Out and Time Out if 'To' was specified!";
            $isValid = false;
          } else {
            if ($_POST["i_status"] != 'delivered') {
              $output = "Please set Slot to 'delivered' if 'To' was specified!";
              $isValid = false;
            }
          }
        }

        if ($_POST["i_status"] == 'delivered') {
          if ($_POST["i_to"] == '') {
            $output = '"To" field is required if Slot is set to delivered!';
            $isValid = false;
          }
        } else {
          $sqlCheckStatus = 'SELECT * FROM slot WHERE s_status = 1';
          $result = $link->query($sqlCheckStatus);

          while ($row = $result->fetch_assoc()) {
            if($row["s_name"] == $_POST["i_status"] && $row['s_i_id'] != $id) {
              $output = 'The slot '.$_POST["i_status"].' was occupied. Please select another slot.';
              $isValid = false;
              break;
            }
          }
        }

        //set all var
        $i_date_in = $_POST["i_date_in"]." ".$_POST["i_timeIn_h"].":".$_POST["i_timeIn_m"];
        $i_name = $_POST['i_name'];
        $i_datetime_in = date('Y-m-d H:i:s', strtotime($i_date_in));
        $i_quantity = $_POST['i_quantity'];
        $i_from = $_POST['i_from'];
        $i_to = $_POST['i_to'];
        $i_status = $_POST['i_status'];
        $i_dp = $_POST['i_dp'];
        $i_staff = $_POST['i_staff'];

        if ($isValid) {
          //update item
          $resultUpdateItem = updateItem($i_name, $i_datetime_in, $i_date_out, $i_datetime_out, $i_quantity, $i_from, $i_to, $i_status, $i_dp, $i_staff, $id, $link);

          //update slot
          $resultUpdateSlot = updateSlot($id, $link, $i_name, $i_datetime_in, $i_quantity, $i_status);
        
          //check error or success
          if ($resultUpdateSlot != true) {
            $output = $resultUpdateSlot;
          } else if ($resultUpdateItem && $resultUpdateSlot) {
            //suceeded
            $output = "Item has been updated.";
          } else {
            //failed
            if ($resultUpdateItem == false) {
              $output .= "Item update error\n";
            }

            if ($resultUpdateSlot == false) {
              $output .= "Slot update error.\n";
            }

            $output .= $link->error;
          }
        }
    }

    if (isset($_POST["delete"])) {
      $delete = 1;
      $output = '<div class="text-center">Are you sure you want to remove this item from the list?
                <br>
                <br>
                <form action="itemEdit-process.php" method="post">
                  <input type="hidden" name="i_id" value="'.$id.'">
                  <div class="row">
                    <div class="col-md-5 pr-md-1 col-centered">
                      <div class="form-group">
                        <input class="form-control btnHover" type="submit" name="delYes" value="Yes">
                      </div>
                    </div>
                    <div class="col-md-5 pl-md-1 col-centered">
                      <div class="form-group">
                        <input class="form-control btnHover" type="submit" name="delNo" value="No">
                      </div>
                    </div>
                  </div>
                </form></div>';
    }
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
          <li>
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
            <a class="navbar-brand" href="javascript:void(0)">ITEM</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
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
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <h2 id="outputErr"><?php echo $output; ?></h2>
  
        <br>
        <br>
        <br>
        <br>

        <form method='post' action='itemEdit.php'>
          <input type="hidden" name="itemId" value="<?php echo $id; ?>">
          <div class="row">
            <div class="col-md-3 pr-md-1">
              <div class="form-group">
                <?php
                  if ($delete != 2) {
                    echo '<button class="form-control btnHover" type="submit">Back to Edit Item</button>';
                  }
                ?>
              </div>
            </div>
          </div>
        </form>

        <div class="row">
          <div class="col-md-3 pr-md-1">
            <div class="form-group text-center">
              <a class="form-control btnHover text-center" href="tables.php">Back to Items</a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 pr-md-1">
            <div class="form-group text-center">
              <a class="form-control btnHover text-center" href="dashboard.php">Home</a>
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

    var isValid = '<?php echo $isValid; ?>';
    if (isValid == '1') {
      $("#outputErr").addClass("text-success");
    } else {
      $("#outputErr").addClass("text-warning");
    }

    var del = '<?php echo $delete; ?>';
    if (del == 1) {
      $("#outputErr").removeClass("text-success");
      $("#outputErr").addClass("text-danger");
    }
  </script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
  </script>
</body>
</html>
<?php
  function updateItem($i_name, $i_datetime_in, $i_date_out, $i_datetime_out, $i_quantity, $i_from, $i_to, $i_status, $i_dp, $i_staff, $id, $conn) {
    if ($i_date_out == '') {
      $sqlUpdate = 'UPDATE item SET i_name = "'.$i_name.'",
                            i_time_in = "'.$i_datetime_in.'",
                            i_time_out = null,
                            i_quantity = '.$i_quantity.',
                            i_from = "'.$i_from.'",
                            i_to = "'.$i_to.'",
                            i_status = "'.$i_status.'",
                            i_dp = "'.$i_dp.'",
                            i_staff = "'.$i_staff.'"
                    WHERE i_id = '.$id;
    } else {
      $sqlUpdate = 'UPDATE item SET i_name = "'.$i_name.'",
                              i_time_in = "'.$i_datetime_in.'",
                              i_time_out = "'.$i_datetime_out.'",
                              i_quantity = '.$i_quantity.',
                              i_from = "'.$i_from.'",
                              i_to = "'.$i_to.'",
                              i_status = "'.$i_status.'",
                              i_dp = "'.$i_dp.'",
                              i_staff = "'.$i_staff.'"
                  WHERE i_id = '.$id;
    }

    return $conn->query($sqlUpdate);
  }

  function updateSlot($id, $conn, $i_name, $i_datetime_in, $i_quantity, $i_status) {
    $sqlSlot = 'SELECT * FROM slot WHERE s_i_id = '.$id;
    $resultSlot = $conn->query($sqlSlot);
    $slotCount = mysqli_num_rows($resultSlot);
    $slotError = 0;
    $error = '';

    if ($slotCount > 0) {
      $resultResetSlot = slotReset($id, $conn);

      if ($resultResetSlot == false) {
        $slotError = 1;
        $error = $conn->error;
      }
    }

    if ($slotError != 1) {
      $sqlUpdateSlot = 'UPDATE slot SET s_i_id = '.$id.',
                                    s_i_name = "'.$i_name.'",
                                    s_i_time = "'.$i_datetime_in.'",
                                    s_i_quantity = '.$i_quantity.',
                                    s_status = 1
                            WHERE s_name = "'.$i_status.'"';

      return $conn->query($sqlUpdateSlot);
    } else {
      return $error;
    }
  }

  function slotReset($id, $conn) {
    $sqlResetSlot = 'UPDATE slot SET s_i_id = null,
                                        s_i_name = "",
                                        s_i_time = null,
                                        s_i_quantity = 0,
                                        s_status = 0
                                WHERE s_i_id = "'.$id.'"';

    return $conn->query($sqlResetSlot);
  }

  mysqli_close($link);
?>