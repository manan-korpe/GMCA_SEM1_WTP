<?php
header("Content-Type: application/json");
require "util/db.php";

$response = ["success" => false, "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    $firstname = trim($data['firstname'] ?? '');
    $lastname = trim($data['lastname'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $confirmpassword = $data['confirmpassword'] ?? '';

    // Server-side validation
    if ($firstname === "" || $lastname === "" || $email === "" || $password === "" || $confirmpassword === "") {
        $response['message'] = "All fields are required.";
        echo json_encode($response);
        exit;
    }

    if ($password !== $confirmpassword) {
        $response['message'] = "Passwords do not match.";
        echo json_encode($response);
        exit;
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $response['message'] = "Email already registered!";
        echo json_encode($response);
        exit;
    }

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashedPassword);

    if ($stmt->execute()) {
        $response = [
            "success" => true,
            "message" => "Registration successful",
            "data" => [
                "user_id" => $conn->insert_id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email
            ]
        ];
    } else {
        $response['message'] = "Database error: " . $stmt->error;
    }

} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>
