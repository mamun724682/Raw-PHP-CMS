<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'admin/functions.php'; ?>

<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-8">

            <!-- Blog Post -->
            <?php 

            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];

                // Post Views Count 
                $view_query = "UPDATE posts SET post_views_count = post_views_count+1 WHERE post_id=$the_post_id";
                $send_query = mysqli_query($connection, $view_query);
                if (!$send_query) {
                    die("Query Failed " . mysqli_error($connection));
                }

                if (is_admin($_SESSION['user_role'])) {
                    $query = "SELECT * FROM posts WHERE post_id={$the_post_id}";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id={$the_post_id} AND post_status='Published'";
                }                
                $select_post_query = mysqli_query($connection, $query);

                if (mysqli_num_rows($select_post_query) < 1) {
                    echo "<h2 class='text-center'>No post</h2>";
                } else {

                    while ($row = mysqli_fetch_assoc($select_post_query)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];            

                        ?>

                        <!-- Title -->
                        <h1><?php echo $post_title; ?></h1>

                        <!-- Author -->
                        <p class="lead">
                            by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $the_post_id; ?>"><?php echo $post_author; ?></a>
                        </p>

                        <hr>

                        <!-- Date/Time -->
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>

                        <hr>

                        <!-- Preview Image -->
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">

                        <hr>

                        <!-- Post Content -->
                        <p class="lead"><?php echo $post_content; ?></p>

                        <hr>
                        <?php
                    }


                    ?>

                    <!-- Blog Comments -->

                    <?php 

                    if (isset($_POST['create_comment'])) {

                        $comment_post_id = $_GET['p_id'];

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ({$comment_post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";
                            $create_comment_query = mysqli_query($connection, $query);

                            if (!$create_comment_query) {
                                die("Query Failed " . mysqli_error($connection));
                            }

                // Update comment count in Posts Table
                            $query = "UPDATE posts SET post_comment_count = post_comment_count+1 WHERE post_id = $comment_post_id";
                            $post_comment_count = mysqli_query($connection, $query);
                        } else {
                            echo "<script>alert('Field cannot be empty!') </script>";
                        }

                    }

                    ?>

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form action="" method="post" role="form">
                            <div class="form-group">
                                <input type="text" name="comment_author" placeholder="Author" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="comment_email" placeholder="Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="comment_content" rows="3" placeholder="Your comment"></textarea>
                            </div>
                            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->

                    <!-- Comment -->
                    <?php 

                    $query = "SELECT * FROM comments WHERE comment_post_id={$the_post_id} AND comment_status='Approved' ORDER BY comment_id DESC";
            // $query .= "AND comment_status='Approved' ORDER BY comment_id DESC";
                    $select_comment_query = mysqli_query($connection, $query);
                    if (!$select_comment_query) {
                        die("Query Failed " . mysqli_error($connection));
                    }
                    while ($row = mysqli_fetch_assoc($select_comment_query)) {
                        $comment_author = $row['comment_author'];
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        ?>
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>
                        <?php 
                    }
                }
            } else {
                header("Location: index.php");
            }
            ?>



        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'; ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>