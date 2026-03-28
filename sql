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

-- =========================
-- Departments (5)
-- =========================
INSERT INTO department (name, code, description) VALUES
('Кафедра информатики',            'CS',   'Кафедра компьютерных наук и информатики'),
('Кафедра математики',             'MATH', 'Кафедра высшей математики'),
('Кафедра физики',                 'PHYS', 'Кафедра общей и прикладной физики'),
('Кафедра электроники',            'ELE',  'Кафедра электроники и схемотехники'),
('Кафедра программной инженерии',  'SE',   'Кафедра программной инженерии и разработки ПО');


-- =========================
-- Users (3 + 1 admin)
-- =========================
-- Пароли (MD5):
--   md5('qwe')   = 76d80224611fc919a5d54f0ff9fba446
--   md5('asd')   = 7815696ecbf1c96e6894b779456d330e
--   md5('123')   = 202cb962ac59075b964b07152d234b70
--   md5('admin') = 21232f297a57a5a743894a0e4a801fc3

INSERT INTO user (name, user_name, password, role, department_id) VALUES
('qwe',   'qwe',   '76d80224611fc919a5d54f0ff9fba446', 'USER',  1),
('asd',   'asd',   '7815696ecbf1c96e6894b779456d330e', 'USER',  3),
('123',   '123',   '202cb962ac59075b964b07152d234b70', 'USER',  5),
('admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'ADMIN', NULL);


-- =========================
-- Equipment (20)
-- =========================
INSERT INTO equipment (name, model, manufacturer, commission_date, cost, status_id, user_id, department_id) VALUES
('Ноутбук',                'ThinkPad T14',        'Lenovo',           '2023-01-15', 85000,  1, 1, 1),
('Проектор',               'EB-X51',              'Epson',            '2022-06-10', 45000,  1, 1, 1),
('МФУ',                    'LaserJet Pro M428',    'HP',               '2021-09-01', 32000,  1, NULL, 1),
('Монитор',                'UltraSharp U2723QE',  'Dell',             '2023-03-20', 52000,  1, 2, 3),
('Осциллограф',            'DS1054Z',             'Rigol',            '2020-11-05', 38000,  1, 2, 3),
('Генератор сигналов',     'DG1022Z',             'Rigol',            '2020-11-05', 27000,  3, NULL, 4),
('3D-принтер',             'Ender 3 V2',          'Creality',         '2022-04-18', 25000,  1, 3, 5),
('Сервер',                 'PowerEdge R740',      'Dell',             '2021-01-25', 320000, 1, NULL, 1),
('Маршрутизатор',          'RB4011iGS+',          'MikroTik',         '2022-08-14', 18000,  1, NULL, 1),
('Коммутатор',             'SG350-28',            'Cisco',            '2022-08-14', 42000,  1, NULL, 1),
('Интерактивная доска',    'IFP7550',             'ViewSonic',        '2023-02-01', 150000, 1, NULL, 2),
('Планшет',                'iPad Air 5',          'Apple',            '2023-05-10', 65000,  2, 1, 1),
('Настольный ПК',          'OptiPlex 7090',       'Dell',             '2021-07-22', 72000,  1, 3, 5),
('Лабораторный блок питания','HM310T',            'Hanmatek',         '2020-03-12', 5500,   1, 2, 4),
('Мультиметр',             'UT61E',               'UNI-T',            '2019-10-08', 4500,   4, NULL, 4),
('Сканер',                 'ScanSnap iX1600',     'Fujitsu',          '2023-06-30', 38000,  1, NULL, 2),
('Веб-камера',             'C920 HD Pro',         'Logitech',         '2022-01-20', 7500,   3, NULL, 3),
('Микроскоп цифровой',     'DM4 B',              'Leica',            '2021-04-15', 290000, 1, 2, 3),
('Паяльная станция',       'WE 1010',             'Weller',           '2022-09-09', 15000,  1, NULL, 4),
('Источник беспер. питания','Smart-UPS 1500',     'APC',              '2023-07-01', 35000,  1, NULL, 5);