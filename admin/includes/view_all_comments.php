<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Author</th>
      <th>Comment</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response TO</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    if (isset($_GET['post_id'])) {
      $comment_post_id = $_GET['post_id'];
      $query = "SELECT * FROM comments WHERE comment_post_id=$comment_post_id";
      $select_all_comments_query = mysqli_query($connection, $query);
      if (mysqli_num_rows($select_all_comments_query) != null) {
        while ($row = mysqli_fetch_assoc($select_all_comments_query)) {
          $comment_id = $row['comment_id'];
          $comment_post_id = $row['comment_post_id'];
          $comment_author = $row['comment_author'];
          $comment_content = $row['comment_content'];
          $comment_email = $row['comment_email'];
          $comment_status = $row['comment_status'];
          $comment_date = $row['comment_date'];

          echo "<tr>";
          echo "<td>{$comment_id}</td>";
          echo "<td>{$comment_author}</td>";
          echo "<td>{$comment_content}</td>";
          echo "<td>{$comment_email}</td>";

          if ($comment_status == 'Approved') {
            echo "<td class='text-success'>{$comment_status}</td>";
          } else {
            echo "<td class='text-danger'>{$comment_status}</td>";
          }

          $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
          $select_post_id = mysqli_query($connection, $query);
          while ($row = mysqli_fetch_assoc($select_post_id)) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];

            echo "<td><a href='../post.php?p_id=$post_id' target='_blank'>{$post_title}</a></td>";
          }

          echo "<td>{$comment_date}</td>";

          echo "<td><a href='comments.php?approve={$comment_id}' class='btn btn-success'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a></td>";
          echo "<td><a href='comments.php?unapprove={$comment_id}' class='btn btn-warning'><i class='fa fa-times-circle-o' aria-hidden='true'></i></a></td>";
          echo "<td><a href='comments.php?delete=$comment_id' class='btn btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
          echo "</tr>";
        }
      } else {
        header("Location: posts.php");
      }

    } else {
      $query = "SELECT * FROM comments";
      $select_all_comments_query = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($select_all_comments_query)) {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];

        echo "<tr>";
        echo "<td>{$comment_id}</td>";
        echo "<td>{$comment_author}</td>";
        echo "<td>{$comment_content}</td>";
        echo "<td>{$comment_email}</td>";
        if ($comment_status == 'Approved') {
          echo "<td class='text-success'>{$comment_status}</td>";
        } else {
          echo "<td class='text-danger'>{$comment_status}</td>";
        }

        $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
        $select_post_id = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_post_id)) {
          $post_id = $row['post_id'];
          $post_title = $row['post_title'];

          echo "<td><a href='../post.php?p_id=$post_id' target='_blank'>{$post_title}</a></td>";
        }

        echo "<td>{$comment_date}</td>";

        echo "<td><a href='comments.php?approve={$comment_id}' class='btn btn-success'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a></td>";
        echo "<td><a href='comments.php?unapprove={$comment_id}' class='btn btn-warning'><i class='fa fa-times-circle-o' aria-hidden='true'></i></a></td>";
        echo "<td><a href='comments.php?delete=$comment_id' class='btn btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
        echo "</tr>";
      }
    }

    ?>
  </tbody>
</table>

<?php 
// Approve Comment
if (isset($_GET['approve'])) {
  echo $comment_id = $_GET['approve'];
  $query = "UPDATE comments SET comment_status='Approved' WHERE comment_id = {$comment_id}";
  $approve_query = mysqli_query($connection, $query);
  header("Location: comments.php");
}

// Unapprove Comment
if (isset($_GET['unapprove'])) {
  $comment_id = $_GET['unapprove'];
  $query = "UPDATE comments SET comment_status='Unapproved' WHERE comment_id = {$comment_id}";
  $unapprove_query = mysqli_query($connection, $query);
  header("Location: comments.php");
}


// Delete Comment
if (isset($_GET['delete'])) {
  $comment_id = $_GET['delete'];
  $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
  $delete_query = mysqli_query($connection, $query);
  header("Location: comments.php");
}

?>