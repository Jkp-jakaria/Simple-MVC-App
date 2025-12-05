CREATE DATABASE IF NOT EXISTS simple_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE simple_app;

CREATE TABLE users (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE submissions (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    amount INT(10) NOT NULL,
    buyer VARCHAR(255) NOT NULL,
    receipt_id VARCHAR(20) NOT NULL,
    items VARCHAR(255) NOT NULL,
    buyer_email VARCHAR(50) NOT NULL,
    buyer_ip VARCHAR(20) NOT NULL,
    note TEXT NOT NULL,
    city VARCHAR(20) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    hash_key VARCHAR(255) NOT NULL,
    entry_at DATE NOT NULL,
    entry_by INT(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- USERS TABLE
INSERT INTO users (name, email, password_hash, created_at)
VALUES
('John Doe', 'john@example.com', '$2y$10$71pO.BjDqVbkqIDdnh3S6uNkn4z11xQZB6hGONXmdfeu9O.1O1f7e', NOW());

-- SUBMISSIONS TABLE
INSERT INTO submissions (
  amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, entry_by
) VALUES
(
  500, 'Alice 01', 'RCP-1001', 'Book, Pen', 'alice@example.com', '127.0.0.1',
  'First sample submission note.', 'Dhaka', '8801812345678',
  SHA2(CONCAT('RCP-1001', 'some-very-secret-salt-string'), 512),
  CURDATE(), 1
);
