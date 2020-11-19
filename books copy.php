<?php
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
    img {
        width: 100%;
        height: auto;
    }
</style>
<section>
    <div class="container">
        <div class="row"><?php foreach ($books as $book) : ?><div class="col-6 col-md-4">
                    <div class="card" style="width: 12rem;  "><img src="<?php
                                                                        $book_img = '';
                                                                        if (isset($book['volumeInfo']['imageLinks']['thumbnail'])) {
                                                                            echo htmlspecialchars($book['volumeInfo']['imageLinks']['thumbnail']);
                                                                            $book_img = htmlspecialchars($book['volumeInfo']['imageLinks']['thumbnail']);
                                                                        } else {
                                                                            echo htmlspecialchars('img/icons/no_image.png');
                                                                            $book_img = htmlspecialchars('img/icons/no_image.png');
                                                                        }

                                                                        ?>" class="card-img-top img-thumbnail " alt=" ...">
                        <div class="card-body">
                            <form action="books.php" method="POST">
                                <input type="hidden" name="book_title" value="<?php echo $book['volumeInfo']['title']; ?>" />
                                <input type="hidden" name="book_image" value="<?php echo $book_img ?>" />

                                <input type="hidden" name="book_author" value="<?php echo htmlspecialchars($book['volumeInfo']['authors'][0]); ?>" />



                                <button type="submit" name="submit" class="btn btn-primary btn-sm">Add</button>
                            </form>

                            <p class="card-text font-weight-bold"><?php echo $book['volumeInfo']['title']; ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($book['volumeInfo']['authors'][0]); ?></p>

                        </div>
                    </div>
                </div><?php endforeach; ?></div>
    </div>
</section><?php include('templates/footer.php'); ?>

</html>