<?php

if (!isset($_SESSION)) {
    session_start();
}

include('config/db_connect.php');
include('templates/header.php');
include('templates/small_searchbar.php');

//print_r($_SESSION);
$books = [];
if ($_SESSION['books'] != null) {

    $books = $_SESSION['books']['items'];
}

if (isset($_POST['submit']) && isset($_SESSION['valid']) && $_SESSION['valid'] == true) {


    // escape sql chars
    $user = $_SESSION['username'];
    $title = mysqli_real_escape_string($conn, $_POST['book_title']);
    $author = mysqli_real_escape_string($conn, $_POST['book_author']);
    $thumbnail = mysqli_real_escape_string($conn, $_POST['book_image']);


    //create sql
    $sql = "INSERT INTO books(user, title, author, thumbnail) VALUES('$user', '$title', '$author', '$thumbnail')";
    if (mysqli_query($conn, $sql)) {
        //
        header('Location: dashboard.php');
    } else {
        echo 'query error : ' . mysqli_error($conn);
    }
} // end POST check

?>
<!DOCTYPE html>
<html lang="en">
<style>
    .card-img-top {
        width: 200px;
        height: auto;
        object-fit: fill;
    }
</style>
<section>
    <div class="container">
        <div class="row">
            <?php foreach ($books as $book) : ?>

                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="card m-2 " style="width: 18rem;">
                        <img src="<?php
                                    $book_img = '';
                                    if (isset($book['volumeInfo']['imageLinks']['thumbnail'])) {
                                        echo htmlspecialchars($book['volumeInfo']['imageLinks']['thumbnail']);
                                        $book_img = htmlspecialchars($book['volumeInfo']['imageLinks']['thumbnail']);
                                    } else {
                                        echo htmlspecialchars('img/icons/no_image.png');
                                        $book_img = htmlspecialchars('img/icons/no_image.png');
                                    }

                                    ?>" class="img-thumbnail card-img-top" alt=" <?php echo $book['volumeInfo']['title']; ?>">
                        <form action="books.php" method="POST">
                            <input type="hidden" name="book_title" value="<?php echo $book['volumeInfo']['title']; ?>" />
                            <input type="hidden" name="book_image" value="<?php echo $book_img ?>" />

                            <input type="hidden" name="book_author" value="<?php echo htmlspecialchars($book['volumeInfo']['authors'][0]); ?>" />



                            <button type="submit" name="submit" class="btn btn-primary btn-sm">Add</button>
                        </form>

                        <h6 class="card-title"><?php echo $book['volumeInfo']['title']; ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($book['volumeInfo']['authors'][0]); ?></p>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

</section><?php include('templates/footer.php'); ?>

</html>