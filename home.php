<?php
include('header.php');

$user = $_SESSION['email']; 

echo "<div class='container my-4'>";
if ($user) {
    echo "<div class='alert alert-success text-center'>Welcome back, " . htmlspecialchars($user) . "!</div>";
} else {
    echo "<div class='alert alert-primary text-center'>Welcome to the React Bookmark Application!</div>";
}

$sql = "SELECT URL, COUNT(userid) AS UserCount 
    FROM bookmarks 
    GROUP BY URL 
    ORDER BY UserCount DESC 
    LIMIT 5";
$result = mysqli_query($conn, $sql);    
$top5URLsWithUserCount = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>Url</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($top5URLsWithUserCount as $b): ?>
            <tr>
                <td>
                    <a href="<?php echo htmlspecialchars($b['URL']); ?>" target="_blank"><?php echo htmlspecialchars($b['URL']); ?></a>
                </td>
                <td>
                    <?php echo htmlspecialchars($b['UserCount']); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>


