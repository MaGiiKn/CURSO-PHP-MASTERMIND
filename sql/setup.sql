DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    user_id INT NOT NULL,
    phone_number VARCHAR(255),

    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- En esta tabla estan las columnas "user_id" que referencia al usuario que creó o añadio esa direccion a este contacto
-- y "adress_id" referencia al contacto al cual pertenece esa direccion.

CREATE TABLE adress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adress VARCHAR(255),
    user_id INT NOT NULL,
    adress_id INT NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (adress_id) REFERENCES contacts(id)
)