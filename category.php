<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'admin/functions.php'; ?>

<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

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

            if (isset($_GET['category'])) {
                $the_cat_id = $_GET['category'];                

                // Prepared statement
                if (is_admin($_SESSION['username'])) {
                    $stm1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");
                } else {
                    $stm2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");

                    $published = 'Published';
                }

                if (isset($stm1)) {
                    mysqli_stmt_bind_param($stm1, "i", $the_cat_id);
                    mysqli_stmt_execute($stm1);
                    mysqli_stmt_bind_result($stm1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                    $stmt = $stm1;
                } else {
                    mysqli_stmt_bind_param($stm2, "is", $the_cat_id, $published);
                    mysqli_stmt_execute($stm2);
                    mysqli_stmt_bind_result($stm2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                    $stmt = $stm2;                    
                }

                if (mysqli_stmt_num_rows($stmt) === 0) {
                    echo "<h2 class='text-center'>No post available</h2>";
                }
                while (mysqli_stmt_fetch($stmt)):
                    
                    ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" style="width:900px;height:300px;" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

                    <?php endwhile; mysqli_stmt_close($stmt); } else {
                        header("Location: index.php");
                    } ?>



                </div>

                <!-- Blog Sidebar Widgets Column -->
                <?php include 'includes/sidebar.php'; ?>

            </div>
            <!-- /.row -->

            <hr>

            <!-- Footer -->
            <?php include 'includes/footer.php'; ?>