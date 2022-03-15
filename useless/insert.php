<?php
    require_once('../main/config.php');

    $sql = "SELECT * FROM slot";
    $result = $link->query($sql);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $sqlUpdate = 'UPDATE slot SET s_i_id = NULL,
                                    s_i_time = NULL
                            WHERE s_status = 0';
        
        $resultUpdate = $link->query($sqlUpdate);
    }

    $link->close();
?>
