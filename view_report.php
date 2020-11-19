<?php
include('templates/header.php');
include('config/db_connect.php');

//session_start();
//print_r($_SESSION['book']);
$button_text = "Add Report";
$good_text = $bad_text = $key_points_text = '';
$rating = 0;
print_r($_SESSION['book']);

if (isset($_SESSION['valid']) && $_SESSION['valid'] == true) {

    $title = mysqli_real_escape_string($conn, $_SESSION['book'][2]);
    $user = mysqli_real_escape_string($conn, $_SESSION['username']);

    $sql = "SELECT * FROM reports WHERE book_title = '$title' AND user = '$user'";
    //get result

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // success
        $book = mysqli_fetch_all($result);
        $button_text = "Update";
        print_r($book);
        $good_text = $book[0][3];
        $bad_text = $book[0][4];
        $key_points_text = $book[0][5];
        $rating = $book[0][2];

        //header('Location: add_report.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}


//sql to add book to db

?>

<style>
    body {
        background: url('https://source.unsplash.com/twukN12EN7c/1920x1080') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        background-size: cover;
        -o-background-size: cover;
    }

    .fill {
        min-height: 700px;
        height: 100%;
    }
</style>






<!-- Page Content -->
<div class="container">
    <div class="card border-0 shadow my-5">
        <div class="card-body p-5">
            <h1 class="font-weight-light"><?php echo $_SESSION['book'][2] ?></h1>

            <div class="container fill">
                <label>Rating : <?php echo $rating ?></label>
                <div class="container">
                    <h3>The Good</h3>
                    <p><?php echo $good_text ?></p>
                </div>
                <div class="container">
                    <h3>The Bad</h3>
                    <p><?php echo $bad_text ?></p>
                </div>
                <div class="container">
                    <h3>Key things to remember</h3>
                    <p><?php echo $key_points_text ?></p>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('templates/footer.php'); ?>