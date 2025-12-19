<?php

require_once APP_PATH . '/models/User.php';
require_once APP_PATH . '/models/Plan.php';

class AdminController
{
    public function dashboard()
    {

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL);
            exit;
        }


        $usersCount = User::countUsers();
        $plansCount = Plan::countPlans();


        $users = User::getAllUsers();
        $plans = Plan::getAllPlansForAdmin();

        require VIEW_PATH . 'admin/dashboard.php';
    }

    public function storePlan()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $duration = trim($_POST['duration']);
        $hallsCount = (int) $_POST['halls_count'];
        $price = (float) $_POST['price'];

        $imagePath = null;

        if (!empty($_FILES['image']['name'])) {

            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                die("Invalid image type");
            }

          
            $uploadDir = 'uploads/plans/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $target = $uploadDir . $fileName;

            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $imagePath = $target;
        }

        Plan::store([
            'name' => $name,
            'description' => $description,
            'duration' => $duration,
            'halls_count' => $hallsCount,
            'price' => $price,
            'image' => $imagePath
        ]);

        header("Location: " . BASE_URL . "admin");
        exit;
    }

    public function deletePlan()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $planId = $_POST['id'] ?? null;

        if (!$planId) {
            header("Location: " . BASE_URL . "admin");
            exit;
        }

        $plan = Plan::find($planId);

        if ($plan && !empty($plan['image']) && file_exists($plan['image'])) {
            unlink($plan['image']);
        }

        Plan::deletePlan($planId);

        header("Location: " . BASE_URL . "admin");
        exit;
    }


    public function updateUserRole()
    {
    
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $userId = $_POST['id'] ?? null;
        $role = $_POST['role'] ?? null;

        $allowedRoles = ['admin', 'user', 'restaurant'];

        if (!$userId || !in_array($role, $allowedRoles)) {
            header("Location: " . BASE_URL . "admin");
            exit;
        }

        User::updateRole($userId, $role);

        header("Location: " . BASE_URL . "admin");
        exit;
    }


}
