-- Basic schema
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) UNIQUE,
  password VARCHAR(255),
  username VARCHAR(50) UNIQUE,
  display_name VARCHAR(100) NULL,
  avatar_url VARCHAR(255) NULL,
  wins INT DEFAULT 0,
  losses INT DEFAULT 0,
  xp INT DEFAULT 0,
  level INT DEFAULT 1,
  coins INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  slug VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS permissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS role_permissions (
  role_id INT NOT NULL,
  permission_id INT NOT NULL,
  PRIMARY KEY(role_id, permission_id)
);

CREATE TABLE IF NOT EXISTS user_roles (
  user_id INT NOT NULL,
  role_id INT NOT NULL,
  PRIMARY KEY(user_id, role_id)
);

CREATE TABLE IF NOT EXISTS settings (
  `key` VARCHAR(100) PRIMARY KEY,
  `value` TEXT
);

CREATE TABLE IF NOT EXISTS pages (
  slug VARCHAR(50) PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  content MEDIUMTEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS lobbies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  owner_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  max_players TINYINT DEFAULT 4,
  allow_spectators TINYINT DEFAULT 1,
  status ENUM('waiting','running','finished') DEFAULT 'waiting',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS games (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lobby_id INT NOT NULL,
  state_json JSON,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS chat_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lobby_id INT NOT NULL,
  user_id INT NULL,
  role VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS xp_events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  type VARCHAR(50) NOT NULL,
  amount INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS challenges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) UNIQUE,
  title VARCHAR(150),
  description TEXT,
  xp_reward INT DEFAULT 0,
  coin_reward INT DEFAULT 0,
  criteria_json JSON NOT NULL
);

CREATE TABLE IF NOT EXISTS user_challenges (
  user_id INT NOT NULL,
  challenge_id INT NOT NULL,
  status ENUM('active','completed','claimed') DEFAULT 'active',
  progress_json JSON,
  PRIMARY KEY(user_id, challenge_id)
);

-- Default roles
INSERT IGNORE INTO roles (id,name,slug) VALUES 
  (1,'Owner','owner'),
  (2,'Admin','admin'),
  (3,'Moderator','moderator'),
  (4,'VIP','vip'),
  (5,'Member','member');

-- Basic permissions (extend as needed)
INSERT IGNORE INTO permissions (id,slug) VALUES
  (1,'manage.users'),(2,'manage.roles'),(3,'manage.settings'),(4,'manage.pages'),(5,'ban.users');

-- Map owner role to all permissions for starter
INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT 1, p.id FROM permissions p;
