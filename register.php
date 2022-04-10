<?php
class Reply
{
}
$reply = new Reply();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['username']) && !empty($_GET['username']) && isset($_GET['password']) && !empty($_GET['password'])) {
        require_once "config.php";
        $username = $_GET['username'];
        $password = $_GET['password'];
        $sql = "SELECT * FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    $reply->status = "error";
                    $reply->message = "utente già registrato";
                    $json = json_encode($reply);
                    echo $json;
                } else {
                    $insertSql = "INSERT INTO users(username, password) VALUES (?, ?)";
                    if ($stmt = mysqli_prepare($conn, $insertSql)) {
                        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
                        $param_username = $username;
                        $param_password = $password;
                        if (mysqli_stmt_execute($stmt)) {
                            $reply->status = "ok";
                            $reply->result = "utente registrato";
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
