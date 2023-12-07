<?php
include('header.php');

$email = $_SESSION['email']; 
$editIds = [];

    $stmt = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $firstName = $row['FirstName'];
    $id = $row['Id'];

    $sql = "SELECT * From Bookmarks Where UserId = '$id'";
    $result = mysqli_query($conn, $sql);    
    $bookmarks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    

    $editIds = isset($_POST['editIds']) ? explode(',', $_POST['editIds']) : [];

    if (isset($_POST['bookmarkTitle']) && isset($_POST['bookmarkId'])) {
        $updatedTitle = $_POST['bookmarkTitle'];
        $bookmarkId = $_POST['bookmarkId'];
        $stmt = $conn->prepare("UPDATE BOOKMARKS SET TITLE = ? WHERE ID = ?");
        $stmt->bind_param("si", $updatedTitle, $bookmarkId);
    
        if ($stmt->execute()) {
            header('Location: mybookmarks.php');
            exit; 
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
        $stmt->close();
    }
   if (isset($_POST['delete']) && $_POST['delete'] != '') {
        $idToDelete = $_POST['delete'];
        $stmt = $conn->prepare("DELETE FROM BOOKMARKS WHERE ID = ?");
        $stmt->bind_param("i", $idToDelete);
    
        if ($stmt->execute()) {
            header('Location: mybookmarks.php');
            exit; 
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
        $stmt->close();
    }
?>

<script>

let editIds = <?php echo json_encode($editIds); ?>;

const onEditCancelClick = id => {
    const idStr = id.toString();

    if (editIds.includes(idStr)) {
        editIds = editIds.filter(i => i !== idStr);
    } else {
        editIds = [...editIds, idStr];
    }

    document.getElementById('editIdsInput').value = editIds.join(','); 
};

const onUpdateClick = id => {
    document.getElementById('bookmarkIdInput').value = id; 
};

const onDeleteClick = id => {
    document.getElementById('delete').value = id; 
}


</script>

<form method="post" id="editForm">

<input type="hidden" name="editIds" id="editIdsInput" value="">
<input type="hidden" name="bookmarkId" id="bookmarkIdInput" value="">
<input type="hidden" name="delete" id="delete" value="">

<div style="margin-top: 20px; background-color: lightgrey; text-align: center; padding: 20px;">
    <div class="row">
        <div class="col-md-12">
            <h1>Welcome back <?php echo $firstName; ?></h1>
            <a class="nav-link" href="/addbookmark.php">Add Bookmark</a>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <table class="table table-hover table-striped table-bordered" style="width: 100%; margin: auto; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="text-align: center; padding: 12px;">Title</th>
                <th style="text-align: center; padding: 12px;">Url</th>
                <th style="text-align: center; padding: 12px;">Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($bookmarks as $b): ?>
            <tr>
                <td style="text-align: center; vertical-align: middle;">
                <?php 
                if (!in_array($b['Id'], $editIds)) {
                    echo ($b['Title']);
                } elseif (in_array($b['Id'], $editIds)) {
                    ?>
                    <input type="text"
                           class="form-control"
                           name="bookmarkTitle"
                           value="<?php echo htmlspecialchars($b['Title']); ?>"
                           placeholder="Title"
                           onchange="onTitleChange(event)">
                    <?php
                }
                ?>
                </td>
              
                <td style="text-align: center; vertical-align: middle;">
                    <a href="<?php echo htmlspecialchars($b['Url']); ?>" target="_blank">
                        <?php echo htmlspecialchars($b['Url']); ?>
                    </a>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                <?php 
               if (!in_array($b['Id'], $editIds)) {
                echo '<button class="btn btn-success" onclick="onEditCancelClick(' . $b['Id'] . ')">Edit Title</button>';
                } else {
                echo '<button class="btn btn-warning" onclick="onUpdateClick(' . $b['Id'] . ')">Update</button>';
                echo '<button class="btn btn-info" onclick="onEditCancelClick(' . $b['Id'] . ')">Cancel</button>';
                }
                echo '<button class="btn btn-info" onclick="onDeleteClick(' . $b['Id'] . ')">Delete</button>';
               ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</form>