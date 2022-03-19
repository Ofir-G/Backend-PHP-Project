<?php

require_once('classes/init.php');
global $session;

if (isset($_POST['volunteer-add'])) {

    $error = '';

    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $error .= "<li>Please insert a  name.</li>";
    } elseif (!ctype_alpha(str_replace(' ', '', $_POST['name']))) {
        $error .= "<li>Name should contain only english letters</li>";
    } elseif (strlen($_POST['name']) > 200) {
        $error .= "<li>Name should be under 200 characters.</li>";
    }

    if (($_POST['location']) == "Choose...") {
        $error .= "<li>Please insert a location.</li>";
    }

    if (($_POST['field']) == "Choose...") {
        $error .= "<li>Please insert a field.</li>";
    }

    if (!isset($_POST['description']) || empty($_POST['description'])) {
        $error .= "<li>Please insert a description.</li>";
    } elseif (strlen($_POST['name']) > 1000) {
        $error .= "<li>Name should be under 1000 characters.</li>";
    }

    if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES["fileToUpload"];
    } else {
        $file = null;
    }

    if (empty($error)) {
        $name = $_POST['name'];
        $field = $_POST['field'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $organization = $session->organ_id;

        $new_volunteer_place = new VolunteerPlace();
        $flag = $new_volunteer_place->init($name, $organization, $field, $location, $description, $file);

        if ($flag == true) {
            $error = VolunteerPlace::add_volunteer_place($new_volunteer_place);
        }
    }
    if (!empty($error)) {
        echo $error;
    }
}

?>