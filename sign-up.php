<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Εγγραφή</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="header">
        <h1>Εγγραφή</h1>
        <a href="index.php">Επιστροφή στην αρχική σελίδα</a>
    </div>

    <div class="row">
        <div class="col-s-12 col-m-9 col-l-6 signup-form">
            <form name="sign-up" method="post" action="signup_form.php" onsubmit="return validateSignUpForm()">
                Όνομα &nbsp;:
                <input type="text" name="name" placeholder="Φώτης"><br>
                
                Επίθετο &nbsp;:
                <input type="text" name="surname" placeholder="Ιωαννίδης"><br>
        
                Αριθμός Μητρώου &nbsp;:
                <input type="text" name="am" placeholder="2025202500250"><br>
        
                Τηλέφωνο &nbsp;:
                <input type="tel" name="phone" placeholder="6971234567"><br> 
        
                Ηλεκτρονικό ταχυδρομείο &nbsp;:
                <input type="email" name="email" placeholder="you@gmail.com"><br>
                
                Όνομα χρήστη &nbsp;:
                <input type="text" name="username" placeholder="Fotis13"><br>
        
                Κωδικός &nbsp;:
                <input type="password" name="password" placeholder="12345"><br>
        
                Επιβεβαίωση κωδικού &nbsp;:
                <input type="password" name="confirm_password" placeholder="12345"><br> 
                <br>
                <input type="submit" value="Εγγραφή">
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Erasmus. All rights reserved.</p>
    </div>

<script>
    function validateAM() {
        const am = document.forms['sign-up']['am'].value.trim(); // Λαμβάνει τον αριθμό μητρώου από τη φόρμα

        if (!(/^\d{13}$/.test(am))) {
            alert("Ο αριθμός μητρώου πρέπει να αποτελείται από 13 ψηφία.");
            return false;
        }
        if (!(am.startsWith("2022"))) {  
            alert("Ο αριθμός μητρώου πρέπει να ξεκινάει με '2022'.");
            return false;
        }
        return true; // Επιστρέφει true αν ο αριθμός μητρώου είναι έγκυρος
    }

    function validatePhone() {
        const phone = document.forms['sign-up']['phone'].value.trim(); // Λαμβάνει το τηλέφωνο από τη φόρμα

        if (!(/^\d{10}$/.test(phone))) { // Έλεγχος αν το τηλέφωνο αποτελείται από 10 ψηφία
            alert("Το τηλέφωνο πρέπει να αποτελείται από 10 ψηφία.");
            return false;
        }
        return true; // Επιστρέφει true αν το τηλέφωνο είναι έγκυρο
    }
    
    function validateEmail() {
        const email = document.forms['sign-up']['email'].value.trim(); 

        // Έλεγχος αν το email είναι έγκυρο
        if (!(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))) {
            alert("Παρακαλώ εισάγετε ένα έγκυρο email.");
            return false;
        }
        return true; // Επιστρέφει true αν το email είναι έγκυρο
    }

    function validatePassword() {
        const password = document.forms['sign-up']['password'].value.trim(); 

        if (!(/^.{5,}$/.test(password))) {
            alert("Ο κωδικός πρέπει να έχει τουλάχιστον 5 χαρακτήρες.");
            return false;
        } 
        else if (!(/[^A-Za-z0-9]/.test(password))) {
            alert("Ο κωδικός πρέπει να περιέχει τουλάχιστον έναν ειδικό χαρακτήρα.");
            return false;
        } 
        else {
            return true; // Επιστρέφει true αν ο κωδικός είναι έγκυρος
        }
    }

    function validateSignUpForm() {
        const name = document.forms['sign-up']['name'].value.trim();
        const surname = document.forms['sign-up']['surname'].value.trim();
        const am = document.forms['sign-up']['am'].value.trim();
        const phone = document.forms['sign-up']['phone'].value.trim();
        const email = document.forms['sign-up']['email'].value.trim();
        const username = document.forms['sign-up']['username'].value.trim();
        const password = document.forms['sign-up']['password'].value.trim();
        const confirm_password = document.forms['sign-up']['confirm_password'].value.trim();
    

        if (name == "" || surname == "" || am == "" || username == "" || password == "" || confirm_password == "") {
            alert("Παρακαλώ συμπληρώστε όλα τα πεδία.");
            return false;
        }
        if (/\d/.test(name)) {  // Έλεγχος αν το όνομα περιέχει αριθμούς
            alert("Το όνομα δεν πρέπει να περιέχει αριθμούς."); 
            return false;
        }
        if (/\d/.test(surname)) {  // Έλεγχος αν το επίθετο περιέχει αριθμούς
            alert("Το επίθετο δεν πρέπει να περιέχει αριθμούς.");
            return false;
        }
        if (!validateAM(am)) { // Έλεγχος αν ο αριθμός μητρώου είναι έγκυρος
            return false;
        }
        if (!validatePhone(phone)) { // Έλεγχος αν το τηλέφωνο είναι έγκυρο
            return false;
        }
        if (!validateEmail(email)) { // Έλεγχος αν το email είναι έγκυρο
            return false;
        }
        if (!validatePassword(password)) { // Έλεγχος αν ο κωδικός είναι έγκυρος
            return false;
        }
        if (password !== confirm_password) {
            alert("Οι κωδικοί δεν ταιριάζουν.");
            return false;
        }
        
        return true; // Επιστρέφει true αν όλα είναι εντάξει    
    }
</script>
</body>
</html>