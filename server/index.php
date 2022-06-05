<?php

    include('db.php');

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    header('Content-Type: application/json');

    if($count > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $arr[] = $row;
        }
        echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'found']);
    }else{
        echo json_encode(['status' => 'true', 'msg' => 'Data not found', 'result' => 'not found']);
    }

?>