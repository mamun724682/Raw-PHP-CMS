<?php include 'includes/header.php'; ?>

<?php 

if (isset($_SESSION['username'])) {

    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username='{$username}' ";
    $select_user = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_user)) {
        $user_id = $row['user_id'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $username = $row['username'];
        $user_role = $row['user_role'];
        $user_email = $row['user_email'];
    }
}

if (isset($_POST['update_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_role = $_POST['user_role'];

    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];

    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    // Password encryption
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 10]);

    // move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "UPDATE users SET username='{$username}', user_password='{$user_password}', user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', user_email='{$user_email}', user_role='{$user_role}' WHERE username = '{$username}'";
    $update_user_query = mysqli_query($connection, $query);

    confirmQuery($update_user_query);
    header("Location: profile.php");
}

?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome To Admin
                        <small><?php echo $_SESSION['username'] ?></small>
                    </h1>


                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input type="text" value="<?php echo $user_firstname; ?>" name="user_firstname" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input type="text" value="<?php echo $user_lastname; ?>" name="user_lastname" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" value="<?php echo $username; ?>" name="username" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="user_role">User Role</label>
                            <select class="form-control" name="user_role">
                                <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
                                <?php 
                                if ($user_role == 'admin') {
                                    echo "<option value='subscriber'>Subscriber</option>";
                                } else {
                                    echo "<option value='admin'>Admin</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="text" value="<?php echo $user_email; ?>" name="user_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" name="user_password" class="form-control">
                        </div>

    <!-- <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" name="user_image">
    </div> -->

    <div class="form-group">
        <input type="submit" name="update_user" value="Update Profile" class="btn btn-primary">
    </div>
</form>
</div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>