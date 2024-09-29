<?php
include '../connection.php';
include 'config.php';
include '../generalMailer.php' ;

if (isset($_GET["code"])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();
        $email = $data['email'];
        $gid = $data['id'];
        $name = $data['given_name'] . " " . $data['family_name'];
        $profile = $data['picture'];

        $qry = "SELECT * FROM register where email = '$email' or google_id = '$gid' and user_type != '0' ";
        $res = mysqli_query($conn, $qry);
        if ($res) {
            $res = mysqli_fetch_assoc($res);
            if (isset($res['id'])) {
                header('location: ../../login.php?social=already');
            } else {
                $qry = "INSERT INTO register (name, google_id, email, profile_pic, user_type, created_date) value ('$name', '$gid', '$email', '$profile', '1', '$curr_date') ";
                if (mysqli_query($conn, $qry)) {
                    $_SESSION['user_id'] = mysqli_insert_id($conn);
                    $uid = $_SESSION['user_id'] ;
                    $verify_code = password_hash($uid, PASSWORD_DEFAULT);
                    $_SESSION['verify_code'] = $verify_code;
                    $qry = "UPDATE register set verify_code = '$verify_code' where id = '" . $uid . "' ";
                    if (mysqli_query($conn, $qry)) {

                        $subject = "Account Created" ;
                        $body = '<div style="background-color: rgb(156, 250, 15); padding: 15px; text-align: center;">Your account has been created successfully on <a href="'.$this_site_link.'">Classroom</a></div>' ;

                        if (!sendMail($email, $subject, $body)) {
                            die ('Mail not sent') ;
                        }
                    }
                    header('location: ../../home.php?social=registered');
                } else {
                    header('location: ../../signup.php?social=failed');
                }
            }
        } else {
            die("Server Error.");
        }
    } else {
        die("SERVER ERROR.");
    }
} else {
    echo "Invalid Request";
    die;
}
