<?php
include('header.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $title = $_POST['title'];
    $url =  $_POST['url'];
    $email = $_SESSION['email']; 

    

    $stmt = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id = $row['Id'];

    $sql = "INSERT INTO bookmarks (title, url, userId) 
    VALUES ('$title', '$url', '$id')";

    if (mysqli_query($conn, $sql)) {
    header('Location: mybookmarks.php');
    } else {
      echo 'Error: ' . mysqli_error($conn);
    };
}


?>
<form action="" method="POST">
    <div class="container" style="margin-top: 80px;">
        <main role="main" class="pb-3">
            <div class="row" style="min-height: 80vh; display: flex; align-items: center;">
                <div class="col-md-6 offset-md-3 bg-light p-4 rounded shadow">
                    <h3>Add Bookmark</h3>
                    <input type="text" name="title" placeholder="Title" class="form-control" onchange="onTitleChange(event)"/><br />
                    <input type="text" name="url" placeholder="Url" class="form-control" onchange="onUrlChange(event)"/><br />
                    <button class="btn btn-primary">Add</button>
                </div>
            </div>
        </main>
    </div>
</form>