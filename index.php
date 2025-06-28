<!DOCTYPE html>

<?php
    session_start();

    if(!isset($_SESSION['role'])) {
        $_SESSION['role'] = 'visitor'; // Default ρόλος 
    }

    require_once 'db.php';
    mysqli_select_db($con, 'erasmus_db');
                                                // Δημιουργία πίνακα χρηστών αν δεν υπάρχει
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name TEXT NOT NULL,
        surname TEXT NOT NULL,
        am TEXT NOT NULL,
        phone TEXT NOT NULL,
        email TEXT NOT NULL,
        username TEXT NOT NULL,
        password TEXT NOT NULL,
        role ENUM('visitor', 'registered', 'admin') 
    )";
    mysqli_query($con, $sql);

    mysqli_select_db($con, 'erasmus_db');
    $result = mysqli_query($con, "SELECT * FROM users where username = 'admin'");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        // Αν δεν υπάρχει ήδη ο χρήστης admin, τον δημιουργεί
        $sql = "INSERT INTO users (username, password, role)
                VALUES ('admin', '123', 'admin')";
        mysqli_query($con, $sql);
    }

    $sql = "SELECT * FROM submission_window";
    $result = mysqli_query($con, $sql);
    $dates = mysqli_fetch_assoc($result);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erasmus Αρχική</title>
    <link rel="stylesheet" href="styles\style.css">
</head>

<body>
    <div class="header">
        <h1>Καλώς ήρθατε στην ιστοσελίδα του Erasmus</h1>
    </div>
    
    <div class="row">
        <div class="col-s-12 col-m-3 col-l-3 menu">
            <h1>Μενού</h1>
            <ul>
                <li><a href="more.php">Περισσότερες πληροφορίες για το Erasmus</a></li>
                <li><a href="application.php">Φόρμα αίτησης συμμετοχής</a></li>
                <li><a href="reqs.php">Απαιτήσεις</a></li>
                <br><br>
                <?php 
                    if ($_SESSION['role'] == 'visitor') { 
                        echo "<li><a href='login.php'>Σύνδεση</a></li>";
                        echo "<li><a href='sign-up.php'>Εγγραφή</a></li>";
                    }
                    else
                    {
                        echo "<li><a href='edit_profile.php'>Επεξεργασία Προφίλ</a></li>";
                    }
                ?>
                <li><a href="logout.php">Αποσύνδεση</a></li>
            </ul>
        </div>

        <div class="col-s-12 col-m-9 col-l-6 main">
            <h1>Αυτή είναι η αρχική σελίδα της ιστοσελίδας μας.</h1>
            <p>Εδώ μπορείτε να βρείτε πληροφορίες σχετικά με το πρόγραμμα Erasmus.</p>
            <p>Αν θέλετε περισσότερες λεπτομέρειες ή να λάβετε συμμετοχή στο πρόγραμμα Erasmus, παρακαλώ επισκεφθείτε τις άλλες σελίδες μας.</p>
            
            <img src="media\εικόνες\welcoming.jpg" alt="Welcome">

            <h1>Πρόγραμμα Erasmus</h1>
            <p>Το πρόγραμμα Erasmus είναι μια πρωτοβουλία της Ευρωπαϊκής Ένωσης που επιτρέπει στους φοιτητές να σπουδάζουν 
                σε πανεπιστήμια άλλων χωρών της ΕΕ. Σκοπός του είναι η προώθηση της ακαδημαϊκής και πολιτιστικής ανταλλαγής. 
                Μέσω του Erasmus, οι φοιτητές έχουν την ευκαιρία να αποκτήσουν διεθνή εμπειρία και να διευρύνουν τους ορίζοντές τους.</p>
                <br><br>
        </div>

        <div class="col-s-12 col-m-12 col-l-3">
            <div class="aside">
                <h1>Σημαντικές Πληροφορίες</h1>
                <ul>
                    <?php
                        echo "<li>Έναρξη προγράμματος: " . $dates['start_date'] . "</li>";
                        echo "<li>Προθεσμία υποβολής αιτήσεων: " . $dates['end_date'] . "</li>";
                        if($_SESSION['role'] != 'visitor') {
                            echo "<br><br><li>Συνδεδεμένοι ώς: " . $_SESSION['username'] . "</li>";
                        }
                    ?>
                </ul>
            </div> 
        </div>
    </div>    
    <div class="footer">
        <p>&copy; 2025 Erasmus. All rights reserved.</p>
    </div>
</body>
</html>