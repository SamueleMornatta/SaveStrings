<?php
class Reply
{
}
$reply = new Reply();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['key']) && !empty($_GET['key']) && isset($_GET['token']) && !empty($_GET['token'])) {
        require_once "config.php";
        $token = $_GET['token'];
        $key = $_GET['key'];
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
                    $sqlGet = "SELECT string FROM `data` WHERE `user` = ? AND `key` = ?";
                    if ($stmtGet = mysqli_prepare($conn, $sqlGet)) {
                        mysqli_stmt_bind_param($stmtGet, "ss", $param_user, $param_key);
                        $param_user = $userId;
                        $param_key = $key;
                        if (mysqli_stmt_execute($stmtGet)) {
                            $resultGet = mysqli_stmt_get_result($stmtGet);
                            if (mysqli_num_rows($resultGet) > 0) {
                                $rowGet = $row = mysqli_fetch_array($resultGet);
                                $string = $rowGet['string'];
                                $reply->status = "ok";
                                $reply->result = $string;
                                $json = json_encode($reply);
                                echo $json;
                            } else {
                                $reply->status = "error";
                                $reply->message = "nessuna stringa trovata";
                                $json = json_encode($reply);
                                echo $json;
                            }
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
