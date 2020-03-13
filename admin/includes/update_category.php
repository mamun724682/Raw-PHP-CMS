<form action="" method="post"> 
    <div class="form-group">
        <label for="cat_title">Edit Category</label>
        <?php 

        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];
            $query = "SELECT * FROM categories WHERE cat_id=$cat_id";
            $select_category_id = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_category_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                ?>
                <input value="<?php if(isset($cat_title)) {echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">
                <?php }} ?>

                <?php 

                // Update Category
                if (isset($_POST['update_category'])) {
                    $the_cat_title = $_POST['cat_title'];

                    // Prepared statement
                    $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title= ? WHERE cat_id = ?");
                    mysqli_stmt_bind_param($stmt, 'si', $the_cat_title, $cat_id); //si = cat_title is string and cat_id is integer
                    mysqli_stmt_execute($stmt);

                    if (!$stmt) {
                        die('Query Failed' . mysqli_error($connection));
                    }

                    mysqli_stmt_close($stmt);

                    redirect("categories.php");
                }

                ?>


            </div>
            <div class="form-group">
                <input type="submit" name="update_category" value="Update Category" class="btn btn-info">
            </div>
        </form>