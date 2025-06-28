<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Προφίλ</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="header">
        <h1>Επεξεργασία Προφίλ</h1>
        <a href="index.php">Επιστροφή στην Αρχική Σελίδα</a>
    </div>

    <div class="row">
        <div class="col-s-12 col-m-12 col-l-3 menu">
            <h1>Μενού</h1>
            <ul>
                <li><a href="logout.php">Αποσύνδεση</a></li>
            </ul>
        </div>

        <div class="col-s-12 col-m-12 col-l-9 main">
            <h1>Φόρμα Επεξεργασίας Προφίλ</h1>

            <?php
                session_start();
                include 'db.php';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $am = $_POST['am'];
                    $password = $_POST['password'];

                    $query = "UPDATE users 
                              SET name='$name', surname='$surname', email='$email', phone='$phone', am='$am', password='$password' 
                              WHERE username='" . $_SESSION['username'] . "'";

                    if (mysqli_query($con, $query)) {
                        echo "<p>Το προφίλ σας ενημερώθηκε επιτυχώς!</p>";
                    } else {
                        echo "<p>Σφάλμα κατά την ενημέρωση του προφίλ: " . mysqli_error($con) . "</p>";
                    }
                }

                $user_query = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'";
                $result = mysqli_query($con, $user_query);
                $user = mysqli_fetch_assoc($result);
            ?>
        </div>

        <div class ="col-s-12 col-m-12 col-l-6 form">
            <form method="POST" action="">
                <p>Όνομα:</p>
                <input type="text" name="name" value="<?= $user['name'] ?>">

                <p>Επίθετο:</p>
                <input type="text" name="surname" value="<?= $user['surname'] ?>">

                <p>Email:</p>
                <input type="text" name="email" value="<?= $user['email'] ?>">

                <p>Τηλέφωνο:</p>
                <input type="text" name="phone" value="<?= $user['phone'] ?>">
                
                <p>Α.Μ. :</p>
                <input type="text" name="am" value="<?= $user['am'] ?>">

                <p>password:</p>
                <input type="text" name="password" value="<?= $user['password'] ?>">

                <br><br>

                <input type="submit" value="Ενημέρωση Προφίλ">
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Erasmus Program. All rights reserved.</p>
    </div>
</body>
</html>