<?php
    $sqlFilterFrom = 'SELECT DISTINCT i_from from item';
    $resultFilterFrom = $link->query($sqlFilterFrom);

    $sqlFilterTo = 'SELECT DISTINCT i_to from item WHERE i_to != ""';
    $resultFilterTo = $link->query($sqlFilterTo);

    $sqlFilterStatus = 'SELECT DISTINCT i_status from item';
    $resultFilterStatus = $link->query($sqlFilterStatus);

    $sqlFilterDP = 'SELECT DISTINCT i_dp from item';
    $resultFilterDP = $link->query($sqlFilterDP);

    $sqlFilterStaff = 'SELECT DISTINCT i_staff from item';
    $resultFilterStaff = $link->query($sqlFilterStaff);
?>