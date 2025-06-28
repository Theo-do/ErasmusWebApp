<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προβολή Αιτήσεων</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="header">
        <h1>Προβολή Αιτήσεων</h1>
        <a href="admin_dashboard.php">Επιστροφή στον πίνακα διαχείρισης</a>
    </div>

        <div class="row">
            <div class="col-s-12 col-m-12 col-l-12 main">
                <h1>Λίστα Αιτήσεων</h1>
                <p>Εδώ μπορείτε να δείτε όλες τις αιτήσεις συμμετοχής στο πρόγραμμα Erasmus</p>
                <p>Μπορείτε να φιλτράρετε τις αιτήσεις παρακάτω.</p>
                <!-- Φόρμα φίλτρων -->
                <div class="col-s-12 col-m-12 col-l-12 form">
                    <form method="GET" action="">
                        <p>Ελάχιστο ποσοστό επιτυχίας (%):</p>
                        <input type="number" name="min_pass_rate" value="<?= isset($_GET['min_pass_rate']) ? $_GET['min_pass_rate'] : '' ?>" min="0" max="100">

                        <p>Επιλογή Πανεπιστημίου:</p>
                        <select name="university_filter">
                            <option value="">-- Όλα τα Πανεπιστήμια --</option>
                            <?php
                                include 'db.php';

                                $uni_result = mysqli_query($con, "SELECT DISTINCT name FROM universities");

                                while ($uni = mysqli_fetch_assoc($uni_result)) {
                                    $selected = (isset($_GET['university_filter']) && $_GET['university_filter'] == $uni['name']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($uni['name']) . "' $selected>" . htmlspecialchars($uni['name']) . "</option>";
                                }
                            ?>
                        </select>

                        <input type="submit" value="Ταξινόμηση κατά Μ.Ο.">
                        <br><br>
                        <input type="submit" value="Εφαρμογή Φίλτρων">
                    </form>
                </div>

                <br><br>
                
                <?php
                    include_once 'db.php';

                    // --- ΦΙΛΤΡΑ ---
                    $where = [];
                    $order = '';

                    // Ελάχιστο ποσοστό επιτυχίας
                    if (!empty($_GET['min_pass_rate'])) {
                        $min_pass_rate = (int) $_GET['min_pass_rate'];
                        $where[] = "classes_passed >= $min_pass_rate";
                    }

                    // Επιλογή πανεπιστημίου
                    if (!empty($_GET['university_filter'])) {
                        $university = mysqli_real_escape_string($con, $_GET['university_filter']);
                        $where[] = "('$university' IN (university_1, university_2, university_3))";
                    }

                    // Ταξινόμηση κατά μέσο όρο
                    if (isset($_GET['sort_by_avg'])) {
                        $order = "ORDER BY average_passed DESC";
                    }

                    // Τελικό query
                    $where_sql = count($where) ? "WHERE " . implode(" AND ", $where) : "";
                    $sql = "SELECT * FROM applications $where_sql $order";

                    $result = mysqli_query($con, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>";
                        echo "<tr>
                        <th>Όνομα</th>
                        <th>Επίθετο</th>
                        <th>Αριθμός Μητρώου</th>
                        <th>Μέσος Όρος</th>
                        <th>Ποσοστό Επιτυχίας</th>
                        <th>Πανεπιστήμιο 1</th>
                        <th>Πανεπιστήμιο 2</th>
                        <th>Πανεπιστήμιο 3</th>
                        <th>Πτυχίο Αγγλικών</th>
                        <th>Αποδοχή</th>
                        </tr>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['am']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['average_passed']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['classes_passed']) . "%</td>";
                            echo "<td>" . htmlspecialchars($row['university_1']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['university_2']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['university_3']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['english_certificate']) . "</td>";
                            echo "<td>" . "<input type='checkbox' name='accept_app'>" . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "<p>Δεν υπάρχουν αιτήσεις με τα συγκεκριμένα κριτήρια.</p>";
                    }

                    mysqli_close($con);
                ?>
            </div>
        </div>
    <div class="footer">
        <p>&copy; 2025 Erasmus. All rights reserved.</p>
    </div>
</html>