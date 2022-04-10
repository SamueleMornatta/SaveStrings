<?php
class Reply
{
}
$reply = new Reply();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['token']) && !empty($_GET['token'])) {
        require_once "config.php";
        $token = $_GET['token'];
        $sql = "SELECT id FROM users WHERE token = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_token);
            $param_token = $token;
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 0) {
                    $reply->status = "error";
                    $reply->message = "credenziali errate";
                    $json = json_encode($reply);
                    echo $json;
                } else {
                    $row = mysqli_fetch_array($result);
                    $userId = $row['id'];
                    $sqlKeys = "SELECT `key` FROM `data` WHERE `user` = ?";
                    if ($stmtKeys = mysqli_prepare($conn, $sqlKeys)) {
                        mysqli_stmt_bind_param($stmtKeys, "s", $param_user);
                        $param_user = $userId;
                        if (mysqli_stmt_execute($stmtKeys)) {
                            $resultKeys = mysqli_stmt_get_result($stmtKeys);
                            $keys = [];
                            for ($i = 0; $i < mysqli_num_rows($resultKeys); $i++) {
                                $rowKey = mysqli_fetch_array($resultKeys);
                                $keys[$i] = $rowKey['key'];
                            }
                            $reply->status = "ok";
                            $reply->result = $keys;
                            $json = json_encode($reply);
                            echo $json;
                        } else {
                            $reply->status = "error";
                            $reply->message = "qualcosa è andato storto";
                            $json = json_encode($reply);
                            echo $json;
                        }
                    }
                }
            } else {
                $reply->status = "error";
                $reply->message = "qualcosa è andato storto";
                $json = json_encode($reply);
                echo $json;
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    } else {
        $reply->status = "error";
        $reply->message = "credenziali errate";
        $json = json_encode($reply);
        echo $json;
    }
} else {
    $reply->status = "error";
    $reply->message = "solo richieste GET supportate";
    $json = json_encode($reply);
    echo $json;
}
