<?php
require 'config.php';
require 'autoload.php';

use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;
use Hybridauth\Storage\Session;

try {

    $hybridauth = new Hybridauth($config);
    $storage = new Session();
    $error = false;

    if (isset($_GET['provider'])) {
        // Validate provider exists in the $config
        if (in_array($_GET['provider'], $hybridauth->getProviders())) {
            // Store the provider for the callback event
            $storage->set('provider', $_GET['provider']);
        } else {
            $error = $_GET['provider'];
        }
    }

    if ($error) {
        error_log('HybridAuth Error: Provider ' . json_encode($error) . ' not found or not enabled in $config');
        // Close the pop-up window
        echo "
            <script>
                window.opener.location.reload();
                window.close();
            </script>";
        exit;
    }

    //
    // Event 3: Provider returns via CALLBACK
    //
    if ($provider = $storage->get('provider')) {

        $hybridauth->authenticate($provider);
        $storage->set('provider', null);

        // Retrieve the provider record
        $adapter = $hybridauth->getAdapter($provider);
        $userProfile = $adapter->getUserProfile();
        $accessToken = $adapter->getAccessToken();

        $data = [
            'token'         => $accessToken,
            'identifier'    => $userProfile->identifier,
            'email'         => $userProfile->email,
            'first_name'    => $userProfile->displayName,
            'last_name'     => $userProfile->lastName,
            'city'          => $userProfile->city,
            'phone'         => $userProfile->phone,
            'state'         => $userProfile->region,
            'country'       => $userProfile->country,
            'address'       => $userProfile->address,
            'pincode'       => $userProfile->pincode,
            'photoURL'      => strtok($userProfile->photoURL, '?'),
        ];
        // ..
        $name = $data['first_name'];
        $lastname = $data['last_name'];
        //   print $name;
        //$email = print $adapter->getUserProfile()->email;
        $email = $data['email'];
        $identifier = $data['identifier'];
        $profile = $data['photoURL'];
        $site_id = $this_site_id;
        $city = $data['city'];
        $country = $data['country'];
        $phone = $data['phone'];
        $state = $data['state'];
        $address = $data['address'];
        $pincode = $data['pincode'];


        // $ch = curl_init();
        // $accessToken = 'EAAERwQsNoc8BAHdXHSubZCAjbSKTBBJTIknZAZA6bZBMJIlT1S0wS9e0tkmDtvnRkZB1XF3L8UoXEokaWH2MhMZCvj9HSCeEKYqFZB6aZAdxWgtvwmo8IebZCXD1bX7IMeR76m7XFP52k5mwnJVSyp3HCcAvsHn23ssZCH3ZCXu0aEagQNpD3wo230lhNW59BaUWgXadRvgGSwvEqhqcMxpSEGHMYpkba46COWHyeIzIRcMZCWbbCUKVnISm';
        // curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/' . $identifier . '?fields=id,friends&access_token=' . $accessToken . '');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $result = curl_exec($ch);
        // if (curl_errno($ch)) {
        //     echo 'Error:' . curl_error($ch);
        // }
        // curl_close($ch);
        // $result = json_decode($result);
        // $totalCount = -1;
        // foreach ($result as $key => $val) {
        //     if ($key != 'friends')  continue;
        //     foreach ($val as $v1 => $v2) {
        //         if ($v1 != 'summary')
        //             continue;
        //         if ($v1 == 'summary') {
        //             foreach ($v2 as $k1 => $k2) {
        //                 if ($k1 == 'total_count') {
        //                     $totalCount = $k2;
        //                 }
        //             }
        //         }
        //     }
        // }


        // echo "FRIENDS = " . $totalCount ;

        // echo "<br>" ;

        // die;

        ////////////////////////////////////////////////



        $sql = "SELECT * FROM register where email = '" . $email . "' OR fb_id = '" . $identifier . "'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $qry = "INSERT INTO register (name, fb_id, email, profile_pic, user_type, created_date) value ('$name', '$identifier', '$email', '$profile', '1', '$date_for_func') " ;
            if (mysqli_query($conn, $qry)) {
                $_SESSION['user_id'] = mysqli_insert_id($conn) ;
                header("location: ../../login.php?social=registered");
            }
        } else {
            header("Location: ../../login.php?social=already"); //
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
    die;
}
