<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    // $user_firstname = $_POST['user_firstname'];
    // $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_role = 'subscriber';


    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    if (!empty($username) && !empty($user_email) && !empty($user_password)) {
        $username = mysqli_real_escape_string($connection, $username);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $user_password = mysqli_real_escape_string($connection, $user_password);

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));






        $query = "INSERT INTO users(username,
            user_role,user_email,user_password) ";
        $query .= " VALUE('{$username}',
            '{$user_role}','{$user_email}','{$user_password}')";

        $register_user_query = mysqli_query($connection, $query);

        if (!$register_user_query) {
            die('QUERY FAILED' . mysqli_error($connection));
        }
        $message = "Your Registration has been submitted";
    } else {
        $message = 'Field cannot be empty';
    }
} else {
    $message = "";
}
?>

<!-- Navigation -->
<?php include "includes/nav.php"; ?>


<!-- Page Content -->
<div class="container ">

    <section id="login ">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <h6 class="text-center bg-warning"><?php echo $message  ?></h6>
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="user_email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="user_password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>