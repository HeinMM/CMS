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




            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            <?php

            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];
            }


            $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
            $select_all_posts_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];

            ?>



                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            <?php

            }
            ?>

            <!-- Comments Form -->

            <?php
            if (isset($_POST['create_comment'])) {
                $the_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];
                $comment_status = 'approved';

                $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,
    comment_content,comment_status,comment_date)";
                $query .= "VALUE({$the_post_id},'{$comment_author}','{$comment_email}',
    '{$comment_content}','{$comment_status}',now())";

                $create_comments_query = mysqli_query($connection, $query);

                if (!$create_comments_query) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }

                $query = "UPDATE posts SET post_comment_count = post_comment_count+1 ";
                $query .= "WHERE post_id = $the_post_id";
                $update_comment_count = mysqli_query($connection,$query);
                if (!$update_comment_count) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }
               
            }
            ?>





            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" method="post" action="">
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

            <hr>

            <!-- Posted Comments -->

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
                <div class="media">
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







            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

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