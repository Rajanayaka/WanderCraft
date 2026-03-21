CREATE DATABASE IF NOT EXISTS wandercraft_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE wandercraft_db;

CREATE TABLE IF NOT EXISTS users (
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS bookings (
    id           INT(11)      NOT NULL AUTO_INCREMENT,
    user_id      INT(11)      NOT NULL DEFAULT 0,
    hotel_name   VARCHAR(100) NOT NULL,
    destination  VARCHAR(100) NOT NULL,
    checkin_date DATE         NOT NULL,
    nights       INT(3)       NOT NULL DEFAULT 1,
    guest_name   VARCHAR(100) NOT NULL,
    guest_email  VARCHAR(100) NOT NULL,
    created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS saved_trips (
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    user_id     INT(11)      NOT NULL DEFAULT 0,
    destination VARCHAR(100) NOT NULL,
    trip_days   INT(3)       NOT NULL DEFAULT 1,
    trip_date   DATE         DEFAULT NULL,
    travelers   INT(3)       NOT NULL DEFAULT 1,
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS messages (
    id         INT(11)      NOT NULL AUTO_INCREMENT,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL,
    subject    VARCHAR(200) NOT NULL,
    message    TEXT         NOT NULL,
    created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
