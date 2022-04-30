<form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Edit Category</label>


                                <?php //Edit and show in inputbox
                                if (isset($_GET['edit'])) {
                                    $cat_id = $_GET['edit'];
                                    $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
                                    $select_categories_id = mysqli_query($connection, $query);
                                    while ($row = mysqli_fetch_assoc($select_categories_id)) {
                                        $cat_title = $row['cat_title'];
                                        $cat_id = $row['cat_id'];
                                ?>
                                        <input value="<?php if (isset($cat_title)) {
                                                            echo $cat_title;
                                                        }  ?>" type="text" class="form-control" name="cat_title">


                                <?php
                                    }
                                }
                                ?>

                                <?php //Update Query
                                if (isset($_POST['update_category'])) {
                                    $the_cat_title = $_POST['cat_title'];
                                    $query2 = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$edit_cat_id}";
                                    $update_query = mysqli_query($connection, $query2);
                                    // header("Location: categories.php");
                                    if (!$update_query) {
                                        die('QUERY FAILED' . mysqli_error($connection));
                                    }
                                }
                                ?>



                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_category" value="Edit Category">
                            </div>
                        </form>