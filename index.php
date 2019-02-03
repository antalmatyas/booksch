<?php
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_NAME = "book";
    $connection = mysqli_connect($DB_HOST,$DB_USER, $DB_PASS, $DB_NAME);
?>
<?php
    if(isset($_POST['submit'])){
        foreach($_POST as $key => $value){
            $wid = substr($key, 0, strpos($key, '/'));
            $type = substr($key, strpos($key, '/')+1, 1);
            if($type == "a"){
                $update_query = "UPDATE read_books SET book_author='{$value}' WHERE week_id=$wid;";
            }
            else if($type == "t"){
                $update_query = "UPDATE read_books SET book_title='{$value}' WHERE week_id=$wid;";
            }
            $update = mysqli_query($connection, $update_query);
                if(!$update){
                    die("Oy ".mysqli_error($connection));
                }
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>dolog</title>
</head>
<body>
    <form action="index.php" method="post">
        <?php
            $down_q = "SELECT * FROM read_books";
            $down = mysqli_query($connection, $down_q);
            if(!$down){
                die("Something's fishy " . mysqli_error($connection));
            }
            while($row = mysqli_fetch_assoc($down)){
                $week = $row['week_id'];
                $author = $row['book_author'];
                $title = $row['book_title'];
                // insert / as a delimiter
                $a = $week.'/'."a";
                $t = $week.'/'."t";
            echo("<div class=\"form-group\"><label>WEEK $week </label>
                <input type=\"text\" class=\"form-control\" name=\"$a\" value=\"$author\">
                <input type=\"text\" class=\"form-control\" name=\"$t\" value=\"$title\">"
            );
            }
        ?>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="UPDATE">
        </div>
    </form>
</body>
</html>