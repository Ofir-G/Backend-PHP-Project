<?php
require_once('classes/init.php');
global $session;
if ($session->user_signed_in || $session->organ_signed_in) {
    header('Location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VMA | Log in / Sign up</title>
    <link rel="icon" type="image/x-icon" href="../pics/favicon-praying.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&family=Ubuntu:ital,wght@1,500&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Itim&family=Oswald:wght@200;300;500&family=Special+Elite&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">

</head>

<body>

<?php include 'header.php'; ?>

<main class="container">
    <div class="box">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active login" id="pills-home-tab" data-toggle="pill" href="#login" role="tab"
                   aria-controls="pills-home" aria-selected="true">Log in</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link login" id="pills-profile-tab" data-toggle="pill" href="#signup" role="tab"
                   aria-controls="pills-profile" aria-selected="false">Sign Up</a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="form-group text-center">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="login-organ">
                        <label class="custom-control-label" for="login-organ">Login as an organization</label>
                    </div>
                </div>

                <!--   User Login   -->

                <form class="login-user" id="login-user" novalidate method="post">

                    <div class="form-group mb-3">
                        <label for="email-login-user">Email</label>
                        <input type="email" class="form-control" id="email-login-user" placeholder="name@domain.com"
                               name="email"
                               required
                               pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password-login-user">Password</label>
                        <input type="password" class="form-control" id="password-login-user" name="password"
                               required>
                    </div>

                    <div class="alert alert-danger display-error display-none"></div>
                    <button name="login-user" id="user-log-in-submit" class="btn-log btn btn-dark mt-4 mb-3"
                            type="submit">
                        Log in
                    </button>
                </form>

                <form class="display-none" id="login-organization" novalidate method="post">

                    <!--    Organization Login    -->

                    <div class="form-group mb-3">
                        <label for="id-login-organ">Your organization ID</label>
                        <input type="number" class="form-control" id="id-login-organ" placeholder="1111111"
                               name="id"
                               max="1000000000000000" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password-login-organ">Password</label>
                        <input type="password" class="form-control" id="password-login-organ" name="password"
                               required>
                    </div>
                    <div class="alert alert-danger display-error display-none"></div>

                    <button name="login-organ" class="btn-log btn btn-dark mt-4 mb-3" type="submit">
                        Log
                        in
                    </button>
                </form>
            </div>

            <!--    Sign UP    -->

            <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="pills-profile-tab">

                <div class="form-group text-center">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="signup-organ">
                        <label class="custom-control-label" for="signup-organ">Sign up as an organization</label>
                    </div>
                </div>

                <!--    User Sign Up    -->

                <form id="signup-user" novalidate method="post" enctype="multipart/form-data">

                    <div class="form-group mb-3">
                        <label for="signup-email">Email<span class="required"> *</span></label>
                        <input type="email" class="form-control" id="signup-email" placeholder="name@domain.com"
                               name="email"
                               required
                               pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}">

                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="firstName">First name<span class="required"> *</span></label>
                            <input type="text" class="form-control" id="firstName" placeholder="John" required
                                   pattern="[A-Za-z]{1,10}" maxlength="10" name="firstName">

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="lastName">Last name<span class="required"> *</span></label>
                            <input type="text" class="form-control" id="lastName" placeholder="Smith" required
                                   pattern="[A-Za-z]{1,10}" maxlength="10" name="lastName">

                        </div>
                        <div class="col-md-4 mb-3">

                            <label for="phone">Phone Number<span class="required"> *</span></label>
                            <input type="tel" class="form-control" id="phone" placeholder="0500000000"
                                   name="phone"
                                   min="99999999"
                                   max="1000000000000000" minlength="9" required>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label for="city">City<span class="required"> *</span></label>
                            <select class="custom-select" id="city" required name="city">
                                <option selected disabled value="">Choose...</option>
                                <option>Tel Aviv</option>
                                <option>Petah Tikva</option>
                                <option>Haifa</option>
                                <option>Jerusalem</option>
                                <option>Holon</option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date">Date of birth<span class="required"> *</span></label>
                            <input name="date" type="date" class="form-control" id="date" required
                                   max="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' -13 years')); ?>">
                            <small id="emailHelp" class="form-text text-muted">You need to be 13 or older to
                                join. </small>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="customFile-user">Upload a picture to your profile</label>
                        <div class="custom-file">
                            <input type="file" name="fileToUpload" class="custom-file-input"
                                   id="customFile-user"
                                   onchange="uploadFile(this)">
                            <label class="custom-file-label" id="filelabel" for="customFile-user"></label>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">File types allowed: jpg, jpeg, gif, png. Max
                            size: 5MB.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="choose-password">Choose your password<span class="required"> *</span></label>
                        <input type="password" class="form-control" id="choose-password" name="password" required>
                    </div>
                    <div class="alert alert-danger display-error display-none"></div>

                    <button name="user-signup" class="btn-log btn btn-dark mt-4 mb-3" type="submit">
                        Join
                    </button>
                </form>

                <!--    Organization Sign Up    -->

                <div class="display-none alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
                    <strong>For your information:</strong> once registered the data you provided will be immediately
                    show in our Organizations page.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="display-none" id="signup-organization" novalidate method="post">

                    <div class="form-group mb-3">
                        <label for="id-signup-organ">Your organization ID<span class="required"> *</span></label>
                        <input type="number" class="form-control" id="id-signup-organ" placeholder="111111"
                               name="id"
                               max="1000000000000000" required>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="organ-name">Name<span class="required"> *</span></label>
                            <input type="text" class="form-control" id="organ-name" required
                                   pattern="[A-Za-z]{1,10}" maxlength="10" name="name">
                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="organ-phone">Phone Number<span class="required"> *</span></label>
                            <input type="tel" class="form-control" id="organ-phone" placeholder="030000000"
                                   name="phone"
                                   min="99999999"
                                   max="1000000000000000" minlength="9" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="organ-street">Street Address<span class="required"> *</span></label>
                            <input type="text" class="form-control" id="organ-street" required placeholder="Aza 23"
                                   name="street"
                                   pattern="[A-Za-z0-9\s]+" maxlength="50">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="organ-city">City<span class="required"> *</span></label>
                            <select class="custom-select" id="organ-city" required name="city">
                                <option selected disabled value="">Choose...</option>
                                <option>Tel Aviv</option>
                                <option>Petah Tikva</option>
                                <option>Holon</option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="organ-choose-password">Choose your password<span class="required"> *</span></label>
                        <input type="password" class="form-control" id="organ-choose-password" name="password"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="organ-mission">Short description of your organization<span
                                    class="required"> *</span></label>
                        <textarea class="form-control" name="mission" id="organ-mission" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="organ-desc">More about you</label>
                        <textarea class="form-control" name="description" id="organ-desc" rows="3"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="customFile">Upload a picture</label>
                        <div class="custom-file">
                            <input type="file" name="fileToUpload" class="custom-file-input"
                                   id="customFile-organ"
                                   onchange="uploadFile(this)">
                            <label class="custom-file-label" id="filelabel" for="customFile-organ"></label>
                        </div>
                        <small id="fileHelp" class="form-text text-muted">File types allowed: jpg, jpeg, gif, png. Max
                            size: 5MB.</small>
                    </div>

                    <div class="alert alert-danger display-error display-none"></div>

                    <button name="organ-signup" class="btn-log btn btn-dark mt-4 mb-3"
                            type="submit">
                        Join
                    </button>
                </form>

            </div>
        </div>
    </div>
</main>

<main class="container">

</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script src="../js/login.js"></script>

<script>


</script>


</body>

</html>