-- 1. ตารางผู้ใช้งาน
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female', 'other'),
    birth_date DATE,
    phone_number VARCHAR(15),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. ตารางกิจกรรม
CREATE TABLE events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    event_name VARCHAR(255) NOT NULL,
    creator_id INT,
    description TEXT,
    location VARCHAR(255),
    start_date DATETIME,
    end_date DATETIME,
    max_people INT,
    status ENUM('open', 'closed') DEFAULT 'open',
    FOREIGN KEY (creator_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. ตารางรูปภาพกิจกรรม
CREATE TABLE event_img (
    img_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    img_path VARCHAR(255),
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. ตารางการลงทะเบียน
CREATE TABLE registrations (
    reg_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    user_id INT,
    reg_status ENUM('pending', 'approved', 'rejected', 'attended') DEFAULT 'pending',
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;