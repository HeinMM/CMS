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


            if (isset($_POST['submit'])) {
                $search = $_POST['search'];

                $query = "SELECT * FROM posts WHERE post_tags LIKE  '%$search%' ";
                $search_query = mysqli_query($connection, $query);
                if (!$search_query) {
                    die("Query Failed" . mysqli_error($connection));
                }
                $count = mysqli_num_rows($search_query);
                if ($count == 0) {
                    echo "<h1>NO RESULT</h1>";
                } else {
                    echo "some result";
                }
            }
            ///pager calc start
            $per_page = 4;
            if (isset($_GET['page'])) {
               
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }
            ///pager calc end

            //////pager query start///////
            $post_query_count = "SELECT * FROM posts";
            $find_cound = mysqli_query($connection, $post_query_count);
            $count = mysqli_num_rows($find_cound);

            $count = ceil($count / $per_page);
            //////pager query end///////

            $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1,$per_page ";
            $select_all_posts_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 50) . ".....";
                $post_status = $row['post_status'];

                if ($post_status != 'published') {
                } else {
            ?>



                    <!--  Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
            <?php
                }
            }
            ?>





            <!-- Pager -->
            <ul class="pager">



                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>


                <?php
                for ($i = 1; $i <= $count; $i++) {
                    if ($i == $page) {
                ?>
                        <li><a class="active_link" href='index.php?page=<?php echo $i ?>'><?php echo $i; ?></a></li>
                    <?php
                    }

                    ?>
                    <li><a href='index.php?page=<?php echo $i ?>'><?php echo $i; ?></a></li>
                <?php
                }
                ?>


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