<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προβολή Πανεπιστημίων</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="header">
        <h1>Προβολή Πανεπιστημίων</h1>
            <a href="admin_dashboard.php">Επιστροφή στον πίνακα διαχείρισης</a>
    </div>
   <br><br>
    <div class ="row"> 
        <div class="col-s-12 col-m-12 col-l-12 form">    
            <!-- Εμφάνιση Όλων -->   
            <p>Εμφάνιση Όλων των Πανεπιστημίων :</p>
            <input type="submit" value="Εμφάνιση Όλων" onclick = "getAllUniversities()">

            <p>Εμφάνιση Πανεπιστημίου με ID :</p>
            <input type="submit" value="Εμφάνιση Πανεπιστημίου με ID" onclick="getUniversityById()">

            <p>Προσθήκη Πανεπιστημίου :</p>
            <input type="submit" value="Προσθήκη Πανεπιστημίου" onclick="addUniversity()">

            <p>Ενημέρωση Πανεπιστημίου :</p>
            <input type="submit" value="Ενημέρωση Πανεπιστημίου" onclick="updateUniversity()">

            <p>Διαγραφή Πανεπιστημίου :</p>
            <input type="submit" value="Διαγραφή Πανεπιστημίου" onclick="deleteUniversity()">

            <p>Καθαρισμός :</p>
            <input type="submit" value="Καθαρισμός" onclick="clean()">
        </div>
        <div id="my-universities-list" class="col-s-12 col-m-12 col-l-12 main"></div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Erasmus. All rights reserved.</p> 
    </div>


<div id="my-universities-list" class="col-s-12 col-m-12 col-l-12 main"></div>

<script>
    function getAllUniversities() {
        // Κώδικας για να πάρει όλα τα πανεπιστήμια από το API
        fetch('restapi/api.php')
            .then(response => response.json())
            .then(data => {
                const myDiv = document.getElementById('my-universities-list');
                myDiv.innerHTML = ''; // Καθαρισμός προηγούμενων αποτελεσμάτων

                if (data.length > 0) {
                    let table = document.createElement('table');
                    table.className = 'universities-table';
                    let thead = document.createElement('thead');
                    thead.innerHTML = `
                        <tr>
                            <th>ID</th>
                            <th>Όνομα</th>
                            <th>Χώρα</th>
                        </tr>
                    `;
                    table.appendChild(thead);

                    let tbody = document.createElement('tbody');
                    data.forEach(university => {
                        let row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${university.id}</td>
                            <td>${university.name}</td>
                            <td>${university.country || ''}</td>
                        `;
                        tbody.appendChild(row);
                    });
                    table.appendChild(tbody);
                    myDiv.appendChild(table);
                } else {
                    myDiv.innerHTML = '<p>Δεν βρέθηκαν πανεπιστήμια.</p>';
                }
            })
            .catch(error => console.error('Error fetching universities:', error));
    }

    function getUniversityById() {
        const universityId = prompt("Εισάγετε το ID του πανεπιστημίου:");
        if (universityId) {
            fetch(`restapi/api.php?id=${universityId}`)
            .then(response => response.json())
            .then(data => {
                const myDiv = document.getElementById('my-universities-list');
                myDiv.innerHTML = ''; // Clear previous results

                if (data && !data.error) {
                    // data is a single object, not an array
                    let table = document.createElement('table');
                    table.className = 'universities-table';
                    let thead = document.createElement('thead');
                    thead.innerHTML = `
                        <tr>
                            <th>ID</th>
                            <th>Όνομα</th>
                            <th>Χώρα</th>
                        </tr>
                    `;
                    table.appendChild(thead);

                    let tbody = document.createElement('tbody');
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${data.id}</td>
                        <td>${data.name}</td>
                        <td>${data.country || ''}</td>
                    `;
                    tbody.appendChild(row);
                    table.appendChild(tbody);
                    myDiv.appendChild(table);
                } else {
                    myDiv.innerHTML = '<p>Δεν βρέθηκε πανεπιστήμιο με αυτό το ID.</p>';
                }
            })
            .catch(error => console.error('Error fetching university:', error));
        }
    }

    function addUniversity() {
        const name = prompt("Εισάγετε το όνομα του πανεπιστημίου:");
        const country = prompt("Εισάγετε τη χώρα του πανεπιστημίου:");

        if (name && country) {
            fetch('restapi/api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, country })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || "Πανεπιστήμιο προστέθηκε επιτυχώς!");
                getAllUniversities(); // Refresh the list
            })
            .catch(error => console.error('Error adding university:', error));
        } else {
            alert("Παρακαλώ συμπληρώστε όλα τα πεδία.");
        }
    }

    function updateUniversity() {
        const universityId = prompt("Εισάγετε Id");
        const name = prompt("Εισάγετε το όνομα του πανεπιστημίου:");
        const country = prompt("Εισάγετε τη χώρα του πανεπιστημίου:");

        if (universityId && name && country) {
            fetch(`restapi/api.php?id=${universityId}`, {
                method : 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, country })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || "Πανεπιστήμιο ενημερώθηκε επιτυχώς!");
            })
            .catch(error => console.error('Error updating university:', error));
        } else {
            alert("Παρακαλώ συμπληρώστε όλα τα πεδία");
        }
    }

    function deleteUniversity() {
        const universityId = prompt("Εισάγετε Id");

        if (universityId) {
            fetch(`restapi/api.php?id=${universityId}`, {
                method : 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || "Πανεπιστήμιο διαγράφθηκε επιτυχώς!");
            })
            .catch(error => console.error('Error deleting university:', error));
        } else {
            alert("Παρακαλώ συμπληρώστε όλα τα πεδία");
        }
    }

    function clean() {
        const myDiv = document.getElementById('my-universities-list');
        myDiv.innerHTML = ''; // Καθαρισμός προηγούμενων αποτελεσμάτων
    }
</script>
</body>   
</html>