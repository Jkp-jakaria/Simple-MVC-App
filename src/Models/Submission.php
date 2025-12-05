<?php
declare (strict_types = 1);

namespace App\Models;

use PDO;

class Submission
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO submissions (
                    amount, buyer, receipt_id, items,
                    buyer_email, buyer_ip, note, city,
                    phone, hash_key, entry_at, entry_by
                ) VALUES (
                    :amount, :buyer, :receipt_id, :items,
                    :buyer_email, :buyer_ip, :note, :city,
                    :phone, :hash_key, :entry_at, :entry_by
                )';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'amount'      => $data['amount'],
            'buyer'       => $data['buyer'],
            'receipt_id'  => $data['receipt_id'],
            'items'       => $data['items'],
            'buyer_email' => $data['buyer_email'],
            'buyer_ip'    => $data['buyer_ip'],
            'note'        => $data['note'],
            'city'        => $data['city'],
            'phone'       => $data['phone'],
            'hash_key'    => $data['hash_key'],
            'entry_at'    => $data['entry_at'],
            'entry_by'    => $data['entry_by'],
        ]);
    }

    public function getAll(?string $from = null, ?string $to = null, ?int $userId = null): array
    {
        $sql    = 'SELECT * FROM submissions WHERE 1=1';
        $params = [];

        if ($from) {
            $sql .= ' AND entry_at >= :from_date';
            $params['from_date'] = $from;
        }

        if ($to) {
            $sql .= ' AND entry_at <= :to_date';
            $params['to_date'] = $to;
        }

        if ($userId) {
            $sql .= ' AND entry_by = :entry_by';
            $params['entry_by'] = $userId;
        }

        $sql .= ' ORDER BY entry_at DESC, id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM submissions WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE submissions SET
                amount = :amount,
                buyer = :buyer,
                receipt_id = :receipt_id,
                items = :items,
                buyer_email = :buyer_email,
                buyer_ip = :buyer_ip,
                note = :note,
                city = :city,
                phone = :phone,
                hash_key = :hash_key,
                entry_at = :entry_at,
                entry_by = :entry_by
            WHERE id = :id';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'          => $id,
            'amount'      => $data['amount'],
            'buyer'       => $data['buyer'],
            'receipt_id'  => $data['receipt_id'],
            'items'       => $data['items'],
            'buyer_email' => $data['buyer_email'],
            'buyer_ip'    => $data['buyer_ip'],
            'note'        => $data['note'],
            'city'        => $data['city'],
            'phone'       => $data['phone'],
            'hash_key'    => $data['hash_key'],
            'entry_at'    => $data['entry_at'],
            'entry_by'    => $data['entry_by'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM submissions WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

}
