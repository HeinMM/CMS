<?php
if (isset($_POST['create_post'])) {
    $post_title = $_POST['post_title'];
    $post_author = $_POST['post_author'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
     $post_comment_count = 0;

    move_uploaded_file($post_image_temp,"../images/$post_image");

    $query = "INSERT INTO posts(post_category_id,post_title,post_author,
    post_date,post_image,post_content,post_tags,post_status)";
    $query .= "VALUE({$post_category_id},'{$post_title}','{$post_author}',now(),
    '{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

    $create_post_query = mysqli_query($connection,$query);

    comfirm($create_post_query);

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">post title</label>
        <input type="text" class="form-control" name="post_title" />
    </div>

    <div class="form-group">
        <select name="post_category_id" id="post_category">
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
        <input type="text" class="form-control" name="post_author" />
    </div>

    <div class="form-group">
        <label for="post_status"> post status</label>
        <input type="text" class="form-control" name="post_status" />
    </div>

    <div class="form-group">
        <label for="post_image">post image</label>
        <input type="file" name="image" />
    </div>

    <div class="form-group">
        <label for="post_tags">post tags</label>
        <input type="text" class="form-control" name="post_tags" />
    </div>

    <div class="form-group">
        <label for="post_content">post content</label>
        <textarea class="form-control" name="post_content" id="" rows="10" cols="30"></textarea>
    </div>

    <div class="form-group row text-center ">
        <input class="btn btn-primary " type="submit" name="create_post" value="Publish Post">
    </div>
</form>