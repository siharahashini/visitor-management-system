-- ============================================================
-- Online Visitor Management System - Database Script
-- Import this file first using phpMyAdmin (or the mysql command
-- line) BEFORE you open the website in your browser.
-- ============================================================

CREATE DATABASE IF NOT EXISTS visitor_management;
USE visitor_management;

-- ------------------------------------------------------------
-- Table: Users
-- Stores everyone who can log in (Admins and Ordinary users)
-- ------------------------------------------------------------
CREATE TABLE Users (
    UserID     INT AUTO_INCREMENT PRIMARY KEY,
    Username   VARCHAR(50)  NOT NULL UNIQUE,
    Password   VARCHAR(255) NOT NULL,
    FullName   VARCHAR(100) NOT NULL,
    Role       ENUM('admin','user') NOT NULL DEFAULT 'user',
    Status     ENUM('active','blocked') NOT NULL DEFAULT 'active'
);

-- ------------------------------------------------------------
-- Table: Departments
-- ------------------------------------------------------------
CREATE TABLE Departments (
    DepartmentID INT AUTO_INCREMENT PRIMARY KEY,
    Name         VARCHAR(100) NOT NULL
);

-- ------------------------------------------------------------
-- Table: Visitors
-- ------------------------------------------------------------
CREATE TABLE Visitors (
    VisitorID  INT AUTO_INCREMENT PRIMARY KEY,
    Name       VARCHAR(100) NOT NULL,
    NIC        VARCHAR(20)  NOT NULL,
    Phone      VARCHAR(20),
    Email      VARCHAR(100),
    Purpose    VARCHAR(255),
    Host       VARCHAR(100),
    Department INT,
    FOREIGN KEY (Department) REFERENCES Departments(DepartmentID)
);

-- ------------------------------------------------------------
-- Table: Visits  (one row every time a visitor checks in)
-- ------------------------------------------------------------
CREATE TABLE Visits (
    VisitID   INT AUTO_INCREMENT PRIMARY KEY,
    VisitorID INT NOT NULL,
    CheckIn   TIME,
    CheckOut  TIME,
    Date      DATE NOT NULL,
    Status    ENUM('checked-in','checked-out') NOT NULL DEFAULT 'checked-in',
    FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID)
);

-- ------------------------------------------------------------
-- Default / sample data
-- ------------------------------------------------------------

-- The assignment REQUIRES a default ordinary user uoc / uoc
INSERT INTO Users (Username, Password, FullName, Role, Status)
VALUES ('uoc', 'uoc', 'Default User', 'user', 'active');

-- We also need at least one administrator to test admin pages
INSERT INTO Users (Username, Password, FullName, Role, Status)
VALUES ('admin', 'admin123', 'System Administrator', 'admin', 'active');

-- Sample departments so the visitor form has something to pick from
INSERT INTO Departments (Name) VALUES
('Front Office'),
('Administration'),
('IT Department'),
('Finance');

-- NOTE on passwords:
-- Passwords are stored as plain text here ONLY to keep the project
-- simple enough to explain in your viva. In your individual report
-- you can mention that PHP's built-in password_hash()/password_verify()
-- functions (part of core PHP, not a framework/library) would be used
-- in a production system for real security.
