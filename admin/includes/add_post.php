<?php 

if (isset($_POST['create_post'])) {
	$post_title = $_POST['title'];
	$post_user = $_POST['post_user'];
	$post_category_id = $_POST['post_category_id'];
	$post_status = $_POST['post_status'];

	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];

	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_date = date('d-m-y');
	$post_comment_count = 0;

	move_uploaded_file($post_image_temp, "../images/$post_image");

	$query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) VALUES ({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}')";
	$create_post_query = mysqli_query($connection, $query);

	confirmQuery($create_post_query);
}

?>

<form accept="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" name="title" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category Id</label>

		<!-- <input type="text" name="post_category_id" class="form-control"> -->
		<select class="form-control" name="post_category_id">
			<?php 
			$query = "SELECT * FROM categories";
			$select_category_id = mysqli_query($connection, $query);
			while ($row = mysqli_fetch_assoc($select_category_id)) {
				$cat_id = $row['cat_id'];
				$cat_title = $row['cat_title'];
				echo "<option value='{$cat_id}'>{$cat_title}</option>";
			}
			?>
			
		</select>
	</div>

	<div class="form-group">
		<label for="users">Post User</label>
		<select class="form-control" name="post_user">
			<?php 
			$query = "SELECT * FROM users";
			$select_users_id = mysqli_query($connection, $query);
			while ($row = mysqli_fetch_assoc($select_users_id)) {
				$user_id = $row['user_id'];
				$username = $row['username'];
				echo "<option value='{$user_id}'>{$username}</option>";
			}
			?>
			
		</select>
	</div>

	<div class="form-group">
	<label for="post_status">Post Status</label>
	<select name="post_status" class='form-control'>
		<option value="Draft">Select Options</option>
		<option value="Published">Publish</option>
		<option value="Draft">Draft</option>
	</select>
</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" name="post_tags" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
	</div>

	<div class="form-group">
		<input type="submit" name="create_post" value="Publish Post" class="btn btn-primary">
	</div>
</form>