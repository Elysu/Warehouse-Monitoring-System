<?php
  // include'config.php';
  // include'update-process.php';
  session_start();

  if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] == false){
    header("location: loginForm/login.php");
    exit();
  }

  //today's date
  date_default_timezone_set("Asia/Kuala_Lumpur");
  $dateToday = date("Y-m-d H:i:s");

  $i_name = $i_datetime_in = $i_datetime_out = $i_quantity = $i_from = $i_to = $i_status = $i_dp = $i_staff = "";

  if (isset($_POST["json"])) {
    $jsonValue = json_decode($_POST["json"], true);

    $i_name = $jsonValue["name"] != null ? $jsonValue["name"] : "";
    $i_datetime_in = $jsonValue["time-in"] != null ? $jsonValue["time-in"] : "";
    $i_datetime_out = $jsonValue["time-out"] != null ? $jsonValue["time-out"] : "";
    $i_quantity = $jsonValue["quantity"] != null ? $jsonValue["quantity"] : "";
    $i_from = $jsonValue["from"] != null ? $jsonValue["from"] : "";
    $i_to = $jsonValue["to"] != null ? $jsonValue["to"] : "";
    $i_dp = $jsonValue["dp"] != null ? $jsonValue["dp"] : "";
    $i_staff = $jsonValue["staff"] != null ? $jsonValue["staff"] : "";
  }

  if (isset($_SESSION['page'])) {
    if ($_SESSION['page'] == "/wms/main/insert-process.php" || $_SESSION['page'] == $_SERVER["REQUEST_URI"]) {

      if ($_SESSION['page'] == $_SERVER["REQUEST_URI"]) {
        unset($_SESSION['output']);
      }

      $i_name = isset($_SESSION["i_name"]) ? $_SESSION["i_name"] : "";
      $i_datetime_in = isset($_SESSION["i_datetime_in"]) ? $_SESSION["i_datetime_in"] : $dateToday;
      $i_quantity = isset($_SESSION["i_quantity"]) ? $_SESSION["i_quantity"] : "";
      $i_from = isset($_SESSION["i_from"]) ? $_SESSION["i_from"] : "";
      $i_to = isset($_SESSION["i_to"]) ? $_SESSION["i_to"] : "";
      $i_status = isset($_SESSION["i_status"]) ? $_SESSION["i_status"] : "";
      $i_dp = isset($_SESSION["i_dp"]) ? $_SESSION["i_dp"] : "";
      $i_staff = isset($_SESSION["i_staff"]) ? $_SESSION["i_staff"] : "";
    } else {
      $i_datetime_in = $dateToday;
    }
  }

  $page = $_SERVER["REQUEST_URI"];
  $_SESSION['page'] = $page;

  require_once("config.php");

  $isValid = '';

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

  //set into staff
  $sqlStaff = 'SELECT * FROM member';
  $resultStaff = $link->query($sqlStaff) or die($link->error);

  //set into slot
  $sqlSlot = 'SELECT * FROM slot';
  $resultSlot = $link->query($sqlSlot) or die($link->error);
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
  <script>
    console.log("datetime_in = " + "<?php echo $i_datetime_in; ?>");
    console.log("datetime_out = " + "<?php echo $i_datetime_out; ?>");
  </script>

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
          <li class="active ">
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
            <a class="navbar-brand">INSERT</a>
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
                <h5 class="title">Profile</h5>
              </div>
              <div class="card-body">
                <form method="post" action="insert-process.php">
                  <div class="row">
                    <div class="col-md-3 pr-md-1">
                      <div class="form-group">
                        <label>ID</label>
                        <input type="text" class="form-control" disabled="" value="" name="i_id">
                      </div>
                    </div>
                    <div class="col-md-6 px-md-1">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $i_name ?>" name="i_name" required>
                      </div>
                    </div>
                    <div class="col-md-3 pl-md-1">
                      <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" value="<?php echo $i_quantity ?>" min="1" name="i_quantity" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-md-1">
                      <div class="form-group">
                        <label>Date In</label>
                        <input type="date" id="dateIn" class="form-control" name="i_date_in" value="<?php echo getDateTime($i_datetime_in, 'date'); ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4 px-md-1">
                      <div class="form-group">
                        <label>Time In (Hours)</label>
                        <input type="number" onkeypress='return isNumberKey(event)' class="form-control time" min="0" max="23" value="<?php echo getDateTime($i_datetime_in, 'hour'); ?>" name="i_timeIn_h" placeholder="23" required>
                      </div>
                    </div>
                    <div class="col-md-4 pl-md-1">
                      <div class="form-group">
                        <label>Time In (Minutes)</label>
                        <input type="number" onkeypress='return isNumberKey(event)' class="form-control time" min="0" max="59" value="<?php echo getDateTime($i_datetime_in, 'min'); ?>" name="i_timeIn_m" placeholder="00" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4 pr-md-1">
                      <div class="form-group">
                        <label>Date Out</label>
                        <input type="date" id="dateOut" class="form-control" name="i_date_out" value="">
                      </div>
                    </div>
                    <div class="col-md-4 px-md-1">
                      <div class="form-group">
                        <label>Time Out (Hours)</label>
                        <input type="number" onkeypress='return isNumberKey(event)' id="timeOut_h" class="form-control time" min="0" max="23" value="" name="i_timeOut_h" placeholder="23">
                      </div>
                    </div>
                    <div class="col-md-4 pl-md-1">
                      <div class="form-group">
                        <label>Time Out (Minutes)</label>
                        <input type="number" onkeypress='return isNumberKey(event)' id="timeOut_m" class="form-control time" min="0" max="59" value="" name="i_timeOut_m" placeholder="00">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>From</label>
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $i_from ?>" name="i_from" required>
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>To</label>
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $i_to ?>" name="i_to">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4 pr-md-1">
                      <div class="form-group">
                        <label>Slot</label>
                        <select class="form-control" name="i_status" required>
                          <option value="" disabled selected hidden>Select A Status</option>
                          <option value="delivered">Delivered</option>
                          <?php
                            while ($row = $resultSlot->fetch_assoc()) {
                              if ($row["s_name"] == $i_status) {
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
                        <input type="text" pattern="\S(.*\S)?" title="Do not include white space at the beginning or ending" class="form-control" value="<?php echo $i_dp ?>" name="i_dp" required>
                      </div>
                    </div>
                    <div class="col-md-4 pl-md-1">
                      <div class="form-group">
                        <label>Staff</label>
                        <select class="form-control" name="i_staff" required>
                          <?php
                            while ($row = $resultStaff->fetch_assoc()) {
                              if ($i_staff != "") {
                                if ($row["m_username"] == $i_staff) {
                                  echo '<option value="'.$row["m_username"].'" selected>'.$row["m_username"].'</option>';
                                } else {
                                  echo '<option value="'.$row["m_username"].'">'.$row["m_username"].'</option>';
                                }
                              } else {
                                if ($row["m_username"] == $_SESSION["username"]) {
                                  echo '<option value="'.$row["m_username"].'" selected>'.$row["m_username"].'</option>';
                                } else {
                                  echo '<option value="'.$row["m_username"].'">'.$row["m_username"].'</option>';
                                }
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
                      <div class='form-group'>
                        <input class='form-control btnHover' type="submit" name="save" value="Insert">
                      </div>
                      <h4 id="insertOutput">
                        <?php
                          if (isset($_SESSION["isValid"])) {
                            $isValid = $_SESSION["isValid"];
                            unset($_SESSION["isValid"]);
                          }
                          if (isset($_SESSION['output'])) {
                            echo $_SESSION['output'];
                          }
                        ?>
                      </h4>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class='form-group'>
                        <a class="form-control btnHover text-center" href="insertQR.php">Insert by Scanning QR Code</a>
                      </div>
                    </div>
                  </div>
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

    today = yyyy+'-'+mm+'-'+dd;
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

    var isValid = '<?php echo $isValid; ?>';
    if (isValid == '1') {
      $("#insertOutput").addClass("text-success");
    } else {
      $("#insertOutput").addClass("text-warning");
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
  <?php mysqli_close($link); ?>
</body>
</html>