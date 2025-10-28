CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role ENUM('user','admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  app_date DATE,
  app_time TIME,
  purpose VARCHAR(255),
  status ENUM('pending','approved','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (name,email,password,role)
VALUES ('Chirag Rajpal','admin@rajpal.com',
md5("rajpalchirag"),'admin');
