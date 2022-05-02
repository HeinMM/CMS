<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $query = "SELECT * FROM posts ";
        $select_posts = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_posts)) {
            $post_title = $row['post_title'];
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];

            echo "<tr>";

            echo "<td class='text-center'>$post_id</td>";
            echo "<td class='text-center'>$post_author</td>";
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



            echo "<td class='text-center'>$post_comment_count</td>";
            echo "<td class='text-center'>$post_date</td>";

            echo "<td class='text-center'>
            <a href='posts.php?source=edit_post&p_id=$post_id' style='color: blue !important;'>Edit</a></td>";
            echo "<td class='text-center'>
            <a href='posts.php?delete=$post_id' style='color: tomato !important;'>Delete</a></td>";

            echo "</tr>";
        }

        ?>

    </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
    $del_post_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = {$del_post_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}
?>