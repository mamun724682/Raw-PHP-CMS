<?php 

if (isset($_GET['p_id'])) {
	$the_post_id = $_GET['p_id'];
}
$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_post_by_id = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_post_by_id)) {
	$post_id = $row['post_id'];
	$post_author = $row['post_author'];
	$post_title = $row['post_title'];
	$post_category_id = $row['post_category_id'];
	$post_status = $row['post_status'];
	$post_image = $row['post_image'];
	$post_content = $row['post_content'];
	$post_tags = $row['post_tags'];
	$post_comment_count = $row['post_comment_count'];
	$post_date = $row['post_date'];
}

if (isset($_POST['update_post'])) {

	$post_title = $_POST['title'];
	$post_author = $_POST['author'];
	$post_category_id = $_POST['post_category_id'];
	$post_status = $_POST['post_status'];

	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];

	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_date = date('d-m-y');

	move_uploaded_file($post_image_temp, "../images/$post_image");

	if (empty($post_image)) {
		$query = "SELECT * FROM posts WHERE post_id=$the_post_id";
		$select_image = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_assoc($select_image)) {
			$post_image = $row['post_image'];
		}
	}

	$query = "UPDATE posts SET post_title='{$post_title}', post_category_id='{$post_category_id}', post_date=now(), post_author='{$post_author}', post_status='{$post_status}', post_tags='{$post_tags}', post_content='{$post_content}', post_image='{$post_image}' WHERE post_id={$the_post_id}";

	$update_post = mysqli_query($connection, $query);

	confirmQuery($update_post);
}

?>

<form accept="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" value="<?php echo $post_title ?>" name="title" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category Id</label>
		<select name="post_category_id" class="form-control">
			<?php 

			$query = "SELECT * FROM categories";
			$select_categories = mysqli_query($connection, $query);

			confirmQuery($select_categories);

			while ($row = mysqli_fetch_assoc($select_categories)) {
				$cat_id = $row['cat_id'];
				$cat_title = $row['cat_title'];

				if ($post_category_id == $cat_id) {
					echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
				} else {
					echo "<option value='{$cat_id}'>{$cat_title}</option>";
				}
				
			}

			?>

		</select>
	</div>

	<div class="form-group">
		<label for="author">Post Author</label>
		<input type="text" value="<?php echo $post_author ?>" name="author" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select name="post_status" class='form-control'>
			<option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
			<?php 
			if ($post_status !== "Published") {
				echo "<option value='Published'>Published</option>";
			} else {
				echo "<option value='Draft'>Draft</option>";
			}
			?>
		</select>
	</div>

	<div class="form-group">
		<input type="file" name="image">
		<img src="../images/<?php echo $post_image; ?>" width="100">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" value="<?php echo $post_tags; ?>" name="post_tags" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
	</div>

	<div class="form-group">
		<input type="submit" name="update_post" value="Update Post" class="btn btn-info">
	</div>
</form>