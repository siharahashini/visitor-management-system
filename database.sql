CREATE DATABASE visitor_management;

USE visitor_management;

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visitor_id VARCHAR(50) NOT NULL,
    visitor_name VARCHAR(100) NOT NULL,
    check_in DATETIME NOT NULL,
    check_out DATETIME DEFAULT NULL,
    status VARCHAR(20) DEFAULT 'Checked In'
);