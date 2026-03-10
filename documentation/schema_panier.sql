CREATE TABLE `category`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  UNIQUE (`slug`)
);

CREATE TABLE `tag`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  UNIQUE (`slug`)
);

CREATE TABLE `user`(
  `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `first_name` VARCHAR(255) NULL,
  `last_name` VARCHAR(255) NULL,
  `email` VARCHAR(255) NOT NULL,
  `roles` JSON NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `is_verified` TINYINT(1) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `verified_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  UNIQUE (`email`)
);

CREATE TABLE `post`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT NOT NULL,
  `category_id` BIGINT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `keywords` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `is_published` TINYINT NOT NULL,
  `content` LONGTEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `published_at` DATETIME NULL,
  UNIQUE (`slug`)
);

CREATE TABLE `post_tag`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `post_id` BIGINT NOT NULL,
  `tag_id` BIGINT NOT NULL
);

CREATE TABLE `comment`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `post_id` BIGINT NOT NULL,
  `user_id` BIGINT NOT NULL,
  `content` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL
);

CREATE TABLE `likes`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `post_id` BIGINT NOT NULL,
  `user_id` BIGINT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL
);

CREATE TABLE `contact`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL
);

CREATE TABLE `setting`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL
);

CREATE TABLE `reset_password_request`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT NOT NULL,
  `selector` VARCHAR(255) NOT NULL,
  `hashed_token` VARCHAR(255) NOT NULL,
  `requested_at` DATETIME NOT NULL,
  `expires_at` DATETIME NOT NULL
);

CREATE TABLE `product`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  UNIQUE (`slug`)
);

CREATE TABLE `cart`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT NULL,
  `session_id` VARCHAR(255) NULL,
  `status` ENUM('OPEN','ORDERED','CANCELLED') NOT NULL DEFAULT 'OPEN',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL
);

CREATE TABLE `cart_item`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cart_id` BIGINT NOT NULL,
  `product_id` BIGINT NOT NULL,
  `quantity` INT NOT NULL,
  `unit_price` DECIMAL(10, 2) NOT NULL,
  UNIQUE (`cart_id`, `product_id`)
);

ALTER TABLE `post`
  ADD CONSTRAINT `post_user_id_foreign`
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `post`
  ADD CONSTRAINT `post_category_id_foreign`
  FOREIGN KEY(`category_id`) REFERENCES `category`(`id`);

ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign`
  FOREIGN KEY(`post_id`) REFERENCES `post`(`id`);

ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_tag_id_foreign`
  FOREIGN KEY(`tag_id`) REFERENCES `tag`(`id`);

ALTER TABLE `comment`
  ADD CONSTRAINT `comment_user_id_foreign`
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `comment`
  ADD CONSTRAINT `comment_post_id_foreign`
  FOREIGN KEY(`post_id`) REFERENCES `post`(`id`);

ALTER TABLE `likes`
  ADD CONSTRAINT `likes_user_id_foreign`
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `likes`
  ADD CONSTRAINT `likes_post_id_foreign`
  FOREIGN KEY(`post_id`) REFERENCES `post`(`id`);

ALTER TABLE `contact`
  ADD CONSTRAINT `contact_user_id_foreign`
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `setting`
  ADD CONSTRAINT `setting_user_id_foreign`
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `reset_password_request_user_id_foreign`
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `cart`
  ADD CONSTRAINT `cart_user_id_foreign`
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_cart_id_foreign`
  FOREIGN KEY(`cart_id`) REFERENCES `cart`(`id`) ON DELETE CASCADE;

ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_product_id_foreign`
  FOREIGN KEY(`product_id`) REFERENCES `product`(`id`);
