<?php
if (isset($_POST['create_post'])) {
    $post_title = escape($_POST['post_title']);
    $post_user = escape($_POST['post_user']);
    $post_category_id = escape($_POST['post_category_id']);
    $post_status = escape($_POST['post_status']);

    $post_image = escape($_FILES['image']['name']);
    $post_image_temp = escape($_FILES['image']['tmp_name']);

    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);
    $post_date = escape(date('d-m-y'));
     $post_comment_count = escape(0);

    move_uploaded_file($post_image_temp,"../images/$post_image");

    $query = "INSERT INTO posts(post_category_id,post_title,post_user,
    post_date,post_image,post_content,post_tags,post_status)";
    $query .= "VALUE({$post_category_id},'{$post_title}','{$post_user}',now(),
    '{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

    $create_post_query = mysqli_query($connection,$query);

    comfirm($create_post_query);
    $p_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>Post Created. <a  href='../post.php?p_id=$p_id'> View Post </a>or<a  href='posts.php'>Edit More Post </a></p>";

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">post title</label>
        <input type="text" class="form-control" name="post_title" />
    </div>

    <div class="form-group">
        <label for="">Category</label>
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
        <label for="users">Users</label>
        <select name="post_user" id="users">
            <?php
            $query = "SELECT * FROM users  ";
            $select_users = mysqli_query($connection, $query);

            comfirm($select_users);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $username = $row['username'];
                $user_id = $row['user_id'];

                echo "<option value='{$username}'>$username</option>";
            }

            ?>
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="post_author">post author</label>
        <input type="text" class="form-control" name="post_author" />
    </div> -->

    <div class="form-group">
    
        <select name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>

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
        <label for="summernote">post content</label>
        <textarea class="form-control" name="post_content" id="summernote" rows="10" cols="30"></textarea>
    </div>

    <div class="form-group row text-center ">
        <input class="btn btn-primary " type="submit" name="create_post" value="Publish Post">
    </div>
</form>

