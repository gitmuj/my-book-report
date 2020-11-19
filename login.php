<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->
<?php
include('templates/header.php');
include('config/db_connect.php');

//session_start();
$_SESSION['valid'] = false;

$email = $password = $inputPassword = '';
$email_message = $password_message = '';
$inputPassword = null;

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    // if ($result == 0) {
    //     $message = "User not found";
    //     return;
    // }
    $user = mysqli_fetch_assoc($result);
    if (!isset($user['password'])) {
        $email_message = "User not found";
    } else {
        $inputPassword = $user['password'];
    }




    if (password_verify($password, $inputPassword)) {

        $password_message =  'Password is valid!';
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $user['email'];
        header('Location: index.php');
    } else {


        $password_message =  'Invalid password.';
    }
} // end post submit check

?>

<head>
    <link href="css/login-page.css" rel="stylesheet">
</head>
<html>


<div class="container" style="margin-top: 5% ;">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Sign In</h5>
                    <form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-label-group">
                            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            <label for="inputEmail">Email address</label>
                        </div>

                        <div class="form-label-group">
                            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Remember password</label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" name="submit" type="submit">Sign in</button>
                        <hr class="my-4">
                        <!-- <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Sign in with Google</button>
                        <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook</button> -->
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</html>