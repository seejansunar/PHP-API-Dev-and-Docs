<?php

    include('db.php');

    if(isset($_GET['key']))
    {
        $key = mysqli_real_escape_string($conn, $_GET['key']);
        $checkRes = mysqli_query($conn, "SELECT * FROM api_tokens WHERE token='$key'");
        if(mysqli_num_rows($checkRes)>0)
        {
            $checkRow = mysqli_fetch_assoc($checkRes);
            if($checkRow['status'] == 1)
            {
                if($checkRow['hit_count'] >= $checkRow['hit_limit'])
                {
                    echo json_encode(['status' => 'false', 'data' => 'API hit limit exceeded']);
                    die();
                }else{
                    mysqli_query($conn,  "UPDATE api_tokens SET hit_count = hit_count + 1 WHERE token='$key'");
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
                        echo json_encode(['status' => 'true', 'data' => 'Data not found', 'result' => 'not found']);
                    }
                }
            }else{
                echo json_encode(['status' => 'false', 'data' => 'API key is deactivated']);
            }
        }else{
            echo json_encode(['status' => 'false', 'data' => 'Please enter valid api key']);
        }
        
    }else{
        echo json_encode(['status' => 'false', 'data' => 'Please provide api key']);
    }

?>