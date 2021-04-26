# imports data into created database
INSERT INTO developers (first_name, last_name, superpower)
VALUES ('David', 'Stillson', 'Parenting'),
       ('Donald', 'Adamson', 'Parenting'),
       ('Rye', 'Miller', 'Baking');

-- Cloud Docker SQL Dummy

-- Creates our boilerplate database
DROP DATABASE cloud_docker;
CREATE DATABASE IF NOT EXISTS cloud_docker;
USE cloud_docker;

-- creates table for our development team, among other members
CREATE TABLE IF NOT EXISTS developers (
                                          PRIMARY KEY (id_developer),
                                          id_developer INT          NOT NULL AUTO_INCREMENT,
                                          first_name   VARCHAR(100) NOT NULL,
                                          last_name    VARCHAR(100),
                                          superpower   VARCHAR(100),
) ENGINE = INNODB;

-- now lets dump some content into the table
INSERT INTO developers (first_name, last_name, superpower)
VALUES ('David', 'Stillson', 'Parenting'),
       ('Donald', 'Adamson', 'Parenting'),
       ('Rye', 'Miller', 'Staring st goats.');

# Cloud Docker SQL Dummy

-- Creates our boilerplate database
DROP DATABASE cloud_docker;
CREATE DATABASE IF NOT EXISTS cloud_docker;
USE cloud_docker;

-- creates table for our development team, among other members
CREATE TABLE IF NOT EXISTS developers (
    # PRIMARY KEY (id_developer),
    # id_developer INT          NOT NULL AUTO_INCREMENT,
                                          first_name   VARCHAR(100) NOT NULL,
                                          last_name    VARCHAR(100),
                                          superpower   VARCHAR(100)
) ENGINE = INNODB;

-- now lets dump some content into the table
INSERT INTO developers (first_name, last_name, superpower)
VALUES ('David', 'Stillson', 'Parenting'),
       ('Donald', 'Adamson', 'Parenting'),
       ('Rye', 'Miller', 'Staring at goats.');


-- Cloud Docker SQL Dummy

-- Creates our boilerplate database
DROP DATABASE cloud_docker;
CREATE DATABASE IF NOT EXISTS cloud_docker;
USE cloud_docker;

-- creates table for our development team, among other members
CREATE TABLE IF NOT EXISTS developers (
                                          PRIMARY KEY (id_developer),
                                          id_developer INT          NOT NULL AUTO_INCREMENT,
                                          first_name   VARCHAR(100) NOT NULL,
                                          last_name    VARCHAR(100),
                                          superpower   VARCHAR(100),
) ENGINE = INNODB;

-- now lets dump some content into the table
INSERT INTO developers (first_name, last_name, superpower)
VALUES ('David', 'Stillson', 'Parenting'),
       ('Donald', 'Adamson', 'Parenting'),
       ('Rye', 'Miller', 'Staring st goats.');
