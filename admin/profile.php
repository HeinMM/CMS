<?php include "includes/admin_header.php" ?>

<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];

        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}
?>

<?php
if (isset($_POST['update_profile'])) {
    $user_firstname = $_POST['user_firstname'];
     $user_lastname = $_POST['user_lastname'];
     $user_role = $_POST['user_role'];

     $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}',";
    $query .= "user_lastname = '{$user_lastname}',";
    $query .= "user_role = '{$user_role}',";
    $query .= "username = '{$username}',";
    $query .= "user_email = '{$user_email}',";
    $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE username = '{$username}'";
    
    $update_profile = mysqli_query($connection, $query);

    if (!$update_profile) {
        die('QUERY FAILED' . mysqli_error($connection));
        header("Location: profile.php");
    }
}
?>

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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>

                    <li class="divider"></li>
                    <li>
                        <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
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
                    <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Comments</a>
                </li>
                <li>
                    <a href="users.php"><i class="fa fa-fw fa-dashboard"></i> Users</a>
                </li>

                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="users.php">View All Users</a>
                        </li>
                        <li>
                            <a href="./users.php?source=add_user">Add User</a>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="profile.php"><i class="fa fa-fw fa-file"></i> Profile</a>
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
                        <small><?php echo $_SESSION['username'] ?></small>
                    </h1>

                    <!-- form -->
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="user_firstname"> First Name</label>
                            <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="user_lastname"> Last Name</label>
                            <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname ?>" />
                        </div>

                        <div class="form-group">
                            <label for="username">User Name</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username ?>" />
                        </div>

                        <div class="form-group">
                            <select name="user_role" id="user_role">
                                <?php
                                echo "<option value='$user_role'>$user_role</option>";
                                echo "<option value='subscriber'>Subscriber</option>";
                                ?>

                            </select>
                        </div>



                        <div class="form-group">
                            <label for="user_email"> Email</label>
                            <input type="email" name="user_email" class="form-control" value="<?php echo $user_email ?>" />
                        </div>

                        <div class="form-group">
                            <label for="user_password"> Password</label>
                            <input type="password" class="form-control" name="user_password" value="<?php echo $user_password ?>" />
                        </div>


                        <div class="form-group row text-center ">
                            <input class="btn btn-primary " type="submit" name="update_profile" value="UPDATE PROFILE">
                        </div>
                    </form>
                    <!-- form end -->

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <style>
        a {
            color: white !important;
        }
    </style>

    <?php
    include "includes/admin_footer.php";
    ?>