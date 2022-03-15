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

  $jsonValue = "";
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
  
    <style>
        canvas {background-color: lightblue}
        #passData { display: none }
        #captureSnapshotButton { display: none }
        #attemptDecodeButton { display: none }
        #startAutoCaptureButton { display: none }
        #stopAutoCaptureButton { display: none }
        #stopCameraButton { display: none }
        #player { display: none }

        #canvas-container {
          width: 100%;
          text-align:center;
        }
    </style>

    <script type="text/javascript" src="../jsqrcode/src/grid.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/version.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/detector.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/formatinf.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/errorlevel.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/bitmat.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/datablock.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/bmparser.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/datamask.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/rsdecoder.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/gf256poly.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/gf256.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/decoder.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/qrcode.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/findpat.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/alignpat.js"></script>
    <script type="text/javascript" src="../jsqrcode/src/databr.js"></script>
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
              <p>Table List</p>
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
            <a class="navbar-brand" href="javascript:void(0)">Insert QR Code</a>
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header mb-5">
                <h3 class="card-title">SCAN QR CODE</h3>
              </div>
              <div class="card-body">

                <video id="player" controls autoplay></video>
                
                <div id="canvas-container">
                  <canvas class="text-center" id="qr-canvas" width=800 height=600></canvas>
                </div>
                
                <div>
                    <button id="captureSnapshotButton">Capture Snapshot</button>
                    <button id="attemptDecodeButton" disabled>Attempt Decode</button>
                    <button id="startAutoCaptureButton">Start Auto-Capture</button>
                    <button id="stopAutoCaptureButton">Stop Auto-Capture</button>
                    <button id="stopCameraButton">Stop Camera</button>
                </div>

                <form action="insert.php" method="post">
                    <input value="" name="json" type="hidden" id="jsonString">
                    <button type="submit" id="passData" name="passData"></button>
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
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
  </script>

                <script>
                    window.onload = function() {
                      autoCapture();
                    };

                    const canvas = document.getElementById('qr-canvas');
                    const context = canvas.getContext('2d');
                    let autoCaptureStatus = false;
                    let decodeFailures = 0;
        
                    const constraints = {
                        video: {
                            width: 320,
                            height: 240
                        }
                    };
                    
                    showDefaultCanvas();
        
                    // Attach the video stream to the video element and autoplay.
                    navigator.mediaDevices.getUserMedia(constraints)
                            .then((stream) => {
                                player.srcObject = stream;
                            });
            
                    captureSnapshotButton.addEventListener('click', () => {
                        // Draw the video frame to the canvas.
                        attemptDecodeButton.disabled = false;
                        context.drawImage(player, 0, 0, canvas.width, canvas.height);
                    });
        
                    stopCameraButton.addEventListener('click', () => {
                        // Stop video capture.
                        player.srcObject.getVideoTracks().forEach(track => track.stop());
                        disableButtons();
                        autoCapture = false;
                        output.innerHTML = '<h2 style="color:#F00">Reload page to restart camera.</h2>';
                        showDefaultCanvas();
                    });
        
                    attemptDecodeButton.addEventListener('click', () => {
                        // Decode QR Code
                        try {
                            decodedValue = qrcode.decode();
                            console.log(decodedValue);
                            autoCaptureStatus = false;
                            passData(decodedValue);
                        } catch (err) {
                            updateOutputValue("[Failed to decode (" + ++decodeFailures + ")]");
                            if (err !== "Couldn't find enough finder patterns (found 0)") {
                                throw err;
                            }
                        }
                    });
        
                    startAutoCaptureButton.addEventListener('click', () => {
                        // Start taking snapshots to canvas
                        autoCaptureStatus = true;
                        decodeFailures = 0;
                        autoCapture();
                    });
        
                    stopAutoCaptureButton.addEventListener('click', () => {
                        // Stop taking snapshots to canvas
                        autoCaptureStatus = false;
                    });
        
        
                    function autoCapture() {
                        autoCaptureStatus = true;
                        decodeFailures = 0;

                        if (autoCaptureStatus) {
                            captureSnapshotButton.click();
                            attemptDecodeButton.click();
                            setTimeout(autoCapture, 100);
                        }
                    }
        
                    function updateOutputValue(val) {
                        output.innerHTML = "<h2>Decoded value: " + val + "</h2>";
                    }
        
                    function disableButtons() {
                        buttons = document.getElementsByTagName("button");
                        Array.from(buttons).map(button => button.disabled = true);
                    }
                    
                    function showDefaultCanvas() {
                        context.clearRect(0, 0, canvas.width, canvas.height);        
                        context.font = "30px Arial";
                        context.fillText("Connect your camera", 50, 130);
                    }

                    function passData (result) {
                        $("#jsonString").val(result);
                        $("#passData").click();
                    }
                </script>
</body>

</html>