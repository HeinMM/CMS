<?php include "includes/admin_header.php" ?>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">CMS Admin</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href="../index.php">HOME SITE</a></li>


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo  $_SESSION['username'];
                    }
                ?>
                
                <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>

                    <li class="divider"></li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>


                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="posts_dropdown" class="collapse">
                        <li>
                            <a href="posts.php">View All Posts</a>
                        </li>
                        <li>
                            <a href="./posts.php?source=add_post">Add Post</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                </li>

                <li class="">
                    <a href=""><i class="fa fa-fw fa-file"></i> Comments</a>
                </li>
                <li>
                    <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> Users</a>
                </li>

                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Profile</a>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin
                        <small>Author</small>
                    </h1>
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
        $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection,$_GET['id']);
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
            <a href='post_comments.php?delete=$comment_id&id=".$_GET['id']."' style='color: tomato !important;'>Delete</a></td>";

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
    header("Location: post_comments.php?id=". $_GET['id'] ."");
}
?>

<style>
        a {
            color: white !important;
        }
    </style>

    <?php
    include "includes/admin_footer.php";
    ?>

