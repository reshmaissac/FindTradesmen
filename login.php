<div class="container">
    <?php include("includes/header.html");
    include("classes/user.php");

    ?>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        require('login_tools.php');

        $errors = array();
        if (isset($_POST["email"])) {

            $email = $_POST["email"];
        } else {
            $errors[] = 'Enter your email.';
        }
        if (isset($_POST["password"])) {

            $password = $_POST["password"];

        } else {
            $errors[] = 'Enter your password.';
        }
        if (empty($errors)) {
            $user = new User();
            list($check, $data) = $user->login($email, $password);
            if ($check) {
                session_start();

                $_SESSION['actor'] = [
                    'id' => $data['user_id'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'is_tradesman' => $data['is_tradesman']
                ];
                $_SESSION['authenticated'] = true;
                //header('location:home.php');
                if ($_SESSION['actor']['is_tradesman'] == 1) {
                    load('view_tradesmen_profile.php');
                } else {

                    load('index.php');
                }
                exit;

            } else {
                $errors = $data;
                foreach ($errors as $msg) {

                    echo "<script> alert('$msg'); </script>";
                }
            }
        } else {
            echo '<h1>Error!</h1>
                 <p id="err_msg">The following error(s) occurred:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>";
            }
            echo 'Please try again.</p>';

        }




    }
    ?>


    <!--  -->


    <div class="form-style">
        <h1>Login Now!</h1>

        <form action="login.php" method="post" class="form-signin" role="form">

            <div class="section"></div>
            <label>User Email</label>

            <input type="text" name="email"><br>

            <label>Password</label>

            <input type="password" name="password"><br>

            <button class="sumit-btn" name="submit" type="submit">Login</button>
        </form>

    </div>


    <div style="height: 400px;"></div>
</div>

<?php include("includes/footer.html") ?>