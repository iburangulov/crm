<?php

return [
    "CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(32),
    created DATETIME,
    updated DATETIME,
    deleted BOOLEAN DEFAULT false
);",
    "CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    type VARCHAR(32),
    contact VARCHAR(32),
    created DATETIME,
    updated DATETIME,
    deleted BOOLEAN DEFAULT false 
);",
    "CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(32),
    second_name VARCHAR(32),
    role INT,
    tariff INT,
    created DATETIME,
    updated DATETIME,
    deleted BOOLEAN DEFAULT FALSE 
);",
    "CREATE TABLE tariff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(32),
    cost FLOAT,
    description TEXT,
    created DATETIME,
    updated DATETIME,
    deleted BOOLEAN DEFAULT false
);",
    "ALTER TABLE contacts ADD (
     FOREIGN KEY (account_id) REFERENCES accounts(id)
);",
    "ALTER TABLE accounts ADD (
     FOREIGN KEY (role) REFERENCES roles(id),
     FOREIGN KEY (tariff) REFERENCES tariff(id)
);"
];