<?php

require_once APP_PATH . "/models/User.php";

class UserController
{
    public function signup()
    {
        header("Content-Type: application/json");

        $name = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = trim($_POST["password"] ?? "");

        if (strlen($name) < 3) {
            echo json_encode(["status" => "error", "message" => "Name too short"]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Invalid email"]);
            return;
        }

        if (User::findByEmail($email)) {
            echo json_encode(["status" => "error", "message" => "Email already exists"]);
            return;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        if (User::create($name, $email, $hashed)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Could not create user"]);
        }
    }

    public function login()
    {
        header("Content-Type: application/json");

        $email = trim($_POST["email"] ?? "");
        $password = trim($_POST["password"] ?? "");

        $user = User::findByEmail($email);

        if (!$user) {
            echo json_encode(["status" => "error", "message" => "Error Email or Password"]);
            return;
        }

        if (!password_verify($password, $user["password_hash"])) {
            echo json_encode(["status" => "error", "message" => "Error Email or Password"]);
            return;
        }

        $_SESSION["user"] = [
            "id" => $user["id"],
            "name" => $user["name"],
            "email" => $user["email"],
            "role" => $user["role"],
            "points" => $user["points"],
            "profile_image" => $user["profile_image"]
        ];


        echo json_encode(["status" => "success"]);
    }


    public function logout()
    {
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }


    public function updateProfile()
    {
        session_start();
        $db = Database::connect();

        $name = trim($_POST['name']);
        $userId = $_SESSION['user']['id'];

        if (strlen($name) < 3) {
            header("Location: " . BASE_URL . "profile/edit?error=invalid_name");
            exit;
        }

        $imagePath = $_SESSION['user']['profile_image'];

        if (!empty($_FILES['profile_image']['name'])) {

            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($_FILES['profile_image']['type'], $allowedTypes)) {
                header("Location: " . BASE_URL . "profile/edit?error=invalid_image");
                exit;
            }

            if (!is_dir('uploads/users')) {
                mkdir('uploads/users', 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['profile_image']['name']);
            $target = 'uploads/users/' . $fileName;

            move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
            $imagePath = $target;
        }

        $stmt = $db->prepare("
        UPDATE users
        SET name = ?, profile_image = ?
        WHERE id = ?
    ");
        $stmt->execute([$name, $imagePath, $userId]);

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['profile_image'] = $imagePath;

        header("Location: " . BASE_URL . "profile/edit?success=1");
        exit;
    }

}
