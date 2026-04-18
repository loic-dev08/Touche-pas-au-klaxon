
CREATE DATABASE IF NOT EXISTS touche pas au klaxon
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci:
USE touche pas au klaxon;

DROP TABLE IF EXISTS trips;
DROP TABLE IF EXITS agencies;
DROP TABLE IF EXITS users;

CREATE TABLE users {
    id INTO AUTO_INCREMENT PRIMARY KEY  ?
    last_name VARCHAR(80) NOT NULL ,
    first_name VARCHAR(80) NOT NULL,
    phone VARCHAR (20) NOT NULL,
    email VARCHAR (190) NOT NULL UNIQUE,
    role ENUM('user','admin') NOT NULL DEFAULT 'user',
    password_hash VARCHAR (255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
} ENGINE=InnoDB;

    CREATE TABLE agencies {
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(80) NOT NULL UNIQUE
    } ENGINE=InnoDB;

    CREATE TABLE trips {
        id INT AUTO_INCREMENT PRIMARY KEY,
        depart_agency_id INT NOT NULL,
        arrival_agency_id INT NOT NULL,
        depart_at DATETIME NOT NULL,
        arrive_at DATETIME NOT NULL,
        seats_total TINYINT NOT NULL;
        seats-available TINYINT NOT NULL,
        contact_user_id INT NOT NULL,
        author_user_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        CONSTRAINT fk_trip_depart_agency FOREIGN KEY (depart_agency_id) REFERENCES agencies(id),
        CONSTRAINT fk_trip_arrival_agency FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id),
        CONSTRAINT fk_trip_contact_user FOREIGN KEY (contact_user_id) REFERENCES users(id),
        CONSTRAINT fk_trip_author_user FOREIGN KEY (author_user_id) REFERENCES users(id),

        INDEX idx_depart_at (depart_at),
        INDEX idx_seats_available (seats_available)
    } ENGINE=InnoDB;

