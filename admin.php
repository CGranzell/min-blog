<?php
//Kräver att databas filen körs korrekt, annars stoppas appen
require("databaseconnect.php");
// Inkludera Header
include('header.php');

//Sätter felmeddelande till tomt
$errorMessageTitle = "";
$errorMessageAuthor = "";
$errorMessageContent = "";
$succesMessage = "";

// Updaterar inlägg
if (isset($_POST['updatePostBtn'])) {
  // //Tar bort mellanslag före och efter textsträng
  $title = trim($_POST['update-title']);
  $author = trim($_POST['update-author']);
  $content = trim($_POST['update-content']);

  // Om något av textfälten är tomma gå in i detta if block
  if (
    $title   === ""  ||
    $author  === ""  ||
    $content === ""
  ) {

    // Felmeddelande titel
    if (empty($title)) {
      $errorMessageTitle = '
      <div class="alert alert-danger message mx-auto">
        Title field must not be empty
      </div>
    ';
    }
    // Felmeddelande Author
    if (empty($author)) {
      $errorMessageAuthor = '
      <div class="alert alert-danger message mx-auto">
       Author field must not be empty
      </div>
    ';
    }
    // Felmeddelande Content
    if (empty($content)) {
      $errorMessageContent = '
      <div class="alert alert-danger message mx-auto">
       Content field must not be empty
      </div>
    ';
    }
    // Om alla textfälten är ifyllda
  } else {
    $succesMessage = '
    <div class="alert alert-success message mx-auto">
     Success ! Post Updated
    </div>
    ';

    // Uppdaterar title, author, content där id = $_POST['id']
    $sql = "
      UPDATE posts
      SET title = :title,
          author = :author,
          content = :content
      WHERE id = :id;
      ";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':author', $author);
    $statement->bindParam(':content', $content);
    $statement->bindParam(':id', $_POST['id']);
    $statement->execute();
  } 
}

//Tar bort inlägg
if (isset($_POST['deletePostBtn'])) {
  // Tar bort inlägg där id = $_POST['postID]
  $sql = "
      DELETE FROM posts
       WHERE id = :id;
    ";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_POST['postID']);
  $statement->execute();
}

//Lägger  till nytt blogg inlägg
if (isset($_POST['addPostBtn'])) {
  //Tar bort mellanslag före och efter textsträng
  $title = trim($_POST['title']);
  $author = trim($_POST['author']);
  $content = trim($_POST['content']);
  // Om något av textfälten är tomma gå in i detta if block
  if (
    $title   === ""  ||
    $author  === ""  ||
    $content === ""
  ) {

    // Felmeddelande titel
    if (empty($title)) {
      $errorMessageTitle = '
      <div class="alert alert-danger message mx-auto">
        Title field must not be empty
      </div>
    ';
    }
    // Felmeddelande Author
    if (empty($author)) {
      $errorMessageAuthor = '
      <div class="alert alert-danger message mx-auto">
       Author field must not be empty
      </div>
    ';
    }
    // Felmeddelande Content
    if (empty($content)) {
      $errorMessageContent = '
      <div class="alert alert-danger message mx-auto">
       Content field must not be empty
      </div>
    ';
    }
    // Om alla textfälten är ifyllda
  } else {
    $succesMessage = '
    <div class="alert alert-success message mx-auto">
     Success ! Post submitted 
    </div>
    ';

    $sql = "
      INSERT INTO posts (title, author, content)
      VALUES (:title, :author, :content);
    ";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':author', $author);
    $statement->bindParam(':content', $content);
    $statement->execute();
  }
}

// Hämtar alla inlägg
$sql = "SELECT * FROM posts";
$statement = $pdo->query($sql);
$posts = $statement->fetchAll();
?>

<!-- Länk till start sida -->
<a class="btn btn-primary" href="../min-blog/index.php" role="button">Tillbaka</a>
<hr class="mx-auto" style="width:70%" , size="6" , color="blue">
<!-- Fält för att skapa nytt inlägg -->
<h1 class="text-center">Add New Post</h1>
<form action="" method="POST">
  <div class="mb-3 mx-auto">
    <!-- Titel -->
    <label class="form-label">Title</label>
    <input type="text" class="form-control" name="title" placeholder="Title here...">
    <!-- Author -->
    <label class="form-label">Author</label>
    <input type="text" class="form-control" name="author" placeholder="Author name here...">
  </div>
  <!-- Blogg inlägg  -->
  <div class="mb-3 mx-auto">
    <label class="form-label">Blog Post</label>
    <textarea class="form-control" rows="3" placeholder="Blog post here..." name="content"></textarea>
    <input type="submit" value="Add" name="addPostBtn" type="button" class="btn btn-primary btn-add">
  </div>
</form>
<hr class="mx-auto" style="width:70%" , size="6" , color="blue">

<!-- Visar felmeddelande -->
<?= $errorMessageTitle ?>
<?= $errorMessageAuthor ?>
<?= $errorMessageContent ?>
<?= $succesMessage ?>
<hr class="mx-auto" style="width:70%" , size="6" , color="blue">
<!-- Loopar igenom blogginläggen  -->
<table class="table mx-auto">
  <thead>
    <tr>
      <!-- Titel -->
      <th class="tbody">Title</th>
      <!-- Author -->
      <th class="tbody">Author</th>
      <!-- Blogg inlägg -->
      <th class="tbody">Content</th>
      <!-- Hantera inlägg -->
      <th class="tbody">Handle</th>
    </tr>
  </thead>
  <tbody>
    <!-- Loopar igenom inlägg -->
    <?php foreach ($posts as $post) : ?>
      <tr>
        <!-- Titel -->
        <td class="tbody"> <?= htmlentities($post['title']) ?></td>
        <!-- Author -->
        <td class="tbody"><?= htmlentities($post['author']) ?></td>
        <!-- Blogg inlägg -->
        <td class="tbody"><?= htmlentities($post['content']) ?></td>
        <td class="tbody">
          <form action="" method="POST">
            <!-- id till blogg inlägg -->
            <input type="hidden" name="postID" value="<?= $post['id'] ?>">
            <!-- Delete knapp, tar bort inlägg -->
            <input type="submit" name="deletePostBtn" value="Delete" class="btn btn-primary btn-form">
            <!-- Update knapp, updaterar inlägg -->
            <button type="button" class="btn btn-primary btn-form" 
            data-bs-toggle="modal" 
             data-bs-target="#updateModal" 
            data-bs-title="<?= htmlentities($post['title']) ?>" 
            data-bs-author="<?= htmlentities($post['author']) ?>" 
            data-bs-content="<?= htmlentities($post['content']) ?>" 
            data-bs-id=" <?= htmlentities($post['id']) ?>"
            >Update</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<!-- Inkluderar footer -->
<?php include('footer.php'); ?>

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <!-- titel -->
          <div class="mb-3">
            <label for="title" class="col-form-label">Title:</label>
            <input type="text" name="update-title" class="form-control" id="text-title">
          </div>
          <!-- Author -->
          <div class="mb-3">
            <label for="author" class="col-form-label">Author:</label>
            <input type="text" name="update-author" class="form-control" id="text-author">
          </div>
          <!-- ID -->
          <input type="hidden" name="id" id="text-id">
          <!--  Content -->
          <div class="mb-3">
            <label for="content" class="col-form-label">Content:</label>
            <textarea class="form-control" name="update-content" id="text-content"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" name="updatePostBtn" class="btn btn-primary" value="Update">
      </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
  const updateModal = document.getElementById('updateModal')
  updateModal.addEventListener('show.bs.modal', function(event) {
    // Knapp som triggar modal
    const button = event.relatedTarget
    //Hämtar info från data-bs-atribut
    //Titel
    const title = button.getAttribute('data-bs-title')
    //Author
    const author = button.getAttribute('data-bs-author')
    //Content
    const content = button.getAttribute('data-bs-content')
    // ID
    const id = button.getAttribute('data-bs-id')
    console.log(id);
    // Uppdaterar modal innehåll
    //Titel
    const modalBlogTitle = updateModal.querySelector('#text-title')
    modalBlogTitle.value = title
    //Author
    const modalBlogAuthor = updateModal.querySelector('#text-author')
    modalBlogAuthor.value = author
    //Content
    const modalBlogContent = updateModal.querySelector('#text-content')
    modalBlogContent.value = content
    //ID
    const modalBlogID = updateModal.querySelector('#text-id')
    modalBlogID.value = id
  });
</script>