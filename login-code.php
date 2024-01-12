<?php

require 'config/function.php';

if (isset($_POST['loginBtn'])) {
    $name = validate($_POST['name']);
    $password = validate($_POST['password']);

    $query = "SELECT * FROM admins WHERE name ='$name' AND password ='$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION['name'] = $name; // Store the username in the session
        redirect('admin/index.php', 'login success');
    } else {
        redirect('login.php', 'Invalid username or password');
    }
}
?>
