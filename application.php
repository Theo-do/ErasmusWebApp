<!DOCTYPE html>

<?php
    session_start();
    require_once 'db.php';

    mysqli_select_db($con, 'erasmus_db');

    // Get submission window dates from the database
    $sql = "SELECT start_date, end_date FROM submission_window LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
    } else {
        $start_date = null;
        $end_date = null;
    }

    
    if ($_SESSION['role'] == 'visitor') {
        echo "<script> alert('Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα. Παρακαλώ συνδεθείτε ή εγγραφείτε.'); window.location.href = 'index.php'; </script>";
        
        die;
    }
    else if($start_date == null || $end_date == null) {
        echo "<script> alert('Δεν έχουν οριστεί ημερομηνίες για την υποβολή αιτήσεων. Παρακαλώ επικοινωνήστε με τον διαχειριστή.'); window.location.href = 'index.php'; </script>";
        
        die;
    }
    else if($start_date > date('Y-m-d') || $end_date < date('Y-m-d')) {
        echo "<script> alert('Δεν είναι περίοδος υποβολής αιτήσεων!'); window.location.href = 'index.php'; </script>";
        
        die;
    }
    else
    {
        mysqli_select_db($con, 'erasmus_db');
                                                    // Δημιουργία πίνακα πανεπιστημίων αν δεν υπάρχει
        $sql = "CREATE TABLE IF NOT EXISTS universities (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name TEXT NOT NULL,
            country TEXT NOT NULL
            )";
        mysqli_query($con, $sql);
        
        $result = mysqli_query($con, "SELECT COUNT(*) as count FROM universities");
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] == 0) {                   //Αν δεν έχουν εισαχθεί πανεπιστήμια, τα εισάγει
            $sql = "INSERT INTO universities (name, country)
                    VALUES 
                    ('University of Manchester', 'United Kingdom'), 
                    ('Cambridge University', 'United Kingdom'), 
                    ('Princeton University', 'United States'), 
                    ('Columbia University', 'United States'), 
                    ('Stanford University', 'United States'), 
                    ('University of Pennsylvania', 'United States')";
            mysqli_query($con, $sql);
        }
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Φόρμα αίτησης μετακίνησης</title>
    <link rel="stylesheet" href="styles\style.css">
</head>

<body>
    <div class ="header">
        <h1>Φόρμα αίτησης μετακίνησης φοιτήτη</h1>
        <a href="index.php">Επιστροφή στην αρχική σελίδα</a>
    </div>
    
    <div class="row">
        <div class="col-s-12 col-m-8 col-l-8 form">
            <form name="registration_form" method="post" action="application_form.php" enctype="multipart/form-data">
                Όνομα &nbsp;: 
                <input type="text" name="username" value="<?php echo $_SESSION['name']; ?>" required readonly><br>

                Επίθετο &nbsp;: 
                <input type="text" name="surname" value="<?php echo $_SESSION['surname']; ?>" required readonly><br>

                Αριθμός Μητρώου &nbsp;: 
                <input type="text" name="am" value="<?php echo $_SESSION['am']; ?>" required readonly><br>

                Ποσοστό % περασμένων μαθημάτων (έως και το προηγούμενο έτος σπουδών) &nbsp;:
                <input type="number" id="classes_passed" name="classes_passed" placeholder="60" min="0" max="100" step="0.1" required><br>

                Μέσος όρος περασμένων μαθημάτων (έως και το προηγούμενο έτος σπουδών) &nbsp;:
                <input type="number" id="average_passed" name="average_passed" placeholder="5" min="0" required><br>

                Πιστοποιητικό γνώσης της αγγλικής γλώσσας &nbsp;:
                <input type="radio" name="english_certificate" value="a1" required>
                A1
                <input type="radio" name="english_certificate" value="a2">
                A2
                <input type="radio" name="english_certificate" value="b1">
                B1
                <input type="radio" name="english_certificate" value="b2">
                B2
                <input type="radio" name="english_certificate" value="c1">
                C1
                <input type="radio" name="english_certificate" value="c2">
                C2
                <br>

                Γνώση επιπλέον ξένων γλωσσών &nbsp;:
                <input type="radio" name="additional_languages" value="yes" required>
                Ναι
                <input type="radio" name="additional_languages" value="no">
                Όχι<br><br>
                <!--Θα μπορούσα να βάλω script ώστε να αφαιρεί επιλογές που έχουν γίνει ήδη-->
                Προτίμηση πανεπιστημίου &nbsp;:
                
                <select name="university1" required>
                    <option value="" disabled selected>
                        1η επιλογή</option>
                    <?php
                        $sql = "SELECT id, name FROM universities";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
                            }
                         }
                    ?>
                </select>
                
                <select name="university2">
                    <option value="" disabled selected>
                        2η επιλογή</option>
                    <?php
                        mysqli_data_seek($result, 0);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
                            }
                        }
                    ?>
                </select>
                
                <select name="university3">
                    <option value="" disabled selected>
                        3η επιλογή</option>
                    <?php
                        mysqli_data_seek($result, 0);  
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
                            }
                        }
                    ?>
                </select>
                <br><br>

                Αναλυτική βαθμολογία &nbsp;:
                <input type="file" name="grades" required><br><br>
                
                Πτυχίο αγγλικής γλώσσας &nbsp;:
                <input type="file" name="english_certificate" required><br><br>

                Πτυχία άλλων ξένων γλωσσών &nbsp;:
                <input type="file" multiple name="other_languages_certificates[]"><br><br>

                <input type="reset" value ="Καθαρισμός φόρμας"><br>
                <br>
                <input type="submit" value="Υποβολή φόρμας"><br>
                <br>

                <input type="checkbox" name="terms" required>
                Αποδέχομαι τους όρους και τις προϋποθέσεις της αίτησης<br><br>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Erasmus. All rights reserved.</p>
    </div>
</body>

</html>