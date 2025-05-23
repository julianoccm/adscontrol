CREATE DATABASE IF NOT EXISTS avaliacao;

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    cpf VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS announcements (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    target_gender VARCHAR(10) NOT NULL,
    target_age VARCHAR(10) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    status VARCHAR(40) NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (id, email, password, cpf, role, created_at) VALUES (1, 'admin@email.com', '$2y$10$/g1axkpGphP.AxPWPnz/POLsvE2D/8aj3bOHwdVijotNBfdQbexXW', '123.456.789-10', 'ADMIN', '2025-05-23 01:04:16');
INSERT INTO users (id, email, password, cpf, role, created_at) VALUES (2, 'user@email.com', '$2y$10$/g1axkpGphP.AxPWPnz/POLsvE2D/8aj3bOHwdVijotNBfdQbexXW', '123.456.789-10', 'USER', '2025-05-23 01:04:16');