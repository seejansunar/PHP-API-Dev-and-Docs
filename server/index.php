<?php

    include('db.php');

    if(isset($_GET['key']))
    {
        $key = mysqli_real_escape_string($conn, $_GET['key']);
        $checkRes = mysqli_query($conn, "SELECT status FROM api_tokens WHERE token='$key'");
        if(mysqli_num_rows($checkRes)>0)
        {
            $checkRow = mysqli_fetch_assoc($checkRes);
            if($checkRow['status'] == 1)
            {
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
            }else{
                echo json_encode(['status' => 'false', 'msg' => 'API key is deactivated']);
            }
        }else{
            echo json_encode(['status' => 'false', 'msg' => 'Please enter valid api key']);
        }
        
    }else{
        echo json_encode(['status' => 'false', 'msg' => 'Please provide api key']);
    }

?>