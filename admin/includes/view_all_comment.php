<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $query = "SELECT * FROM comments ";
        $select_comments = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_comments)) {

            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];

            $comment_status = $row['comment_status'];
            //in response to
            $comment_date = $row['comment_date'];

            echo "<tr>";

            echo "<td class='text-center'>$comment_id</td>";
            echo "<td class='text-center'>$comment_author</td>";
            echo "<td class='text-center'>$comment_content</td>";


            // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
            // $select_categories_id = mysqli_query($connection, $query);
            // while ($row = mysqli_fetch_assoc($select_categories_id)) {
            //     $cat_title = $row['cat_title'];


            //     echo "<td class='text-center'>$cat_title</td>";


            // }



            echo "<td class='text-center'>$comment_email</td>";

            echo "<td class='text-center'>$comment_status</td>";


                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                $select_post_id_query = mysqli_query($connection,$query);

                while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];

                    echo "<td class='text-center'><a href='../post.php?p_id=$post_id' style='color: blue !important;'  href=''>$post_title</a></td>";
                }


           
            echo "<td class='text-center'>$comment_date</td>";


            echo "<td class='text-center'>  
            <a href='comments.php?approve=$comment_id' style='color: blue !important;'>Approve</a></td>";
            echo "<td class='text-center'>
            <a href='comments.php?unapprove=$comment_id' style='color: tomato !important;'>UnApprove</a></td>";


            echo "<td class='text-center'>
            <a href='comments.php?delete=$comment_id' style='color: tomato !important;'>Delete</a></td>";

            echo "</tr>";
        }

        ?>

    </tbody>
</table>

<?php

if (isset($_GET['approve'])) {
    $the_comment_id = $_GET['approve'];

    $query = "UPDATE comments SET comment_status = 'approved'";
    $query .= "WHERE comment_id=$the_comment_id";
    $approve_comment_query = mysqli_query($connection, $query);
    if (!$approve_comment_query) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
    header("Location: comments.php");
}

if (isset($_GET['unapprove'])) {
    $the_comment_id = $_GET['unapprove'];

    $query = "UPDATE comments SET comment_status = 'unapproved'";
    $query .= "WHERE comment_id=$the_comment_id";
    $unapprove_comment_query = mysqli_query($connection, $query);
    if (!$unapprove_comment_query) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
    header("Location: comments.php");
}




if (isset($_GET['delete'])) {
    $the_comment_id = $_GET['delete'];

    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
    $delete_query = mysqli_query($connection, $query);
    if (!$delete_query) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
    header("Location: comments.php");
}
?>

