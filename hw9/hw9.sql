CREATE DATABASE homework_9;

CREATE TABLE library (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) NOT NULL,
    primary key (id)
);

CREATE TABLE `books` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) NOT NULL,
    primary key (id)
);


CREATE TABLE `libraryBook` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `libraryID` INT(11) NOT NULL,
    `bookID` INT(11) NOT NULL,
    primary key (id)
);

-- Insert data into the library table
INSERT INTO library (name) VALUES ('Central Library');
INSERT INTO library (name) VALUES ('City Library');
INSERT INTO library (name) VALUES ('University Library');

-- Insert data into the books table
INSERT INTO books (name) VALUES ('The Great Gatsby');
INSERT INTO books (name) VALUES ('To Kill a Mockingbird');
INSERT INTO books (name) VALUES ('1984');

INSERT INTO libraryBook (libraryID, bookID) VALUES (1, 1); -- Central Library, The Great Gatsby
INSERT INTO libraryBook (libraryID, bookID) VALUES (2, 2); -- Central Library, To Kill a Mockingbird
INSERT INTO libraryBook (libraryID, bookID) VALUES (3, 3);
SELECT * FROM library WHERE id = 1;
SELECT * FROM books WHERE name LIKE '%The%';
SELECT * FROM books ORDER BY name ASC;

SELECT books.name AS book_name, library.name AS library_name
FROM books
JOIN libraryBook ON books.id = libraryBook.bookID
JOIN library ON libraryBook.libraryID = library.id;

UPDATE books
SET name = 'The Greatest Gatsby'
WHERE name = 'The Great Gatsby';

DELETE FROM books
WHERE name = '1984';
