<div class="col-md-4">


    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form method="post" action="search.php">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Blog Login -->
    <div class="well">
        <?php if (isset($_SESSION['user_role'])): ?>
            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="admin/includes/logout.php" class="btn btn-success">Logout</a>
        <?php else: ?>
            <h4>Login</h4>
            <form method="post" action="includes/login.php">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button name="login" class="btn btn-primary" type="submit">
                            Login
                        </button>
                    </span>
                </div>
            </form>
            <!-- /.input-group -->
        <?php endif ?>
    </div>
    

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                    <?php 

                    $query = "SELECT * FROM categories";
                    $select_categories_sidebar = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                        echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a>
                        </li>";
                    }

                    ?>
                    
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include 'includes/widget.php'; ?>

</div>