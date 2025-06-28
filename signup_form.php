<?php
    session_start();
    require_once 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $am = trim($_POST['am']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $role = 'registered'; // Ο ρόλος του χρήστη είναι 'registered' κατά την εγγραφή

        mysqli_select_db($con, 'erasmus_db');
        $result = mysqli_query($con, "SELECT * FROM users where username = '$username'");
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            // Αν υπάρχει ήδη χρήστης με το ίδιο username, επιστρέφει μήνυμα σφάλματος
            echo "<script>alert('Το όνομα χρήστη υπάρχει ήδη. Παρακαλώ επιλέξτε ένα διαφορετικό.'); window.history.back();</script>";
            die;
        }
        else {
            $sql = "INSERT INTO users (name, surname, am, phone, email, username, password, role)
                    VALUES ('$name', '$surname', '$am', '$phone', '$email', '$username', '$password', '$role')";
        
            if (mysqli_query($con, $sql)) {
                // Εισαγωγή επιτυχής
                echo 'Εγγραφή επιτυχής!';
            } 
            else {
                echo "<script>alert('Σφάλμα κατά την εγγραφή: " . mysqli_error($con) . "'); window.history.back();</script>";
            }
        }

        mysqli_close($con); // Κλείσιμο της σύνδεσης στη βάση δεδομένων
        header('Location: login.php'); // Ανακατεύθυνση στη σελίδα σύνδεσης μετά την επιτυχή εγγραφή
        
    }
?>