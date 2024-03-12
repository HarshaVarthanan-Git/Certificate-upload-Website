CREATE DATABASE IF NOT EXISTS event_registration;

USE event_registration;

CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    roll_number VARCHAR(10) NOT NULL,
    section VARCHAR(1) NOT NULL,
    event_attended VARCHAR(255) NOT NULL,
    other_event VARCHAR(255),
    company_college VARCHAR(255) NOT NULL,
    days_attended INT NOT NULL,
    from_date DATE NOT NULL,
    to_date DATE NOT NULL,
    certificate VARCHAR(255) NOT NULL
);
