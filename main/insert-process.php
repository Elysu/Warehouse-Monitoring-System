<?php
    session_start();
    $page = $_SERVER["REQUEST_URI"];
    $_SESSION['page'] = $page;

    if (isset($_SESSION['output'])) {
      unset($_SESSION['output']);
    }

    if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] == false){
      header("location: loginForm/login.php");
      exit();
    }

    require_once('config.php');

    
    $output = '';
    $isValid = true;
    $dbError = false;

    if (isset($_POST['save'])) {
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
              $output = "'To' field is required if Date and TIme was set!";
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
            if($row["s_name"] == $_POST["i_status"]) {
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
            //insert item
            if ($i_date_out == '') {
                $sqlInsert = 'INSERT INTO item (i_name, i_time_in, i_time_out, i_quantity, i_from, i_to, i_status, i_dp, i_staff)
                            VALUE ("'.$i_name.'", "'.$i_datetime_in.'", null, '.$i_quantity.', "'.$i_from.'", "", "'.$i_status.'", "'.$i_dp.'", "'.$i_staff.'")';
            } else {
                $sqlInsert = 'INSERT INTO item (i_name, i_time_in, i_time_out, i_quantity, i_from, i_to, i_status, i_dp, i_staff)
                            VALUE ("'.$i_name.'", "'.$i_datetime_in.'", "'.$i_datetime_out.'", '.$i_quantity.', "'.$i_from.'", "'.$i_to.'", "'.$i_status.'", "'.$i_dp.'", "'.$i_staff.'")';
            }

            $resultInsertItem = $link->query($sqlInsert);

            //update slot
            if ($resultInsertItem) {
                //select item
                $sqlItem = 'SELECT LAST_INSERT_ID() as id FROM item';
                $resultLastId = $link->query($sqlItem);
                $id = $resultLastId->fetch_assoc();

                //if succeeded, update slot
                $sqlUpdateSlot = 'UPDATE slot SET s_i_id = '.$id["id"].',
                                                s_i_name = "'.$i_name.'",
                                                s_i_time = "'.$i_datetime_in.'",
                                                s_i_quantity = '.$i_quantity.',
                                                s_status = 1
                                        WHERE s_name = "'.$i_status.'"';

                $resultUpdateSlot = $link->query($sqlUpdateSlot);

                if ($resultUpdateSlot) {
                    $output = 'Item has been inserted.';
                } else {
                    $output = 'Item has been inserted but encountered an error when updating slots.';
                    $output .= $link->error;
                    $dbError = true;
                }
            } else {
                $output = 'Item Insert Error!';
                $output .= $link->error;
                $dbError = true;
            }
        }

        if ($dbError || $isValid == false) {
          $_SESSION["i_name"] = $i_name;
          $_SESSION["i_datetime_in"] = $i_datetime_in;
          $_SESSION["i_quantity"] = $i_quantity;
          $_SESSION["i_from"] = $i_from;
          $_SESSION["i_to"] = $i_to;
          $_SESSION["i_status"] = $i_status;
          $_SESSION["i_dp"] = $i_dp;
          $_SESSION["i_staff"] = $i_staff;
        } else {
          unset($_SESSION["i_name"]);
          unset($_SESSION["i_datetime_in"]);
          unset($_SESSION["i_datetime_out"]);
          unset($_SESSION["i_quantity"]);
          unset($_SESSION["i_from"]);
          unset($_SESSION["i_to"]);
          unset($_SESSION["i_status"]);
          unset($_SESSION["i_dp"]);
          unset($_SESSION["i_staff"]);
        }
    }

    if ($output == '') {
      if (isset($_SESSION['output'])) {
        unset($_SESSION['output']);
      }
    } else {
      $_SESSION["isValid"] = $isValid;
      $_SESSION['output'] = $output;
    }

    header("location: insert.php");

    mysqli_close($link);
?>