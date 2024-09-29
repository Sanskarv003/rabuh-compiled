<?php
include '../connection.php' ;
include 'configLogin.php';

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

        $qry = "SELECT * FROM register where email = '$email' or google_id = '$gid' and user_type != '0' " ;
        $res = mysqli_query($conn, $qry) ;
        if ($res) {
            $res = mysqli_fetch_assoc($res);
            if (isset($res['id'])) {
                $_SESSION['user_id'] = $res['id'] ;
                $verify_code = password_hash($res['id'], PASSWORD_DEFAULT) ;
                $_SESSION['verify_code'] = $verify_code ;
                $qry = "UPDATE register set verify_code = '$verify_code' where id = '".$res['id']."' " ;
                mysqli_query($conn, $qry); 
                header('location: ../../home.php') ;
            } else {
                    header('location: ../../signup?social=create');
            }
        } else {
            die ("Server Error.") ;
        }
    } else {
        die("SERVER ERROR.") ;
    }
} else {
    echo "Invalid Request";
    die;
}
