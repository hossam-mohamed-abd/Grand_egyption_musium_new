<?php

require_once APP_PATH . "/models/BaseModel.php";

class User extends BaseModel
{
    protected static $table = "users";

    public static function findByEmail($email)
    {
        $stmt = static::db()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $email, $password_hash)
    {
        $stmt = static::db()->prepare("
            INSERT INTO users (name, email, password_hash, profile_image, role, points)
            VALUES (?, ?, ?, NULL, 'user', 0)
        ");

        return $stmt->execute([$name, $email, $password_hash]);
    }



    // ADMIN PAGES
    public static function countUsers()
    {
        $stmt = static::db()->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    public static function getAllUsers()
    {
        $stmt = static::db()->query("
        SELECT id, name, email, role
        FROM users
        ORDER BY id DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateRole($id, $role)
    {
        $stmt = static::db()->prepare("
        UPDATE users
        SET role = ?
        WHERE id = ?
    ");
        return $stmt->execute([$role, $id]);
    }



}


