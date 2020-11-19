<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->
<?php
include('config/db_connect.php');

include('templates/header.php');

$email = $password = $password2 = '';
$errors = array('email' => '', 'password' => '', 'password2' => '');

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['submit'])) {

    // check email
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        }
    }


    //check password



    if (!empty($_POST["password"]) && ($_POST["password"] == $_POST["password2"])) {

        $result = (preg_match('/[A-Z]+/', $_POST["password"]) && preg_match('/[a-z]+/', $_POST["password"]) && preg_match('/[\d!$%^&]+/', $string));

        if (strlen($_POST["password"]) <= '8') {
            $errors['password'] = "Your Password Must Contain At Least 8 Characters!";
        } elseif (!preg_match("/[0-9]+/", $_POST["password"])) {
            $errors['password'] = "Your Password Must Contain At Least 1 Number!";
        } elseif (!preg_match("/[A-Z]+/", $_POST["password"])) {
            $errors['password'] = "Your Password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("/[a-z]+/", $_POST["password"])) {
            $errors['password'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        } else if (preg_match("/\\s/", $_POST["password"])) {
            $errors['password'] = "Your Password cannot contain empty spaces.";
        }
    }

    if (!empty($_POST["password"]) && !empty($_POST["password2"]) && ($_POST["password"] !== $_POST["password2"])) {
        $errors['password2'] = "Passwords do not match.";
        echo $_POST['password'];
        echo $_POST['password2'];
    }


    if (array_filter($errors)) {
        //echo 'errors in form';
    } else {
        // escape sql chars
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_DEFAULT));

        //create sql
        $sql = "INSERT INTO users(email, password) VALUES ('$email', '$password')";

        //save to db and check
        if (mysqli_query($conn, $sql)) {
            header('Location:login.php');
        } else {
            $errors['email'] =  'query error: ' . mysqli_error($conn) . ' Email address is already registered.';
        }
    }
}
?>

<head>
    <link href="css/register-page.css" rel="stylesheet">
</head>


<div class="container " style="margin-top: 5% ;">

    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card card-signin flex-row my-5">
                <div class="card-img-left d-none d-md-flex">
                    <!-- Background image for card set in CSS! -->
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Register</h5>
                    <form class="form-signin" action="" method="POST">

                        <div class="form-label-group">
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required>
                            <label for="inputEmail">Email address</label>


                        </div>
                        <div class="text-danger"><?php echo $errors['email']; ?></div>

                        <hr>

                        <div class="form-label-group">
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>
                        <div class="text-danger"><?php echo $errors['password']; ?></div>


                        <div class="form-label-group">
                            <input type="password" name="password2" id="inputConfirmPassword" class="form-control" placeholder="Password" required>
                            <label for="inputConfirmPassword">Confirm password</label>
                        </div>
                        <div class="text-danger"><?php echo $errors['password2']; ?></div>


                        <button name="submit" class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
                        <a class="d-block text-center mt-2 small" href="login.php">Sign In</a>
                        <hr class="my-4">
                        <!-- <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Sign up with Google</button>
                        <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Sign up with Facebook</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>