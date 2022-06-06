<!-- <?php ob_start(); ?> -->

<?php include  "./functions.php"; ?>
<?php
include "includes/db.php";
?>
<?php

include "includes/header.php";

?>


<!-- Navigation -->
<?php

include "includes/nav.php";

?>



<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">





            <?php

            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];

                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    $view_query = "UPDATE  posts SET post_view_count = post_view_count + 1 WHERE post_id = $the_post_id";
                    $select_view_query_query = mysqli_query($connection, $view_query);
                    if (!$select_view_query_query) {
                        die("query failed");
                    }
                }


                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                $select_all_posts_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];

            ?>



                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $the_post_id; ?>"><?php echo $post_user ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content ?></p>


                    <hr>

            <?php
                }
            } else {
                header("Location: index.php");
            }
            ?>

            <!-- Comments Form -->

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['create_comment'])) {

                    $the_post_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    $comment_status = 'dref';

                    if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                        $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,
                    comment_content,comment_status,comment_date)";
                        $query .= "VALUE({$the_post_id},'{$comment_author}','{$comment_email}',
                    '{$comment_content}','{$comment_status}',now())";

                        $create_comments_query = mysqli_query($connection, $query);

                        if (!$create_comments_query) {
                            die('QUERY FAILED' . mysqli_error($connection));
                        }

                        // $query = "UPDATE posts SET post_comment_count = post_comment_count+1 ";
                        // $query .= "WHERE post_id = $the_post_id";
                        // $update_comment_count = mysqli_query($connection, $query);
                        // if (!$update_comment_count) {
                        //     die('QUERY FAILED' . mysqli_error($connection));
                        // }

                        // redirect("post.php?p_id=$the_post_id");
                        
                    } else {
                        echo "<script>alert('Fileds cannot be empty')</script>";
                    }
                   
                }
               
               
            }
            ?>

            <!-- Comment -->
            <?php

            $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id ";
            $query .= "AND  comment_status = 'approved'";
            $query .= "ORDER BY comment_id DESC";
            $select_comments = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_comments)) {

                $comment_author = $row['comment_author'];
                $comment_email = $row['comment_email'];
                $comment_content = $row['comment_content'];
                $comment_date = $row['comment_date'];
            ?>
                <div class="media mb-2">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="https://bulma.io/images/placeholders/64x64.png" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <p><?php echo $comment_content; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>



            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" method="post" action="">
                    <input type="hidden" value="<?php isset($the_post_id) ?? null ?>">
                    <div class="form-group">
                        <label for="comment_author">Name</label>
                        <input class="form-control" type="text" name="comment_author" name="comment_author" require>
                    </div>
                    <div class="form-group">
                        <label for="comment_email">Email</label>
                        <input class="form-control" type="email" name="comment_email" name="comment_email" require>
                    </div>
                    <div class="form-group">
                        <label for="comment_content">Comment</label>
                        <textarea class="form-control" rows="3" id='comment_content' name="comment_content" require></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>



            <!-- Posted Comments -->












        </div>

        <!-- Blog Sidebar Widgets Column -->

        <?php
        include "includes/sidebar.php";
        ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php
    include "includes/footer.php";
    ?>