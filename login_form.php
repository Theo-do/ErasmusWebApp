<?php
    session_start();
    require_once 'db.php';

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        $_SESSION['username'] = $user['username'];
        $_SESSION['password'] = $user['password'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['am'] = $user['am']; 

        if($user['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        }  
        else {
            header('Location: index.php'); // Για επισκέπτες ή άλλους ρόλους
        }
        
        die; 
    } 
    else {
        echo 'Δεν βρέθηκε χρήστης.';
    }

    mysqli_close($con); // Κλείσιμο της σύνδεσης στη βάση δεδομένων
