<?php
class Reply
{
}
$reply = new Reply();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['key']) && !empty($_GET['key']) && isset($_GET['string']) && !empty($_GET['string']) && isset($_GET['token']) && !empty($_GET['token'])) {
        require_once "config.php";
        $token = $_GET['token'];
        $key = $_GET['key'];
        $string = $_GET['string'];
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
                    $sqlCheck = "SELECT * FROM `data` WHERE `user` = ? AND `key` = ?";
                    if ($stmtCheck = mysqli_prepare($conn, $sqlCheck)) {
                        mysqli_stmt_bind_param($stmtCheck, "ss", $param_user, $param_key);
                        $param_user = $userId;
                        $param_key = $key;
                        if (mysqli_stmt_execute($stmtCheck)) {
                            $result2 = mysqli_stmt_get_result($stmtCheck);
                            if (mysqli_num_rows($result2) == 0) {
                                $sqlInsert = "INSERT INTO data(`user`, `key`, `string`) VALUES (?, ?, ?)";
                                if ($stmtInsert = mysqli_prepare($conn, $sqlInsert)) {
                                    mysqli_stmt_bind_param($stmtInsert, "sss", $param_user, $param_key, $param_string);
                                    $param_user = $userId;
                                    $param_key = $key;
                                    $param_string = $string;
                                    if (mysqli_stmt_execute($stmtInsert)) {
                                        $reply->status = "ok";
                                        $reply->result = "stringa salvata";
                                        $json = json_encode($reply);
                                        echo $json;
                                    } else {
                                        $reply->status = "error";
                                        $reply->message = "qualcosa è andato storto";
                                        $json = json_encode($reply);
                                        echo $json;
                                    }
                                }
                            } else {
                                $reply->status = "error";
                                $reply->message = "key già usata";
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
