<?php

require_once APP_PATH . "/models/BaseModel.php";

class Plan extends BaseModel
{
    protected static $table = "plans";

    public static function getAllPlans()
    {
        $stmt = static::db()->prepare("SELECT * FROM plans ORDER BY price ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ADMIN PAGES
    public static function countPlans()
    {
        $stmt = static::db()->query("SELECT COUNT(*) FROM plans");
        return $stmt->fetchColumn();
    }

    public static function getAllPlansForAdmin()
    {
        $stmt = static::db()->query("
        SELECT id, name, description, price
        FROM plans
        ORDER BY created_at DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function store($data)
{
    $stmt = static::db()->prepare("
        INSERT INTO plans (name, description, duration, halls_count, price, image)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    return $stmt->execute([
        $data['name'],
        $data['description'],
        $data['duration'],
        $data['halls_count'],
        $data['price'],
        $data['image']
    ]);
}

public static function find($id)
{
    $stmt = static::db()->prepare("SELECT * FROM plans WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public static function deletePlan($id)
{
    $stmt = static::db()->prepare("DELETE FROM plans WHERE id = ?");
    return $stmt->execute([$id]);
}


}
