<?php
    session_start();
    require_once 'db.php';

    mysqli_select_db($con, 'erasmus_db');

    $sql = "CREATE TABLE IF NOT EXISTS applications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name TEXT NOT NULL,
        surname TEXT NOT NULL,
        am TEXT NOT NULL,
        classes_passed INT NOT NULL,
        average_passed FLOAT NOT NULL,
        additional_languages TEXT NOT NULL,
        university_1 TEXT NOT NULL,
        university_2 TEXT NOT NULL,
        university_3 TEXT NOT NULL
    )";

    mysqli_query($con, $sql);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['username']);
        $surname = trim($_POST['surname']);
        $am = trim($_POST['am']);
        $classes_passed = trim($_POST['classes_passed']);
        $average_passed = trim($_POST['average_passed']);
        $additional_languages = trim($_POST['additional_languages']);
        $university_1 = trim($_POST['university1']);
        $university_2 = trim($_POST['university2']);
        $university_3 = trim($_POST['university3']);
        
        // Εισαγωγή της αίτησης στη βάση δεδομένων
        $sql = "INSERT INTO applications (name, surname, am, classes_passed, average_passed, additional_languages, university_1, university_2, university_3)
                      VALUES ('$name', '$surname', '$am', '$classes_passed', '$average_passed', '$additional_languages', '$university_1', '$university_2', '$university_3')";

        $target_dir = "uploads/" . $am . "/"; // φάκελος για καθένα φοιτητή με βάση το ΑΜ
        if(!is_dir($target_dir)) {
            mkdir($target_dir, 0700, true);   // 700 σημαίνει Permission μόνο ο ιδιοκτήτης μπορεί να διαβάσει/γράψει
        }

        if(isset($_FILES['english_certificate']) && $_FILES['english_certificate']['error'] == 0) {
            $filename = basename($_FILES['english_certificate']['name']);
            $fileextension = pathinfo($filename, PATHINFO_EXTENSION);

            if($fileextension != 'pdf') {
                die("<script>alert('Το αρχείο του πιστοποιητικού αγγλικών πρέπει να είναι σε μορφή PDF.'); window.history.back();</script>");
            }

            $new_filename = 'engCert_' . $am . '.' . $fileextension;
            $target_file = $target_dir . $new_filename;

            move_uploaded_file($_FILES['english_certificate']['tmp_name'], $target_file); //upload του αρχείου
        } 

        if(isset($_FILES['grades']) && $_FILES['grades']['error'] == 0) {
            $filename = basename($_FILES['grades']['name']);
            $fileextension = pathinfo($filename, PATHINFO_EXTENSION);

            if($fileextension != 'pdf') {
                die("<script>alert('Το αρχείο βαθμολογίας πρέπει να είναι σε μορφή PDF.'); window.history.back();</script>");
            }

            $new_filename = 'grades_' . $am . '.' . $fileextension;
            $target_file = $target_dir . $new_filename;

            move_uploaded_file($_FILES['grades']['tmp_name'], $target_file); //upload του αρχείου
        }

        foreach($_FILES['other_languages_certificates']['name'] as $index => $name) {   //πολλαπλά αρχεία
            if($_FILES['other_languages_certificates']['error'][$index] == 0) {
                $filename = basename($_FILES['other_languages_certificates']['name'][$index]);
                $fileextension = pathinfo($name, PATHINFO_EXTENSION);

                if($fileextension != 'pdf') {
                    die("<script>alert('Τα αρχεία των άλλων ξένων γλωσσών πρέπει να είναι σε μορφή PDF.'); window.history.back();</script>");
                }

                $new_filename = 'otherLangCert_' . $am . '_' . uniqid() . '.' . $fileextension; // uniqid γιατί θα κάνει overwrite το ένα αρχείο το άλλο
                $target_file = $target_dir . $new_filename;

                move_uploaded_file($_FILES['other_languages_certificates']['tmp_name'][$index], $target_file); //upload του αρχείου
            }
        }

        if(mysqli_query($con, $sql)) {
            echo "<script>alert('Η αίτησή σας υποβλήθηκε επιτυχώς.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Σφάλμα κατά την υποβολή της αίτησης: " . mysqli_error($con) . "'); window.history.back();</script>";
        }
    }

    mysqli_close($con);
?>