<?php
    header("Content-Type: application/json");

    require __DIR__ . '\..\db.php';
    
    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $result = $con->query("SELECT * FROM universities WHERE id=$id");
                    $data = $result->fetch_assoc();
                    echo json_encode($data);
                } 
                else {
                    $result = $con->query("SELECT * FROM universities");   //Αίτηση χωρίς παράμετρο id
                    $universities = [];
                    while ($row = $result->fetch_assoc()) {
                        $universities[] = $row;
                    }
                    echo json_encode($universities);
                }
                break;


            case 'POST':
                $name = $input['name'];
                $country = $input['country'];
                $con->query("INSERT INTO universities (name, country) 
                            VALUES('$name', '$country')");
                echo json_encode(["message" => "University added successfully"]);
                break;

            case 'PUT':
                $id = $_GET['id'];
                $name = $input['name']; 
                $country = $input['country'];
                $con->query("UPDATE universities SET name='$name',
                            country='$country' WHERE id=$id");
                echo json_encode(["message" => "University updated successfully"]);
                break;

            case 'DELETE':
                $id = $_GET['id'];
                $con->query("DELETE FROM universities WHERE id=$id");
                echo json_encode(["message" => "University deleted successfully"]);
                break;
            default:
                echo json_encode(["message" => "Invalid request method"]);
                break;
    }
                
    $con->close();
    
?>