<?php
require_once('classes/init.php');
global $session;

if ($session->user_signed_in == false) {
    header('Location: ../index.php');
}

$cities = User::count_cities();
$cities = json_encode($cities);

$ages = User::fetch_users_age();
$ages = json_encode($ages);

$user = new User();
$user->find_user_by_email($session->user_email);
$users = User::fetch_users();
$organizations = Organization::fetch_organizations();
$volunteers_joined = Volunteers::find_volunteering($user->email);

$total_volunteers = Volunteers::fetch_volunteering();
$total_volunteer_places = VolunteerPlace::fetch_places();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../pics/favicon-praying.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>VMA | My Dashboard</title>
</head>
<body>
<div class="sidebar active">
    <div class="logo-details">
        <i class="fas fa-praying-hands"></i>
        <span class="logo_name">F4L</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="#" class="active">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li class="log_out">
            <a href="logout.php">
                <i class='bx bx-log-out'></i>
                <span class="links_name">Log out</span>
            </a>
        </li>
    </ul>
</div>

<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Dashboard</span>
        </div>
        <a href="../index.php" class="btn-back btn btn-primary" role="button">Go back to site</a>

        <div class="profile-details">
            <img src="../pics/<?php if ($user->image) {
                echo $user->image;
            } else {
                echo "no_image_available.jpg";
            } ?>" alt="profile-pic">
            <span class="admin_name "><?php echo $user->firstname . " " . $user->lastname; ?></span>
        </div>
    </nav>

    <div class="home-content">
        <div class="overview-boxes">
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Site Users</div>
                    <div class="number text-center"><?php echo count($users) ?></div>
                </div>
            </div>
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Site Organizations</div>
                    <div class="number text-center"><?php echo count($organizations) ?></div>
                </div>
            </div>
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Joined Volunteering</div>
                    <div class="number text-center"><?php echo count($total_volunteers) ?></div>
                </div>
            </div>
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Site Volunteer Places</div>
                    <div class="number text-center"><?php echo count($total_volunteer_places) ?></div>
                </div>
            </div>
        </div>

        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="title"> <?php echo $session->user_firstname; ?>'s Volunteer Places</div>
                <div class="sales-details">

                    <table class="table table-hover mt-4">
                        <thead>
                        <tr>
                            <th scope="col">Date Joined</th>
                            <th scope="col">Name</th>
                            <th scope="col">Field</th>
                            <th scope="col">Orgazination</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($volunteers_joined) {
                            foreach ($volunteers_joined

                                     as $volunteer_join) {

                                $volunteer_place = new VolunteerPlace();
                                $volunteer_place->fetch_place_by_num($volunteer_join->volunteer_num);
                                ?>
                                <tr>
                                    <td><?php echo $volunteer_join->date ?></td>
                                    <td><?php echo $volunteer_place->name ?></td>
                                    <td><?php echo $volunteer_place->field ?></td>
                                    <td><?php $organ = new Organization();
                                        $organ->find_organ_by_id($volunteer_place->organization);
                                        echo $organ->name; ?></td>


                                </tr>

                            <?php }
                        } else { ?>
                            <tr>
                                <td>You haven't joined any volunteering yet :(</td>

                            </tr>
                        <?php } ?>


                        </tbody>
                    </table>

                </div>
            </div>

            <div class="top-sales box">
                <div class="title"> <?php echo $session->user_firstname; ?>'s Profile Summery</div>
                <div class="top-sales-details">

                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Full Name:</strong>
                            &nbsp; <?php echo $user->firstname . " " . $user->lastname; ?></li>
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Mobile:</strong>
                            &nbsp; <?php echo $user->phone; ?></li>
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Email: </strong>
                            &nbsp; <?php echo $user->email; ?></li>
                        </li>
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Location:</strong>
                            &nbsp; <?php echo $user->city; ?></li>
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Age:</strong>
                            &nbsp; <?php echo $age = date_diff(date_create($user->birthdate), date_create('now'))->y; ?>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="sales-boxes pb-5 mt-3">
            <div id="left-sec-row" class="down-boxes recent-sales box">
                <div class="title"> Our users based on location</div>

                <canvas id="myBarChart"></canvas>

            </div>

            <div class="down-boxes top-sales box">
                <div class="title">Our Users based on age group</div>
                <canvas id="myPieChart"></canvas>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
<script src="../js/dashboard.js"></script>

<script>
    var xValues = ["Tel Aviv", "Petah Tikva", "Holon", "Jerusalem", "Haifa"];
    var yValues = <?php echo $cities; ?>;
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];

    new Chart("myBarChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {display: false},
            title: {
                display: true,
            },
            plugins: {
                labels: {
                    render: 'value',
                }
            }
        }
    });

    var xValues = ["10-19", "20-29", "30-39", "40-49", "50+"];
    var yValues = <?php echo $ages; ?>;
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];

    new Chart("myPieChart", {
        type: "doughnut",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues,
            }]
        },
        options: {
            legend: {
                position: 'bottom'
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    fontColor: ['white', 'white', 'white', 'white', 'white'],
                    precision: 2
                }
            }
        }
    });

</script>

</body>
</html>

