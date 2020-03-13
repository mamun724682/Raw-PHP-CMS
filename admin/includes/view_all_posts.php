<?php 
include 'post_delete_modal.php';

if (isset($_POST['checkBoxArray'])) {

  foreach ($_POST['checkBoxArray'] as $postValueId) {

    $bulk_options = $_POST['bulk_options'];

    switch ($bulk_options) {
      case 'Published':
      $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
      $update_to_published_status = mysqli_query($connection, $query);
      confirmQuery($update_to_published_status);
      break;

      case 'Draft':
      $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
      $update_to_draft_status = mysqli_query($connection, $query);
      confirmQuery($update_to_draft_status);
      break;

      case 'delete':
      $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
      $delete_posts = mysqli_query($connection, $query);
      confirmQuery($delete_posts);
      break;

      case 'clone':
      $query = "SELECT * FROM posts WHERE post_id={$postValueId}";
      $select_post_query = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($select_post_query)) {
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_author = $row['post_author'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
      }

      $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
      $copy_query = mysqli_query($connection, $query);

      confirmQuery($copy_query);
      break;
    }
  }
}

?>

<form action="" method="post">

  <table class="table table-bordered table-hover">

    <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px">
      <select class="form-control" name="bulk_options">
        <option value="">Select Option</option>
        <option value="Published">Publish</option>
        <option value="Draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
      </select>
    </div>
    <div class="col-xs-4">
      <input type="submit" name="submit" class="btn btn-success" value="Apply">
      <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <thead>
      <tr>
        <th><input type="checkbox" id="selectAllBoxes" name=""></th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>Views</th>
      </tr>
    </thead>
    <tbody>

      <?php 

      // $query = "SELECT * FROM posts ORDER BY post_id DESC";
      // Database Left join query, pull data
      $query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
      $query .= "FROM posts ";
      $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";

      $select_all_posts_query = mysqli_query($connection, $query);
      confirmQuery($select_all_posts_query);
      while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_date = $row['post_date'];
        $post_views_count = $row['post_views_count'];
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        ?>
        
        <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value='<?php echo $post_id; ?>'></td>
        
        <?php
        echo "<td>{$post_id}</td>";

        if (!empty($post_user)) {
          $query = "SELECT * FROM users WHERE user_id=$post_user";
          $select_all_post_users_query = mysqli_query($connection, $query);
          $row = mysqli_fetch_assoc($select_all_post_users_query);
          $post_user_name = $row['username'];
          echo "<td>{$post_user_name}</td>";
        } elseif (!$post_user) {
          echo "<td>{$post_author}</td>";
        }


        echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";

        echo "<td>{$cat_title}</td>";

        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
        echo "<td>{$post_tags}</td>";

        // Count post comments
        $query = "SELECT * FROM comments WHERE comment_post_id=$post_id";
        $send_comment_query = mysqli_query($connection, $query);
        $post_comment_count = mysqli_num_rows($send_comment_query);
        echo "<td><a href='comments.php?post_id=$post_id'>{$post_comment_count}</a></td>";

        echo "<td>{$post_date}</td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}' class='btn btn-info'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";
        echo "<td><a rel='$post_id' href='javascript:void(0)' class='btn btn-danger delete_link'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
        echo "<td><a href='posts.php?reset=$post_id'>{$post_views_count}</a></td>";
        echo "</tr>";
      }

      ?>
    </tbody>
  </table>
</form>

<?php 

if (isset($_GET['delete'])) {
  $the_post_id = $_GET['delete'];
  $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
  $delete_query = mysqli_query($connection, $query);
  header("Location: posts.php");
}

if (isset($_GET['reset'])) {
  $the_post_id = $_GET['reset'];
  $query = "UPDATE posts SET post_views_count=0 WHERE post_id=" . mysqli_escape_string($connection, $the_post_id) . " ";
  $delete_query = mysqli_query($connection, $query);
  header("Location: posts.php");
}

?>

<script type="text/javascript">
  $(document).ready(function() {
    $(".delete_link").on('click', function() {
      var id = $(this).attr("rel");
      var delete_url = "posts.php?delete="+ id + "";
      $(".modal_delete_link").attr('href', delete_url);
      $('#mymodal').modal('show');
    });
  });
</script>