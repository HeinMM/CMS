<?php

function escape($string){
    global $connection;
  return  mysqli_real_escape_string($connection,trim($string));
}

function comfirm($result)
{
    global $connection;
    if (!$result) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
}

function insert_catergories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "<p class='text-danger'>This field should not be empty</p>";
        } else {
            $query = "INSERT INTO categories(cat_title)";
            $query .= "VALUE('{$cat_title}')";

            $create_category_query = mysqli_query($connection, $query);
            header("Location: categories.php");

            if (!$create_category_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            } else {
            }
        }
    }
}

function findAllCategories()
{
    global $connection;
    $query = "SELECT * FROM categories ";
    $select_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];

        echo "<tr>
<td>$cat_id</td>
<td>$cat_title</td>

<td>
<div class='btn btn-danger '>
<a  href='categories.php?delete={$cat_id}'> Delete  </a>
</div> 
<div class='btn btn-warning '>
<a  href='categories.php?edit={$cat_id}'> Edit  </a>
</div> 
</td>
</tr>";
    }
}

function deleteCategory()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $del_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$del_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function users_online()
{
    if (isset($_GET['onlineusers'])) {
            
        global $connection;

        if (!$connection) {
            session_start();

            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session,time) VALUES('$session','$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
            $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
            echo $count_user = mysqli_num_rows($user_online_query);
        }
    }else{
        echo 'onlineusers not set';
    }
}

users_online();