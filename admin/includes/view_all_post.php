<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $buld_options = $_POST['buld_options'];
        switch ($buld_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$buld_options}' WHERE post_id=$postValueId";
                $update_to_published_status = mysqli_query($connection, $query);
                comfirm($update_to_published_status);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$buld_options}' WHERE post_id=$postValueId";
                $update_to_draft_status = mysqli_query($connection, $query);
                comfirm($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id=$postValueId";
                $update_to_delete_status = mysqli_query($connection, $query);
                comfirm($update_to_delete_status);
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id=$postValueId";
                $select_post_query = mysqli_query($connection, $query);
                comfirm($select_post_query);
                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                }
                $query = "INSERT INTO posts(post_title,post_category_id,post_date,post_author,post_status,post_image,post_tags,post_content) ";
                $query .= "VALUES('{$post_title}',{$post_category_id},now(),'{$post_author}','{$post_status}','{$post_image}','{$post_tags}','{$post_content}')";
                $copy_query = mysqli_query($connection, $query);

                if (!$copy_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }

                break;

            default:
                # code...
                break;
        }
    }
}
?>

<form action="" method="post">

    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="buld_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4 ">
            <div style="margin-bottom: 18px;">
                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                <a class=" btn btn-primary" href="posts.php?source=add_post">Add New</a>
            </div>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Post Id</th>
                <th>Users</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>View Count</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $query = "SELECT * FROM posts ORDER BY post_id DESC ";
            $select_posts = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_title = $row['post_title'];
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_user = $row['post_user'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_view_count = $row['post_view_count'];

                echo "<tr>";
            ?>

                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
            <?php

                echo "<td class='text-center'>$post_id</td>";
                if (!empty($post_author)) {
                    echo "<td class='text-center'>$post_author</td>";
                }else if(isset($post_user) || !empty($post_user)){
                    echo "<td class='text-center'>$post_user</td>";
                }
                echo "<td class='text-center'>$post_title</td>";


                $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                $select_categories_id = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_title = $row['cat_title'];


                    echo "<td class='text-center'>$cat_title</td>";
                }







                echo "<td class='text-center'>$post_status</td>";
                echo "<td><img width='100' src='../images/$post_image' alt='img'></td>";
                echo "<td class='text-center'>$post_tags</td>";


                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);


                $row = mysqli_fetch_assoc($send_comment_query);
                if (!empty($row)) {
                    $the_comment_id = $row["comment_id"];
                    $count_comment = mysqli_num_rows($send_comment_query);
                    echo "<td class='text-center'><a href='post_comments.php?id=$post_id'> $count_comment</a></td>";
                } else {
                    $count_comments = 0;
                    echo "<td class='text-center'><a href=''> $count_comments</a></td>";
                }






                echo "<td class='text-center'>$post_date</td>";

                echo "<td class='text-center'>
                <a href='../post.php?p_id=$post_id' style='color: blue !important;'>View Post</a></td>";

                echo "<td class='text-center'>
            <a href='posts.php?source=edit_post&p_id=$post_id' style='color: blue !important;'>Edit</a></td>";
                echo "<td class='text-center'>
            <a onClick=\"javascript: return confirm('ARE YOU SURE YOU WANT TO DELETE') \" href='posts.php?delete=$post_id' style='color: tomato !important;'>Delete</a></td>";

                echo "<td>{$post_view_count} <br> <a href='posts.php?reset={$post_id}'>Reset View Count</a></td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table>
</form>

<?php
if (isset($_GET['delete'])) {
    $del_post_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = {$del_post_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}

if (isset($_GET['reset'])) {
    $post_id = $_GET['reset'];

    $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $post_id) . " ";
    $reset_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}
?>