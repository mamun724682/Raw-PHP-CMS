<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Admin</th>
      <th>Subscriber</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    $query = "SELECT * FROM users";
    $select_users = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_users)) {
      $user_id = $row['user_id'];
      $username = $row['username'];
      $user_password = $row['user_password'];
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $user_email = $row['user_email'];
      $user_image = $row['user_image'];
      $user_role = $row['user_role'];

      echo "<tr>";
      echo "<td>{$user_id}</td>";
      echo "<td>{$username}</td>";
      echo "<td>{$user_firstname}</td>";
      echo "<td>{$user_lastname}</td>";
      echo "<td>{$user_email}</td>";
      echo "<td>{$user_role}</td>";

      // $query = "SELECT * FROM posts WHERE post_id=$user_post_id";
      // $select_post_id = mysqli_query($connection, $query);
      // while ($row = mysqli_fetch_assoc($select_post_id)) {
      //   $post_id = $row['post_id'];
      //   $post_title = $row['post_title'];

      //   echo "<td><a href='../post.php?p_id=$post_id' target='_blank'>{$post_title}</a></td>";
      // }
      

      echo "<td><a href='users.php?change_to_admin={$user_id}' class='btn btn-success'>Admin</a></td>";
      echo "<td><a href='users.php?change_to_subscriber={$user_id}' class='btn btn-warning'>Subscriber</a></td>";
      echo "<td><a href='users.php?source=edit_user&edit=$user_id' class='btn btn-info'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";
      echo "<td><a href='users.php?delete=$user_id' class='btn btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
      echo "</tr>";
    }

    ?>
  </tbody>
</table>

<?php 
// Make Admin
if (isset($_GET['change_to_admin'])) {
  $user_id = $_GET['change_to_admin'];
  $query = "UPDATE users SET user_role='admin' WHERE user_id = {$user_id}";
  $change_to_admin_query = mysqli_query($connection, $query);
  header("Location: users.php");
}

// Unchange_to_admin user
if (isset($_GET['change_to_subscriber'])) {
  $user_id = $_GET['change_to_subscriber'];
  $query = "UPDATE users SET user_role='subscriber' WHERE user_id = {$user_id}";
  $unchange_to_admin_query = mysqli_query($connection, $query);
  header("Location: users.php");
}


// Delete user
if (isset($_GET['delete'])) {
  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] == 'admin') {
      $user_id = mysqli_real_escape_string($connection, $_GET['delete']);
      $query = "DELETE FROM users WHERE user_id = {$user_id}";
      $delete_query = mysqli_query($connection, $query);
      header("Location: users.php");
    }
  }
}

?>