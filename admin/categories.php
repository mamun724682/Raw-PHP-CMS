<?php include 'includes/header.php'; ?>

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
                        <small>Author</small>
                    </h1>

                    <div class="col-xs-6">

                        <!-- Add Category -->
                        <?php insert_categories(); ?>


                        <form action="categories.php" method="post">
                            <div class="form-group">
                                <label for="cat_title">Category</label>
                                <input type="text" name="cat_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                            </div>
                        </form>
                        
                        <!-- Edit Form -->
                        <?php 

                        if (isset($_GET['edit'])) {
                            $cat_id = $_GET['edit'];

                            include 'includes/update_category.php';
                        }
                        ?>




                    </div>
                    <div class="col-xs-6">

                        <table class="table table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th scope="col">Id</th>
                              <th scope="col">Category Title</th>
                              <th scope="col">Edit</th>
                              <th scope="col">Delete</th>
                          </tr>
                      </thead>
                      <tbody>
                         <!-- Read Categories -->
                         <?php findAllCategories(); ?>

                         <!-- Delete Category -->                    
                         <?php deleteCategories(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>