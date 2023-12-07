
<?php include './config/database.php'; 
session_start();

$user = isset($_SESSION['email']) ? $_SESSION['email'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Bookmark Application</title>
</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4">
    <div class="container">
      <a class="navbar-brand" href="#">Bookmark Application</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="/home.php">Home</a>
          </li>
          <?php if (!$user): ?>
            <li class="nav-item">
             <a class="nav-link" href="/login.php">Login</a>
            </li>
        <?php endif; ?>
         
        <?php if (!$user): ?>
          <li class="nav-item">
            <a class="nav-link" href="/signup.php">Signup</a>
          </li>
        <?php endif; ?>
        <?php if (!!$user): ?>
          <li class="nav-item">
            <a class="nav-link" href="/logout.php">Logout</a>
          </li>         
        <?php endif; ?>
        <?php if (!!$user): ?>
          <li class="nav-item">
            <a class="nav-link" href="/addbookmark.php">Add Bookmark</a>
          </li>
          <?php endif; ?> 
          <?php if (!!$user): ?>
          <li class="nav-item">
            <a class="nav-link" href="/mybookmarks.php">My Bookmarks</a>
          </li>
          <?php endif; ?> 
        </ul>
      </div>
  </div>
</nav>
