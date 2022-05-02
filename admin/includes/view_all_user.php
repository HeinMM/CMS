<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Email</th>
            <th>UserImage</th>
            <th>Role</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $query = "SELECT * FROM users ";
        $select_users = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_users)) {

            $user_id = $row['user_id'];
            $username = $row['username'];
            // $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];

            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>";

            echo "<td class='text-center'>$user_id</td>";
            echo "<td class='text-center'>$username</td>";
            echo "<td class='text-center'>$user_firstname</td>";


            // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
            // $select_categories_id = mysqli_query($connection, $query);
            // while ($row = mysqli_fetch_assoc($select_categories_id)) {
            //     $cat_title = $row['cat_title'];


            //     echo "<td class='text-center'>$cat_title</td>";


            // }



            echo "<td class='text-center'>$user_lastname</td>";

            echo "<td class='text-center'>$user_email</td>";



           
            echo "<td class='text-center'>$user_image</td>";
            echo "<td class='text-center'>$user_role</td>";

            echo "<td class='text-center'>  
            <a href='users.php?change_to_admin=$user_id' style='color: blue !important;'>Admin</a></td>";

            echo "<td class='text-center'>  
            <a href='users.php?change_to_sub=$user_id' style='color: blue !important;'>Subscriber</a></td>";

        

            echo "<td class='text-center'>  
            <a href='users.php?delete=$user_id' style='color: tomato !important;'>Delete</a></td>";
           
           

            echo "</tr>";
        }

        ?>

    </tbody>
</table>

<?php

if (isset($_GET['change_to_admin'])) {
    $the_user_id = $_GET['change_to_admin'];

    $query = "UPDATE users SET user_role = 'admin'";
    $query .= "WHERE user_id=$the_user_id";
    $change_to_admin_query = mysqli_query($connection, $query);
    if (!$change_to_admin_query) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
    header("Location: users.php");
}

if (isset($_GET['change_to_sub'])) {
    $the_user_id = $_GET['change_to_sub'];

    $query = "UPDATE users SET user_role = 'subscriber'";
    $query .= "WHERE user_id=$the_user_id";
    $change_to_sub_query = mysqli_query($connection, $query);
    if (!$change_to_sub_query) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
    header("Location: users.php");
}




if (isset($_GET['delete'])) {
    $the_user_id = $_GET['delete'];

    $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
    $delete_user_query = mysqli_query($connection, $query);
    if (!$delete_user_query) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
    header("Location: users.php");
}
?>

