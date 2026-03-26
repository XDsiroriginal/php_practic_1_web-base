-- =========================
-- 1. Department
-- =========================
CREATE TABLE department (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    time_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- =========================
-- 2. Status
-- =========================
CREATE TABLE status (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);


-- =========================
-- 3. User
-- =========================
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    user_name VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('USER', 'ADMIN') NOT NULL DEFAULT 'USER',
    department_id INT,
    time_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_user_department
        FOREIGN KEY (department_id)
        REFERENCES department(department_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


-- =========================
-- 4. Equipment
-- =========================
CREATE TABLE equipment (
    equipment_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    model VARCHAR(255),
    manufacturer VARCHAR(255),
    commission_date DATE,
    cost INT,
    status_id INT,
    user_id INT,
    department_id INT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_equipment_status
        FOREIGN KEY (status_id)
        REFERENCES status(status_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_equipment_user
        FOREIGN KEY (user_id)
        REFERENCES user(user_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_equipment_department
        FOREIGN KEY (department_id)
        REFERENCES department(department_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


-- =========================
-- 5. Repair
-- =========================
CREATE TABLE repair (
    repair_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    equipment_id INT,
    report_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    break_message TEXT,
    repair_start_date DATE,
    repair_end_date DATE,
    cost INT,
    work_performed TEXT,
    status ENUM('IN_REPAIR', 'COMPLETED', 'CANCELLED') NOT NULL DEFAULT 'IN_REPAIR',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_repair_user
        FOREIGN KEY (user_id)
        REFERENCES user(user_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_repair_equipment
        FOREIGN KEY (equipment_id)
        REFERENCES equipment(equipment_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
INSERT INTO status (name) VALUES
('IN WORK'),
('IN REPAIR'),
('BROKEN'),
('WRITTEN OFF');