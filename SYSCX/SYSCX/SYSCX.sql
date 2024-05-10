DROP DATABASE IF EXISTS syscx;
CREATE DATABASE IF NOT EXISTS syscx;
USE syscx;


-- Table 1
CREATE TABLE users_info (
    student_id      INTEGER(10)     PRIMARY KEY AUTO_INCREMENT,
    student_email   VARCHAR(150),
    first_name      VARCHAR(150),
    last_name       VARCHAR(150),
    dob             DATE
);
ALTER TABLE users_info AUTO_INCREMENT = 100100;


-- Table 2
CREATE TABLE users_program (
    student_id  INTEGER(10),
    program     VARCHAR(50),
    FOREIGN KEY (student_id) REFERENCES users_info(student_id)
);


-- Table 3
CREATE TABLE users_avatar (
    student_id  INTEGER(10),
    avatar      INTEGER(1),
    FOREIGN KEY (student_id) REFERENCES users_info(student_id)
);


-- Table 4
CREATE TABLE users_address (
    student_id      INTEGER(10),
    street_number   INTEGER(5),
    street_name     VARCHAR(150),
    city            VARCHAR(30),
    province        VARCHAR(2),
    postal_code     VARCHAR(7),
    FOREIGN KEY (student_id) REFERENCES users_info(student_id)
);


-- Table 5
CREATE TABLE users_posts (
    post_id     INT    PRIMARY KEY AUTO_INCREMENT,
    student_id  INTEGER(10),
    new_post    TEXT(1000),
    post_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users_info(student_id)
);


-- Table 6
CREATE TABLE users_passwords (
    student_id  INTEGER(10),
    password    VARCHAR(255),
    FOREIGN KEY (student_id) REFERENCES users_info(student_id)
);


-- Table 7
CREATE TABLE users_permissions (
    student_id      INTEGER(10),
    account_type    INTEGER(1) DEFAULT 1,
    FOREIGN KEY (student_id) REFERENCES users_info(student_id)
);
