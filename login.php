<?php
    $title="Login";
    include('header.php');

    $emailErr = "";
    $passwordErr = "";
    $invalidCredentials = "";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(empty($_POST['email'])){
            $emailErr = 'Email is required';
        }else{
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);             
        }

        if(empty($_POST['password'])){
            $passwordErr = 'Password is required';
        }else{
            $password = $_POST['password']; 
        }
    }

    if(isset($email) && isset($password)){
        $sql = "SELECT * From USER WHERE EMAIL = '$email'";
         
        $result = mysqli_query($conn, $sql);   
    
        if ($user = $result->fetch_assoc()) {
            $isValidPassword = password_verify($password, $user['Password']);
    
            if (!$isValidPassword) {
                $invalidCredentials = "Credentials are invalid";
            } else {
                $_SESSION['email'] = $email;               
                header('Location: /home.php');
                exit();
            }
        } else {
            $invalidCredentials = "Credentials are invalid";
        }
    }

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5"> Login </h1>
        </div>
    </div>
    
    <div class="row">
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email: </label>
                <input class="form-control <?php echo $emailErr ? 'is-invalid' : ''; ?>" type="text" name="email" id="email">
                <?php if ($emailErr): ?>
                    <div class="invalid-feedback"><?php echo $emailErr; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input class="form-control <?php echo $passwordErr ? 'is-invalid' : ''; ?>" type="password" name="password" id="password">
                <?php if ($passwordErr): ?>
                    <div class="invalid-feedback"><?php echo $passwordErr; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Login">
            </div>
            <?php if ($invalidCredentials): ?>
                <div class="alert alert-danger"><?php echo $invalidCredentials; ?></div>
            <?php endif; ?>
        </form>
    </div>
</div>