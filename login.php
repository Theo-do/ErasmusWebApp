<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Σύνδεση</title>
    <link rel="stylesheet" href="styles\style.css">
</head>

<body>
    <div class="header">
        <h1>Σύνδεση</h1>
        <a href="index.php">Επιστροφή στην αρχική σελίδα</a>
        <br><br>
        <a href="sign-up.php">Δεν έχω λογαριασμό</a>
    </div>

    <div class="row">
        <div class="col-s-12 col-m-9 col-l-4 login-form">
            <form name="login" method="post" action="login_form.php">
                Όνομα χρήστη &nbsp;:
                <input type="text" name="username" placeholder="Fotis13" required><br>
        
                Κωδικός &nbsp;:
                <input type="password" name="password" placeholder="12345" required><br>
                <br>
                <input type="submit" value="Σύνδεση">
            </form>
        </div>
    </div>
</body>
</html>