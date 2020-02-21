CREATE TEMPORARY TABLE users_tmp
SELECT * FROM users;

CREATE TEMPORARY TABLE links_tmp
SELECT * FROM links;

DROP DATABASE IF EXISTS app;
CREATE DATABASE app;
USE app;

DROP TABLE IF EXISTS registration_links;
CREATE TABLE registration_links (
                                    id SERIAL PRIMARY KEY,
                                    `time` TIMESTAMP DEFAULT NOW(),
                                    `hash` VARCHAR(32) NOT NULL UNIQUE,
                                    user_id BIGINT NOT NULL
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
                       id SERIAL PRIMARY KEY,
                       `time` TIMESTAMP DEFAULT NOW(),
                       first_name VARCHAR(255) NOT NULL,
                       last_name VARCHAR(255) NOT NULL,
                       login VARCHAR(255) UNIQUE NOT NULL,
                       email VARCHAR(511) UNIQUE NOT NULL,
                       `password` VARCHAR(32) NOT NULL,
                       confirmation BOOL DEFAULT false
);

DROP TABLE IF EXISTS links;
CREATE TABLE links (
                       id SERIAL PRIMARY KEY,
                       `time` TIMESTAMP DEFAULT NOW(),
                       user_id BIGINT UNSIGNED NOT NULL,
                       link VARCHAR(511) UNIQUE,
                       header TEXT,
                       description TEXT,
                       tag ENUM('private','public'),
                       FOREIGN KEY (user_id)
                           REFERENCES users(id)
                           ON DELETE RESTRICT
);

INSERT INTO users
SELECT * FROM users_tmp;

INSERT INTO links
SELECT * FROM links;

DROP TABLE IF EXISTS test_table_11;
DROP TABLE IF EXISTS test_table_12;
DROP TABLE IF EXISTS test_table_21;
DROP TABLE IF EXISTS test_table_31;



