<?php
session_start();
header("Content-Type: application/json");
require "./util/db.php";

$response = ["success" => false, "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['email']) && isset($data['password'])) {
        $email = trim($data['email']);
        $password = $data['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Use password_verify if passwords are hashed
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $response = [
                    "success" => true,
                    "message" => "Login successful",
                    "data" => [
                        "user_id" => $user['id'],
                        "email" => $user['email'],
                        "name" => $user['firstname'] ?? ""
                    ]
                ];
            } else {
                $response = ["success" => false, "message" => "Wrong password"];
            }
        } else {
            $response = ["success" => false, "message" => "User not found"];
        }
    } else {
        $response = ["success" => false, "message" => "Username and password required"];
    }
} else {
    $response = ["success" => false, "message" => "Invalid request method"];
}

echo json_encode($response);
?>
