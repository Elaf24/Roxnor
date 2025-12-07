<?php

namespace App\Models;

use App\Core\Database;

class Submission
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO submissions 
            (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, entry_by) 
            VALUES 
            (:amount, :buyer, :receipt_id, :items, :buyer_email, :buyer_ip, :note, :city, :phone, :hash_key, :entry_at, :entry_by)"
        );
        
        return $stmt->execute([
            ':amount' => $data['amount'],
            ':buyer' => $data['buyer'],
            ':receipt_id' => $data['receipt_id'],
            ':items' => $data['items'],
            ':buyer_email' => $data['buyer_email'],
            ':buyer_ip' => $data['buyer_ip'],
            ':note' => $data['note'],
            ':city' => $data['city'],
            ':phone' => $data['phone'],
            ':hash_key' => $data['hash_key'],
            ':entry_at' => $data['entry_at'],
            ':entry_by' => $data['entry_by']
        ]);
    }

    public function getAll($filters = [])
    {
        $query = "SELECT s.*, u.name as user_name FROM submissions s 
                  LEFT JOIN users u ON s.entry_by = u.id WHERE 1=1";
        $params = [];

        if (!empty($filters['start_date'])) {
            $query .= " AND s.entry_at >= :start_date";
            $params[':start_date'] = $filters['start_date'];
        }

        if (!empty($filters['end_date'])) {
            $query .= " AND s.entry_at <= :end_date";
            $params[':end_date'] = $filters['end_date'];
        }

        if (!empty($filters['entry_by'])) {
            $query .= " AND s.entry_by = :entry_by";
            $params[':entry_by'] = $filters['entry_by'];
        }

        $query .= " ORDER BY s.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countByUserIdAndDate($userId, $date)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as count FROM submissions 
             WHERE entry_by = :user_id AND DATE(created_at) = :date"
        );
        $stmt->execute([
            ':user_id' => $userId,
            ':date' => $date
        ]);
        $result = $stmt->fetch();
        return (int)$result['count'];
    }
}

