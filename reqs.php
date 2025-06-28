<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Απαιτήσεις</title>
    <link rel="stylesheet" href="styles\style.css">
</head>

<body>
    <div class="header">
        <h1>Απαιτήσεις συμμετοχής στο πρόγραμμα Erasmus</h1>
        <a href="index.php">Επιστροφή στην αρχική σελίδα</a>
    </div>

    <div class="row">

        <div class="col-s-12 col-m-12 col-l-6 main">
            <p>Για να συμμετάσχετε στο πρόγραμμα Erasmus, πρέπει να πληροίτε τις παρακάτω προϋποθέσεις:</p>

            <table>
                <tr><th>Κριτήριο</th><th>Απαίτηση</th></tr>
                <tr><td>Τρέχον έτος σπουδών</td><td>>=2</td></tr>
                <tr><td>Ποσοστό περασμένων μαθημάτων έως το προηγούμενο έτος σπουδών</td><td>>=70%</td></tr>
                <tr><td>Μέσος όρος των περασμένων μαθημάτων έως το προηγούμενο έτος σπουδών</td><td>>=6.5</td></tr>
                <tr><td>Πιστοποιητικό γνώσης της αγγλικής γλώσσας</td><td>>=B2</td></tr>
            </table>
                    
            <p>Αν πληροίτε τις παραπάνω προϋποθέσεις, μπορείτε να υποβάλετε αίτηση συμμετοχής στο πρόγραμμα Erasmus.</p>
            <a href="media\pdf\guide.pdf" download>Κατεβάστε τον οδηγό του προγράμματος Erasmus</a><br><br>
            <img src="media\εικόνες\pdfpic.jpg" alt="pdf" width="300" height="200">
        </div>
        
        <div class="col-s-12 col-m-12 col-l-5 reqs-form">
            <form name="registration_form" method="post" action="" onsubmit ="return validateReqsForm()">
                Τρέχον έτος σπουδών &nbsp;:
                <select name="year">
                    <option value="" disabled selected>Επιλέξτε έτος</option>
                    <option value="1">1ο έτος</option>
                    <option value="2">2ο έτος</option>
                    <option value="3">3ο έτος</option>
                    <option value="4">4ο έτος</option>
                    <option value="5">μεγαλύτερο</option>
                </select><br>
                
                Ποσοστό περασμένων μαθημάτων έως και το προηγούμενο έτος σπουδών &nbsp;:
                <input type="number" id="classes_passed" name="classes_passed" placeholder="0" min="0" max="100" step="0.1">&nbsp;%<br>
                
                Μέσος όρος των «περασμένων» μαθημάτων έως και το προηγούμενο έτος σπουδών &nbsp;:
                <input type="number" id="average_passed" name="average_passed" placeholder="0" min="0" step="0.1"><br>

                Πιστοποιητικό γνώσης της αγγλικής γλώσσας &nbsp;:
                <input type="radio" name="english_certificate" value="a1">A1
                <input type="radio" name="english_certificate" value="a2">A2
                <input type="radio" name="english_certificate" value="b1">B1
                <input type="radio" name="english_certificate" value="b2">B2
                <input type="radio" name="english_certificate" value="c1">C1
                <input type="radio" name="english_certificate" value="c2">C2
                <br><br>
                <input type="submit" value="Υποβολή">
            </form><br>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Erasmus. All rights reserved.</p>
    </div>
<script>
    var year = document.forms["registration_form"]["year"];
    var classes_passed = document.forms["registration_form"]["classes_passed"];
    var average_passed = document.forms["registration_form"]["average_passed"];
    var english_certificate = document.forms["registration_form"]["english_certificate"];
    function validateReqsForm() {
        if (year.value >= 2 && classes_passed.value >= 70 && average_passed.value >= 6.5 && (english_certificate.value == "b2" || english_certificate.value == "c1" || english_certificate.value == "c2")) {
            alert("Η αίτηση είναι έγκυρη!");
            return true; // Η φόρμα είναι έγκυρη
        } 
        else {
            alert("Η αίτηση δεν είναι έγκυρη. Παρακαλώ ελέγξτε τον πίνακα απαιτήσεων συμμετοχής στο πρόγραμμα Erasmus αριστερά.");
            return false; // Η φόρμα δεν είναι έγκυρη  
        }    
    }         
</script>
</body>
</html>