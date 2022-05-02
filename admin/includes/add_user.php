<?php
if (isset($_POST['add_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_role = $_POST['user_role'];


    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

   

    $query = "INSERT INTO users(user_firstname,user_lastname,username,
    user_role,user_email,user_password) ";
    $query .= " VALUE('{$user_firstname}','{$user_lastname}','{$username}',
    '{$user_role}','{$user_email}','{$user_password}')";

    $create_user_query = mysqli_query($connection,$query);

    comfirm($create_user_query);

}
?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
        <label for="user_firstname"> First Name</label>
        <input type="text" class="form-control" name="user_firstname" />
    </div>

    <div class="form-group">
        <label for="user_lastname"> Last Name</label>
        <input type="text" class="form-control" name="user_lastname" />
    </div>

    <div class="form-group">
        <label for="username">User Name</label>
        <input type="text" class="form-control" name="username" />
    </div>

    <div class="form-group">
        <select name="user_role" id="user_role">
        <option value="subscriber" >Select Options</option>
            <option value="admin" >Admin</option>
            <option value="subscriber" >Subscriber</option>
        </select>
    </div>

    

    <div class="form-group">
        <label for="user_email"> Email</label>
        <input type="email" name="user_email" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="user_password"> Password</label>
        <input type="password" class="form-control" name="user_password" />
    </div>


    <div class="form-group row text-center ">
        <input class="btn btn-primary " type="submit" name="add_user" value="Add User">
    </div>
</form>