<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Reservation
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    //Get ALL reservations
    public function getAll(): array
    {
        $sql = "SELECT 
                    reservations.*,
                    users.name AS client_name,
                    users.phone AS client_phone,
                    caftables.table_number,
                    games.name AS game_name
                FROM reservations
                INNER JOIN users ON reservations.user_id = users.id
                INNER JOIN caftables ON reservations.table_id = caftables.id
                LEFT JOIN games ON reservations.game_id = games.id
                ORDER BY reservations.reservation_date DESC, 
                         reservations.reservation_time DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    //Get reservations for ONE user
    public function getByUser(int $userId): array
    {
        $sql = "SELECT 
                    reservations.*,
                    caftables.table_number,
                    games.name AS game_name
                FROM reservations
                INNER JOIN caftables ON reservations.table_id = caftables.id
                LEFT JOIN games ON reservations.game_id = games.id
                WHERE reservations.user_id = :user_id
                ORDER BY reservations.reservation_date DESC, 
                         reservations.reservation_time DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    //Check if a table is available
    public function isTableAvailable(int $tableId, string $date, string $time): bool
    {
        $sql = "SELECT COUNT(*) as total 
                FROM reservations
                WHERE table_id = :table_id
                AND reservation_date = :date
                AND reservation_time = :time
                AND status IN ('pending', 'confirmed')";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'table_id' => $tableId,
            'date'     => $date,
            'time'     => $time
        ]);

        $result = $stmt->fetch();
        return $result['total'] === 0;
    }

    //Create a new reservation
    public function create(array $data): bool
    {
        $sql = "INSERT INTO reservations 
                    (user_id, game_id, table_id, reservation_date, 
                     reservation_time, end_time, number_of_guests, status) 
                VALUES 
                    (:user_id, :game_id, :table_id, :reservation_date, 
                     :reservation_time, :end_time, :number_of_guests, :status)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'user_id'          => $data['user_id'],
            'game_id'          => $data['game_id'] ?? null,
            'table_id'         => $data['table_id'],
            'reservation_date' => $data['reservation_date'],
            'reservation_time' => $data['reservation_time'],
            'end_time'         => $data['end_time'] ?? null,
            'number_of_guests' => $data['number_of_guests'],
            'status'           => $data['status'] ?? 'pending',
        ]);
    }

    //Admin changes reservation status
    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE reservations 
                SET status = :status 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'     => $id,
            'status' => $status
        ]);
    }

    // Get ONE reservation by id
    public function getById(int $id): array|false
    {
        $sql = "SELECT 
                    reservations.*,
                    users.name AS client_name,
                    users.phone AS client_phone,
                    caftables.table_number,
                    games.name AS game_name
                FROM reservations
                INNER JOIN users ON reservations.user_id = users.id
                INNER JOIN caftables ON reservations.table_id = caftables.id
                LEFT JOIN games ON reservations.game_id = games.id
                WHERE reservations.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // GetToday's reservations for admin dashboard
    public function getToday(): array
    {
        $sql = "SELECT 
                    reservations.*,
                    users.name AS client_name,
                    users.phone AS client_phone,
                    caftables.table_number,
                    games.name AS game_name
                FROM reservations
                INNER JOIN users ON reservations.user_id = users.id
                INNER JOIN caftables ON reservations.table_id = caftables.id
                LEFT JOIN games ON reservations.game_id = games.id
                WHERE reservations.reservation_date = CURDATE()
                ORDER BY reservations.reservation_time ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function countByStatus(string $status): int
{
    $sql  = "SELECT COUNT(*) as total 
             FROM reservations 
             WHERE status = :status";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['status' => $status]);
    $result = $stmt->fetch();
    return (int) $result['total'];
}
}