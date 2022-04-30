<?php include "includes/admin_header.php" ?>

<div id="wrapper">

<?php
    if ($connection) {
        echo "hit";
    }
?>

    <!-- Navigation -->
    <?php
        include "includes/admin_nav.php";
    ?>

    <?php
    include "includes/admin_wrapper.php";
    ?>
    <!-- /#page-wrapper -->

    <?php
    include "includes/admin_footer.php";
    ?>