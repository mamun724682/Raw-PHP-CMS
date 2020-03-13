<?php 

if (isset($_POST['create_user'])) {
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

	$query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_role) VALUES ('{$username}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_role}')";
	$create_user_query = mysqli_query($connection, $query);

	confirmQuery($create_user_query);

	echo "User Created: " . "<a href='users.php'>View Users</a>";
}

?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" name="user_firstname" class="form-control">
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" name="user_lastname" class="form-control">
	</div>

	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="username" class="form-control">
	</div>

	<div class="form-group">
		<label for="user_role">User Role</label>
		<select class="form-control" name="user_role">
			<option value="subscriber">Select Options</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>
		</select>
	</div>

	<div class="form-group">
		<label for="user_email">Email</label>
		<input type="text" name="user_email" class="form-control">
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
		<input type="submit" name="create_user" value="Register" class="btn btn-primary">
	</div>
</form>