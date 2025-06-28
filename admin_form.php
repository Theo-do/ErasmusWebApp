<?php
    session_start();
    require_once 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        

        // Ελέγχει αν οι ημερομηνίες είναι έγκυρες
        if (strtotime($start_date) > strtotime($end_date)) {
            echo "<script>alert('Η ημερομηνία έναρξης πρέπει να είναι πριν από την ημερομηνία λήξης.'); window.history.back();</script>";
            die;
        }
        else
        {
            mysqli_select_db($con, 'erasmus_db');
                                                    // Δημιουργία πίνακα πανεπιστημίων αν δεν υπάρχει
            $sql = "CREATE TABLE IF NOT EXISTS submission_window (
                id INT AUTO_INCREMENT PRIMARY KEY,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL
                )";

            mysqli_query($con, $sql);

            // Έλεγχος αν ο πίνακας είναι κενός
            $countResult = mysqli_query($con, "SELECT COUNT(*) as cnt FROM submission_window");
            $row = mysqli_fetch_assoc($countResult);

            if ($row['cnt'] == 0) {
                // Αν ο πίνακας είναι κενός, κάνε εισαγωγή
                $insertSql = "INSERT INTO submission_window (start_date, end_date) VALUES ('$start_date', '$end_date')";
                if (mysqli_query($con, $insertSql)) {
                    echo "<script>alert('Οι ημερομηνίες υποβολής αιτήσεων έχουν οριστεί επιτυχώς.'); window.location.href = 'admin_dashboard.php';</script>";
                } else {
                    echo "<script>alert('Σφάλμα κατά την εισαγωγή: " . mysqli_error($con) . "'); window.history.back();</script>";
                }
            } else {
                // Αν υπάρχει ήδη εγγραφή, κάνε ενημέρωση
                $updateSql = "UPDATE submission_window SET start_date = '$start_date', end_date = '$end_date' LIMIT 1";
                if (mysqli_query($con, $updateSql)) {
                    echo "<script>alert('Οι ημερομηνίες υποβολής αιτήσεων ενημερώθηκαν επιτυχώς.'); window.location.href = 'admin_dashboard.php';</script>";
                } else {
                    echo "<script>alert('Σφάλμα κατά την ενημέρωση: " . mysqli_error($con) . "'); window.history.back();</script>";
                }
            }

            mysqli_close($con); 
        }
        
    }
?>