<?php
require_once('classes/init.php');
global $session;

//User login

if (isset($_POST['login-user'])) {
    $error = '';

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $error .= "<li>Please insert valid email.</li>";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error .= "<li>Invalid email format</li>";
    } elseif (strlen($_POST['email']) > 50) {
        $error .= "<li>Email should be under 100 characters.</li>";
    }

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $error .= "<li>Please insert a password.</li>";
    } else if (strlen($_POST['password']) > 50) {
        $error .= "<li>Please keep password under 50 characters.</li>";
    }

    if (empty($error)) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = new User();
        $error .= $user->login_cred_user($email, $password);
    }

    if (empty($error)) {
        $session->user_login($user);
    } else {
        echo $error;
    }
}

//Organization login

if (isset($_POST['login-organ'])) {
    $error = '';

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $error .= "<li>Please insert a password.</li>";
    } else if (strlen($_POST['password']) > 50) {
        $error .= "<li>Password should be under 50 characters.</li>";
    }

    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $error .= "<li>Please insert an ID.</li>";
    } elseif (!ctype_digit($_POST['id'])) {
        $error .= "<li>ID should contain only digits, no hyphen.</li>";
    } elseif (strlen((string)$_POST['id']) > 11) {
        $error .= "<li>ID should be under  11 characters.</li>";
    }

    if (empty($error)) {
        $id = $_POST['id'];
        $password = $_POST['password'];

        $organization = new Organization();
        $error = $organization->login_cred_organ($id, $password);
    }
    if (empty($error)) {
        $session->organ_login($organization);

    } else {
        echo $error;
    }
}


//User sign up

if (isset($_POST['user-signup'])) {
    $error = '';
    $image_name = null;

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $error .= "<li>Please insert an email.</li>";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error .= "<li>Invalid email format</li>";
    } elseif (strlen($_POST['email']) > 100) {
        $error .= "<li>Email should be under 100 characters.</li>";
    }

    if (!isset($_POST['firstName']) || empty($_POST['firstName'])) {
        $error .= "<li>Please insert a first name.</li>";
    } elseif (!ctype_alpha($_POST['firstName'])) {
        $error .= "<li>First name should contain only english letters</li>";
    } elseif (strlen($_POST['firstName']) > 50) {
        $error .= "<li>Name should be under 50 characters.</li>";
    }

    if (!isset($_POST['lastName']) || empty($_POST['lastName'])) {
        $error .= "<li>Please insert a last name.</li>";
    } elseif (!ctype_alpha($_POST['lastName'])) {
        $error .= "<li>Last name should contain only english letters.</li>";
    } elseif (strlen($_POST['lastName']) > 50) {
        $error .= "<li>Last name should be under 50 characters.</li>";
    }

    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $error .= "<li>Please insert a phone.</li>";
    } elseif (!ctype_digit($_POST['phone'])) {
        $error .= "<li>Phone should contain only digits, no hyphen.</li>";
    } elseif (strlen((string)$_POST['phone']) != 10) {
        $error .= "<li>Phone should be 10 characters.</li>";
    }

    if (!isset($_POST['city']) || empty($_POST['city'])) {
        $error .= "<li>Please insert a city.</li>";
    }

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $error .= "<li>Please insert a password.</li>";
    } elseif (strlen($_POST['password']) > 50 || strlen($_POST['password']) < 3) {
        $error .= "<li>Password should be at least 3 characters and no more than 50 characters.</li>";
    }

    if (!isset($_POST['date']) || empty($_POST['date'])) {
        $error .= "<li>Please insert a birth date.</li>";
    }
    if ($_POST['date'] > date('Y-m-d', strtotime(date('Y-m-d') . ' -13 years'))) {
        $error .= "<li>You need to be 13 or older to join. </li>";
    }

    if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES["fileToUpload"];
        $target_dir = "../pics/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $error_file = "";

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error_file .= "<li>File is not an image.</li>";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($file["size"] > 5242880) {
            $error_file .= "<li>File is too large. Make sure it's under 5MB.</li>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $error_file .= "<li>Only JPG, JPEG, PNG & GIF files are allowed.</li>";
            $uploadOk = 0;
        }


        // if everything is ok, try to upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $image_name = basename($file["name"]);
            } elseif (empty($error_file)) {
                $error_file .= "<li>Sorry, there was an error uploading your file. Please try again.</li>";
            }
        }
        if (!empty($error_file)) {
            $error .= "<li>File Check...</li><ul>";
            $error .= $error_file . "</ul>";
        } else {
            $image_name = basename($file["name"]);
        }
    }

    if (empty($error)) {
        $email = $_POST['email'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $password = $_POST['password'];
        $date = $_POST['date'];

        $user = new User;
        $user->init($email, $firstName, $lastName, $phone, $city, $password, $image_name, $date);
        $error = User::add_user($user);
    }
    if (empty($error)) {
        $session->user_login($user);

    } else {
        echo $error;
    }
}

//Organization sign up

if (isset($_POST['organ-signup'])) {
    $error = '';
    $image_name = null;

    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $error .= "<li>Please insert an ID.</li>";
    } elseif (!ctype_digit($_POST['id'])) {
        $error .= "<li>ID should contain only digits, no hyphen.</li>";
    } elseif (strlen((string)$_POST['id']) > 11) {
        $error .= "<li>ID should be under  11 characters.</li>";
    }

    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $error .= "<li>Please insert a name.</li>";
    } elseif (!ctype_alpha(str_replace(' ', '', $_POST['name']))) {
        $error .= "<li>Name should contain only english letters</li>";
    } elseif (strlen($_POST['name']) > 100) {
        $error .= "<li>Please keep name under 100 characters.</li>";
    }

    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $error .= "<li>Please insert a phone.</li>";
    } elseif (!ctype_digit($_POST['phone'])) {
        $error .= "<li>Phone should contain only digits, no hyphen.</li>";
    } elseif (strlen((string)$_POST['phone']) != 10) {
        $error .= "<li>Phone should be 10 characters.</li>";
    }

    if (!isset($_POST['street']) || empty($_POST['street'])) {
        $error .= "<li>Please insert a street address.</li>";
    } elseif (empty(preg_match('/[A-Za-z0-9\s]+/', $_POST['street']))) {
        $error .= "<li>Street address should contain only english letters and a number.</li>";
    } elseif (strlen($_POST['street']) > 200) {
        $error .= "<li>Please keep street address under 200 characters.</li>";
    }

    if (!isset($_POST['city']) || empty($_POST['city'])) {
        $error .= "<li>Please insert a city.</li>";
    }

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $error .= "<li>Please insert a password.</li>";
    } elseif (strlen($_POST['password']) > 50 || strlen($_POST['password']) < 3) {
        $error .= "<li>Password should be at least 3 characters and no more than 50 characters.</li>";
    }

    if (!isset($_POST['mission']) || empty($_POST['mission'])) {
        $error .= "<li>Please insert a short description.</li>";
    } elseif (strlen($_POST['mission']) > 1000) {
        $error .= "<li>Please keep short description under 1000 characters.</li>";
    } elseif (isset($_POST['description'])) {
        if (strlen($_POST['description']) > 4000) {
            $error .= '<li>Please keep "more about you" under 4000 characters.</li>';
        }
    }

    if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES["fileToUpload"];
        $target_dir = "../pics/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $error_file = "";

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error_file .= "<li>File is not an image.</li>";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($file["size"] > 5242880) {
            $error_file .= "<li>File is too large. Make sure it's under 5MB.</li>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $error_file .= "<li>Only JPG, JPEG, PNG & GIF files are allowed.</li>";
            $uploadOk = 0;
        }

        // if everything is ok, try to upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $image_name = basename($file["name"]);
            } elseif (empty($error_file)) {
                $error_file .= "<li>Sorry, there was an error uploading your file. Please try again.</li>";
            }
        }
        if (!empty($error_file)) {
            $error .= "<li>File Check...</li><ul>";
            $error .= $error_file . "</ul>";
        } else {
            $image_name = basename($file["name"]);
        }
    }

    if (empty($error)) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['street'];
        $description = $_POST['description'];
        $mission_statement = $_POST['mission'];
        $password = $_POST['password'];

        $organization = new Organization();
        $organization->init($id, $name, $phone, $city, $address, $description, $mission_statement, $password, $image_name);
        $error = Organization::add_organization($organization);
    }

    if (empty($error)) {
        $session->organ_login($organization);
    } else {
        echo $error;
    }
}

?>