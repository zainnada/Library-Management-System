CREATE DATABASE IF NOT EXISTS zain_library_db;
USE zain_library_db;

-- Books Table
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    available BOOLEAN DEFAULT 1
);

-- Friends Table (Library Users)
CREATE TABLE IF NOT EXISTS friends (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

-- Borrow Table
CREATE TABLE IF NOT EXISTS borrows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    friend_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    return_date DATETIME DEFAULT NULL,
    FOREIGN KEY (friend_id) REFERENCES friends(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

--  Admin Table (Library Admin)
CREATE TABLE IF NOT EXISTS admins (
	id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- add data

-- Virtual Data
-- Insert Books (20 Books)
INSERT INTO books (title, author, available) VALUES 
('The Great Gatsby', 'F. Scott Fitzgerald', 1),
('To Kill a Mockingbird', 'Harper Lee', 1),
('1984', 'George Orwell', 1),
('Pride and Prejudice', 'Jane Austen', 1),
('The Catcher in the Rye', 'J.D. Salinger', 1),
('Moby-Dick', 'Herman Melville', 1),
('War and Peace', 'Leo Tolstoy', 1),
('Crime and Punishment', 'Fyodor Dostoevsky', 1),
('The Lord of the Rings', 'J.R.R. Tolkien', 1),
('Brave New World', 'Aldous Huxley', 1),
('Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 1),
('The Hobbit', 'J.R.R. Tolkien', 1),
('Fahrenheit 451', 'Ray Bradbury', 1),
('The Picture of Dorian Gray', 'Oscar Wilde', 1),
('Les Misérables', 'Victor Hugo', 1),
('The Brothers Karamazov', 'Fyodor Dostoevsky', 1),
('The Alchemist', 'Paulo Coelho', 1),
('Dracula', 'Bram Stoker', 1),
('Frankenstein', 'Mary Shelley', 1),
('The Odyssey', 'Homer', 1);

-- Insert Friends (10 Friends)
INSERT INTO friends (name, email) VALUES 
('Alice Johnson', 'alice@example.com'),
('Bob Smith', 'bob@example.com'),
('Charlie Brown', 'charlie@example.com'),
('David Miller', 'david@example.com'),
('Eve Carter', 'eve@example.com'),
('Frank Wilson', 'frank@example.com'),
('Grace Adams', 'grace@example.com'),
('Henry Thompson', 'henry@example.com'),
('Isabella White', 'isabella@example.com'),
('Jack Moore', 'jack@example.com');

-- Insert Borrow Records (4 Borrowed Books)
INSERT INTO borrows (friend_id, book_id, borrow_date, return_date) VALUES 
(1, 3, '2025-03-10 14:00:00', NULL),  -- Alice borrowed '1984'
(2, 7, '2025-03-11 09:30:00', '2025-03-15 10:00:00'),  -- Bob borrowed 'War and Peace' and returned it
(3, 15, '2025-03-12 11:15:00', NULL), -- Charlie borrowed 'Les Misérables'
(4, 18, '2025-03-13 16:45:00', NULL); -- David borrowed 'Dracula'

-- Insert admins
INSERT INTO admins (username, password) VALUES 
('zain', '123456'),
('ahmed', '654321');


-- Update Books Availability (Set borrowed books to not available)
UPDATE books SET available = 0 WHERE id IN (3, 15, 18);
  
