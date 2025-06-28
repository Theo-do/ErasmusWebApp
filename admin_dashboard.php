<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\style.css">
</head>
<body>
    <div class="header">
        <h1>Πίνακας Διαχείρισης Erasmus</h1>
    </div>

    <div class="row">
        <div class="col-s-12 col-m-3 col-l-3 menu">
            <h1>Μενού Διαχείρισης</h1>
            <ul>
                <li><a href="view_applications.php">Προβολή αιτήσεων</a></li>
                <li><a href="api_form.php">Προβολή πανεπιστημίων</a></li>
                <br><br>
                <li><a href="logout.php">Αποσύνδεση</a></li>
            </ul>
        </div>

        <div class="col-s-12 col-m-9 col-l-6 main">
            <h1>Καλώς ήρθες Διαχειριστή!</h1>
            <p>Εδώ μπορείτε να διαχειριστείτε τις αιτήσεις των χρηστών του προγράμματος Erasmus καθώς και να
               υποβάλετε τις ημερομηνίες έναρξης και λήξης της περιόδου αιτήσεων για να επιτρέψετε στους χρήστες να υποβάλλουν αιτήσεις.</p>
            <br><br>
            <img src="media\εικόνες\admin.jpg" alt="Admin Dashboard">
            <br><br>
        </div>

        <div class="col-s-12 col-m-12 col-l-3 reqs-form">
            <form name="dates_form" method="post" action="admin_form.php">
                <h1>Περίοδος Αιτήσεων</h1>
                <p>Έναρξη :</p>
                <input type="date" id="start_date" name="start_date" required>
                <br>
                <p>Λήξη :</p>
                <input type="date" id="end_date" name="end_date" required>

                <br><br>
                <input type="submit" value="Υποβολή">
            </form>
            
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Erasmus. All rights reserved.</p> 
    </div>   
</body>
</html>