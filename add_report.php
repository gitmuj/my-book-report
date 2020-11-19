<?php
include('templates/header.php');
include('config/db_connect.php');

//session_start();
//print_r($_SESSION['book']);
$button_text = "Add Report";
$good_text = $bad_text = $key_points_text = '';
$rating = 0;

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

if (isset($_POST['submit']) && isset($_SESSION['valid']) && $_SESSION['valid'] == true) {

    // escape sql chars

    $user = mysqli_real_escape_string($conn, $_SESSION['username']);
    $title = mysqli_real_escape_string($conn, $_SESSION['book'][2]);
    //$rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $bad = mysqli_real_escape_string($conn, $_POST['bad']);
    $good = mysqli_real_escape_string($conn, $_POST['good']);
    $key_points = mysqli_real_escape_string($conn, $_POST['key_points']);
    $rating = mysqli_real_escape_string($conn, $_POST['score']);

    echo $selectOption = $_POST['taskOption'];
    if ($button_text !== 'Update') {
        $sql = "INSERT INTO reports (book_title, user, good, bad, key_points, rating) VALUES ('$title','$user','$good','$bad','$key_points', $rating)";
    } else {
        $sql = "UPDATE reports 
        SET book_title = '$title', user = '$user', good = '$good', bad = '$bad', key_points = '$key_points', rating = $rating
        WHERE user = '$user' AND book_title = '$title'";
    }

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: view_report.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
} // end POST check


?>

<style>
    body {
        background: url('https://source.unsplash.com/twukN12EN7c/1920x1080') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        background-size: cover;
        -o-background-size: cover;
    }
</style>






<!-- Page Content -->
<div class="container">
    <div class="card border-0 shadow my-5">
        <div class="card-body p-5">
            <h1 class="font-weight-light">Add Report</h1>
            <p class="lead">Add your mini book report for "<?php echo $_SESSION['book'][2] ?>" below!</p>
            <p class="lead">Scroll down...</p>
            <div style="height: 700px">
                <form action="add_report.php" method="POST">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Enter the good thoughts about the book...</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="good" rows="6"><?php echo $good_text ?></textarea>
                        <label for="exampleFormControlTextarea1">Enter the bad or not so great things about the book...</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="bad" rows="6"><?php echo $bad_text ?></textarea>
                        <label for="exampleFormControlTextarea1">Key things to remember from the book...</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="key_points" rows="6"><?php echo $key_points_text ?></textarea>
                    </div>

                    <div class="form-group col-lg-1">
                        <label for="rating">Rating: </label>
                        <select name="score">
                            <?php for ($i = 1; $i <= 5; $i++) {
                                if ($i == $rating) {
                                    echo "<option value='$i' selected>$i Star</option>";
                                }
                                echo "<option value='$i'>$i Star</option>";
                            } ?>
                        </select>
                    </div>

            </div>
            <button name="submit" type="submit" class="btn btn-info"><?php echo $button_text ?></button>
            </form>
        </div>
    </div>
</div>



<?php include('templates/footer.php'); ?>