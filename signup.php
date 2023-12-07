
<?php
$title = "Signup";
include('header.php');


$firstName = $lastName = $email = $password = '';
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['firstname'])) {
        $firstNameErr = 'First Name is required';
    } else {
        $firstName = $_POST['firstname'];
    }
    if (empty($_POST['lastname'])) {
        $lastNameErr = 'Last Name is required';
    } else {
        $lastName = $_POST['lastname'];
    }
    if (empty($_POST['email'])) {
        $emailErr = 'Email is required';
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            $emailErr = "Invalid email address";
        }
    }
    if (empty($_POST['password'])) {
        $passwordErr = 'Password is required';
    } else {
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($passwordErr)) {
        $sql = "INSERT INTO User (firstName, lastName, email, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            echo 'Error: ' . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $hash);

        if (mysqli_stmt_execute($stmt)) {
            echo "Success!";
            header('Location: login.php');
            exit();
        } else {
            echo 'Error: ' . mysqli_error($conn);
            exit();
        }
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5"> Sign up </h1>
        </div>
    </div>
    
    <div class="row">
    <form action="" method="POST">
    <div class="form-group">
        <label for="firstname">First Name: </label>
        <input class="form-control <?php echo $firstNameErr ? 'is-invalid' : ''; ?>" type="text" name="firstname" id="firstname" value="<?php echo $firstName; ?>">
        <div class="invalid-feedback"><?php echo $firstNameErr; ?></div>
    </div>
    <div class="form-group">
        <label for="lastname">Last Name: </label>
        <input class="form-control <?php echo $lastNameErr ? 'is-invalid' : ''; ?>" type="text" name="lastname" id="lastname" value="<?php echo $lastName; ?>">
        <div class="invalid-feedback"><?php echo $lastNameErr; ?></div>
    </div>
    <div class="form-group">
        <label for="email">Email: </label>
        <input class="form-control <?php echo $emailErr ? 'is-invalid' : ''; ?>" type="text" name="email" id="email" value="<?php echo $email; ?>">
        <div class="invalid-feedback"><?php echo $emailErr; ?></div>
    </div>
    <div class="form-group">
        <label for="password">Password: </label>
        <input class="form-control <?php echo $passwordErr ? 'is-invalid' : ''; ?>" type="password" name="password" id="password">
        <div class="invalid-feedback"><?php echo $passwordErr; ?></div>
    </div>           
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Signup">
    </div>
</form>
</div>
</div>