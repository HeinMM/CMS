<?php

function comfirm($result){
    global $connection;
    if (!$result) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
}

function insert_catergories(){
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

function findAllCategories(){
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

function deleteCategory(){
    global $connection;
    if (isset($_GET['delete'])) {
        $del_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$del_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}


?>