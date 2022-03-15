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
  
  //get ID from tables.php or itemEdit-process.php
  if (isset($_POST["itemId"])) {
    $id = $_POST["itemId"];
  } else {
    $id = $_SESSION["i_id"];
  }

  //check if ID is in database
  $sqlCheckId = 'SELECT * FROM item WHERE i_id = '.$id;
  $resultId = $link->query($sqlCheckId) or die($link->error);
  $count = mysqli_num_rows($resultId);

  if ($count < 1) {
    header("location: tables.php");
  }

  //get date and time
  function getDateTime($datetime, $arg) {
    if ($datetime == "0000-00-00 00:00:00" || $datetime == '') {
      return '';
    } else {
      $dt = new DateTime($datetime);
      $date = $dt->format('Y-m-d');
      $timeH = $dt->format('H');
      $timeM = $dt->format('i');
      
      switch ($arg) {
        case 'date':
          return $date;
          break;
        case 'hour':
          return $timeH;
          break;
        case 'min':
          return $timeM;
          break;
      }
    }
  }

  //put into input fields
  $name = '';
  $quantity = '';
  $datetimeIn = '';
  $datetimeOut = '';
  $from = '';
  $to = '';
  $status = '';
  $dp = '';
  $staff = '';

  $dateIn = '';
  $dateOut = '';
  $timeIn = '';
  $timeOut = '';
  
  $sql = 'SELECT * FROM item WHERE i_id = '.$id;
  $result = $link->query($sql) or die($link->error);

  while($row = $result->fetch_assoc()) {
      $name = $row["i_name"];
      $quantity = $row["i_quantity"];
      $datetimeIn = $row["i_time_in"];
    
      if ($row["i_time_out"] === null) {
        $datetimeOut = '';
      } else {
        $datetimeOut = $row["i_time_out"];
      }

      $from = $row["i_from"];
      $to = $row["i_to"];
      $status = $row["i_status"];
      $dp = $row["i_dp"];
      $staff = $row["i_staff"];
  }

  //put into dropdownlist
  $sqlSlot = 'SELECT * FROM slot';
  $resultSlot = $link->query($sqlSlot) or die($link->error);

  //put into staff
  $sqlStaff = 'SELECT * FROM member';
  $resultStaff = $link->query($sqlStaff) or die($link->error);
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
  <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
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
            <a class="navbar-brand">EDIT ITEM</a>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Edit Item</h5>
              </div>
              <div class="card-body">
                <form method="post" id="itemEdit_form" action="itemEdit-process.php">
                  <div class="row">
                    <div class="col-md-3 pr-md-1">
                      <div class="form-group">
                        <label>ID</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $id; ?>" name="i_id">
                      </div>
                    </div>
                    <div class="col-md-6 px-md-1">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $name; ?>" name="i_name" required>
                      </div>
                    </div>
                    <div class="col-md-3 pl-md-1">
                      <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" value="<?php echo $quantity; ?>" name="i_quantity" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4 pr-md-1">
                      <div class="form-group">
                        <label>Date In</label>
                        <input type="date" id="dateIn" class="form-control" name="i_date_in" value="<?php echo getDateTime($datetimeIn, 'date'); ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4 px-md-1">
                      <div class="form-group">
                        <label>Time In (Hours)</label>
                        <input type="number" onkeypress="return isNumberKey(event)" class="form-control time" min="0" max="23" value="<?php echo getDateTime($datetimeIn, 'hour'); ?>" name="i_timeIn_h" placeholder="23" required>
                      </div>
                    </div>
                    <div class="col-md-4 pl-md-1">
                      <div class="form-group">
                        <label>Time In (Minutes)</label>
                        <input type="number" onkeypress="return isNumberKey(event)" class="form-control time" min="0" max="59" value="<?php echo getDateTime($datetimeIn, 'min'); ?>" name="i_timeIn_m" placeholder="00" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4 pr-md-1">
                      <div class="form-group">
                        <label>Date Out</label>
                        <input type="date" id="dateOut" class="form-control" name="i_date_out" value="<?php echo getDateTime($datetimeOut, 'date'); ?>">
                      </div>
                    </div>
                    <div class="col-md-4 px-md-1">
                      <div class="form-group">
                        <label>Time Out (Hours)</label>
                        <input type="number" onkeypress="return isNumberKey(event)" id="timeOut_h" class="form-control time" min="0" max="23" value="<?php echo getDateTime($datetimeOut, 'hour'); ?>" name="i_timeOut_h" placeholder="23">
                      </div>
                    </div>
                    <div class="col-md-4 pl-md-1">
                      <div class="form-group">
                        <label>Time Out (Minutes)</label>
                        <input type="number" onkeypress="return isNumberKey(event)" id="timeOut_m" class="form-control time" min="0" max="59" value="<?php echo getDateTime($datetimeOut, 'min'); ?>" name="i_timeOut_m" placeholder="00">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>From</label>
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $from; ?>" name="i_from" required>
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>To</label>
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $to; ?>" name="i_to">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4 pr-md-1">
                      <div class="form-group">
                        <label>Slot</label>
                        <select name="i_status" class="form-control" required>
                          <?php
                            if ($status == 'delivered') {
                              echo '<option value="'.$status.'">Delivered</option>';
                            } else {
                              echo '<option value="delivered">Delivered</option>';
                            }
                          
                            while ($row = $resultSlot->fetch_assoc()) {
                              if ($status == $row["s_name"]) {
                                echo '<option value="'.$row["s_name"].'" selected>'.$row["s_name"].'</option>';
                              } else {
                                echo '<option value="'.$row["s_name"].'">'.$row["s_name"].'</option>';
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 px-md-1">
                      <div class="form-group">
                        <label>Delivery Person</label>
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $dp; ?>" name="i_dp" required>
                      </div>
                    </div>
                    <div class="col-md-4 pl-md-1">
                      <div class="form-group">
                        <label>Staff</label>
                        <select name="i_staff" class="form-control" required>
                            <?php
                              while ($row = $resultStaff->fetch_assoc()) {
                                if ($staff == $row["m_username"]) {
                                  echo '<option value="'.$row["m_username"].'" selected>'.$row["m_username"].'</option>';
                                } else {
                                  echo '<option value="'.$row["m_username"].'">'.$row["m_username"].'</option>';
                                }
                              }
                            ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <input class="form-control btnHover" type="submit" name="save" value="Save">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <input class="form-control btnHover" type="submit" name="delete" value="Delete">
                      </div>
                    </div>
                  </div>
                </form>
                <form action="tables.php">
                  <button class="form-control btnHover" type="submit">Back to All Items</button>
                </form>
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
  <script>
    // document.querySelectorAll('.time')
    // .forEach(e => e.oninput = () => {
    //   // Always 2 digits
    //   if (e.value.length >= 2) e.value = e.value.slice(0, 2);
    //   // 0 on the left (doesn't work on FF)
    //   if (e.value.length === 1) e.value = '0' + e.value;
    //   // Avoiding letters on FF
    //   if (!e.value) e.value = '00';
    // });

    //set max date on Date In
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
      dd='0' + dd;
    } 
    if(mm<10){
      mm='0' + mm;
    } 

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("dateIn").setAttribute("max", today);

    //set min date for Date Out
    var dateIn = $("#dateIn").val();
    document.getElementById("dateOut").setAttribute("min", dateIn);

    $("#dateIn").change(function(){
      var dateIn = $("#dateIn").val();
      document.getElementById("dateOut").setAttribute("min", dateIn);
    });

    //accept only numbers on time field
    //which returns unicode of a key
    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : evt.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
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

<?php mysqli_close($link); ?>

</html>