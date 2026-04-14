CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(255),
  role ENUM('admin','user')
);

CREATE TABLE procedures (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  category VARCHAR(50),
  description TEXT,
  created_at DATE,
  author VARCHAR(50)
);
