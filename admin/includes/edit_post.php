<?php


if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
}
$query = "SELECT * FROM posts WHERE post_id = $p_id";
$select_posts_by_id = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_title = $row['post_title'];
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
}

if (isset($_POST['update_post'])) {
    
    $post_title = $_POST['post_title'];
    $post_author = $_POST['post_author'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];

    move_uploaded_file($post_image_temp,"../images/$post_image");

    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $p_id";
        $select_image = mysqli_query($connection,$query);
        while($row = mysqli_fetch_array($select_image)){
            $post_image = $row['post_image'];
        }
    }
    

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}',";
    $query .= "post_category_id = {$post_category_id},";
    $query .= "post_date = now(),";
    $query .= "post_author = '{$post_author}',";
    $query .= "post_status = '{$post_status}',";
    $query .= "post_tags = '{$post_tags}',";
    $query .= "post_content = '{$post_content}',";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$p_id}";
    
    $update_post = mysqli_query($connection, $query);

    if (!$update_post) {
        die('QUERY FAILED' . mysqli_error($connection));
    }else{
        header("Location: posts.php");
    }
}


?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">post title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>" />
    </div>

    <div class="form-group">
        <select name="post_category" id="post_category">
            <?php
            $query = "SELECT * FROM categories  ";
            $select_categories = mysqli_query($connection, $query);

            comfirm($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];

                echo "<option value='{$cat_id}'>$cat_title</option>";
            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">post author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>" />
    </div>

    <div class="form-group">
        <label for="post_status"> post status</label>
        <input type="text" class="form-control" name="post_status" value="<?php echo $post_status; ?>" />
    </div>

    <div class="form-group">
    <img src="../images/<?php echo $post_image;  ?>" alt="" width="100px">
  </div>

    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">post tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>" />
    </div>

    <div class="form-group">
        <label for="post_content">post content</label>
        <textarea class="form-control" name="post_content" id="" rows="10" cols="30"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group row text-center ">
        <input class="btn btn-primary " type="submit" name="update_post" value="Edit Post">
    </div>
</form>