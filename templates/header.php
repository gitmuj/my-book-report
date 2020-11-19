<?php

if (!isset($_SESSION)) {
    session_start();
}

include('config/db_connect.php');



$button = '<li><a class="btn btn-primary" href="login.php">Sign In</a></li>';
$register_btn = '<li><a class="btn btn-dark mr-1" href="register.php">Register</a><span class="sr-only">(current)</span></li>';
$dashboard_btn = '';


if (isset($_SESSION['valid']) && $_SESSION['valid'] == true) {
    $button = '<li class="nav-item active"><a class="nav-link btn-danger btn rightbutton" href="logout.php">Log out<span class="sr-only">(current)</span></a></li>';

    $dashboard_btn = '<li class="nav-item active"><a class="nav-link" href="dashboard.php"><img src="./img/icons/books.png" class="rightbutton btn">My Books<span class="sr-only">(current)</span></a></li>';
}
?>


<style>
    .toplogo {
        height: 45px;
        width: auto;
        margin-top: 5px;
    }

    .rightbutton {
        height: 45px;
        width: auto;
        margin-top: 5px;
    }
</style>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Book Report</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>


</head>

<body class="d-flex flex-column min-vh-100">


    <!-- Navigation -->


    <nav class="navbar navbar-inverse fixed-top navbar-light bg-light static-top">
        <div class="container">

            <a class="navbar-brand" href="index.php"><img class="toplogo" src="./img/icons/reading.png">My Book Report</a>
            <ul class="nav justify-content-end">

                <?php if (isset($_SESSION['valid']) && $_SESSION['valid'] == true) {
                    echo $dashboard_btn;
                } ?>
                <?php if (isset($_SESSION['valid']) && $_SESSION['valid'] == false) {
                    echo $register_btn;
                } ?>
                <?php echo $button; ?>
            </ul>



        </div>
    </nav>