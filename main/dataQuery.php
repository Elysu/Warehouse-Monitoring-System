<?php
    if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] == false){
      header("location: loginForm/login.php");
      exit();
    }

    require_once("config.php");

    // sql slot
    $sqlOccupied = "SELECT * FROM slot WHERE s_status = 1";
    $sqlEmpty = "SELECT * FROM slot WHERE s_status = 0";

    $resultOccupied = mysqli_query($link, $sqlOccupied);
    $resultEmpty = mysqli_query($link, $sqlEmpty);

    $countOccupied = mysqli_num_rows($resultOccupied);
    $countEmpty = mysqli_num_rows($resultEmpty);

    // sql item
    $sqlItem = "SELECT i_name, i_quantity FROM item WHERE i_status != 'delivered' AND i_status <> '' AND i_status IS NOT NULL ORDER BY i_quantity DESC";
    $resultItem = $link->query($sqlItem);
    $countItem = mysqli_num_rows($resultItem);

    $items = array();

    while($row = $resultItem->fetch_assoc()) {
        array_push($items, array("name" => $row["i_name"], "quantity" => $row["i_quantity"]));
    }

    // sql date out
    $sqlDateOut = "SELECT MONTH(i_time_out) as month FROM item WHERE i_status = 'delivered' AND YEAR(i_time_out) = YEAR(CURDATE())";
    $resultOut = $link->query($sqlDateOut);

    $itemsOut = array(
        "1"=>array( 
            "quantity"=>0
        ),
        "2"=>array( 
            "quantity"=>0
        ),
        "3"=>array( 
            "quantity"=>0
        ),
        "4"=>array( 
            "quantity"=>0
        ),
        "5"=>array( 
            "quantity"=>0
        ),
        "6"=>array( 
            "quantity"=>0
        ),
        "7"=>array( 
            "quantity"=>0
        ),
        "8"=>array( 
            "quantity"=>0
        ),
        "9"=>array( 
            "quantity"=>0
        ),
        "10"=>array( 
            "quantity"=>0
        ),
        "11"=>array( 
            "quantity"=>0
        ),
        "12"=>array( 
            "quantity"=>0
        )
    );

    while($row = $resultOut->fetch_assoc()) {
        $itemsOut[$row["month"]]["quantity"] += 1;
    }

    // sql date in
    $sqlDateIn = "SELECT MONTH(i_time_in) as month FROM item WHERE i_status != 'delivered' AND YEAR(i_time_in) = YEAR(CURDATE())";
    $resultIn = $link->query($sqlDateIn);

    $itemsIn = array(
        "1"=>array( 
            "quantity"=>0
        ),
        "2"=>array( 
            "quantity"=>0
        ),
        "3"=>array( 
            "quantity"=>0
        ),
        "4"=>array( 
            "quantity"=>0
        ),
        "5"=>array( 
            "quantity"=>0
        ),
        "6"=>array( 
            "quantity"=>0
        ),
        "7"=>array( 
            "quantity"=>0
        ),
        "8"=>array( 
            "quantity"=>0
        ),
        "9"=>array( 
            "quantity"=>0
        ),
        "10"=>array( 
            "quantity"=>0
        ),
        "11"=>array( 
            "quantity"=>0
        ),
        "12"=>array( 
            "quantity"=>0
        )
    );

    while($row = $resultIn->fetch_assoc()) {
        $itemsIn[$row["month"]]["quantity"] += 1;
    }

    // mysqli_close($link);
?>