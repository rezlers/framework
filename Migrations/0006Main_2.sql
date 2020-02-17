USE app;

DROP TABLE IF EXISTS registration_links;
CREATE TABLE registration_links (
                                    id SERIAL PRIMARY KEY,
                                    `time` TIMESTAMP DEFAULT NOW(),
                                    `hash` VARCHAR(32) NOT NULL,
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
                       `password` VARCHAR(32) NOT NULL
);

DROP TABLE IF EXISTS links;
CREATE TABLE links (
                       id SERIAL PRIMARY KEY,
                       `time` TIMESTAMP DEFAULT NOW(),
                       user_id BIGINT NOT NULL,
                       tag VARCHAR(15)
);



