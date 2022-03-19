<?php
require_once('classes/init.php');
global $session;

$volunteer_places = VolunteerPlace::fetch_places();

if (isset($_POST['join'])) {
    $error = '';
    $volunteer_num = $_POST['volunteer-num'];

    if (Volunteers::check_exist($session->user_email, $volunteer_num) != 1) {
        $error .= "Your are already registered to this volunteering.";
    } else {
        $error = Volunteers::add_user($session->user_email, $volunteer_num);
        if ($error) {
            echo $error;
        }
    }
}

?>