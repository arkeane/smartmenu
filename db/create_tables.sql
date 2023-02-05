DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id integer NOT NULL AUTO_INCREMENT,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password_hash varchar(255) NOT NULL,
    restaurant_name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id integer NOT NULL AUTO_INCREMENT,
    restaurant_id integer NOT NULL,
    type varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    price integer NOT NULL check (price >= 0),
    vegan boolean NOT NULL,
    vegetarian boolean NOT NULL,
    gluten_free boolean NOT NULL,
    lactose_free boolean NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT products_restaurant_id_fkey FOREIGN KEY (restaurant_id) REFERENCES users (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS templates;
CREATE TABLE templates (
    id integer NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    price integer NOT NULL,
    image varchar(4096) NOT NULL,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS menus;
CREATE TABLE menus (
    id integer NOT NULL AUTO_INCREMENT,
    restaurant_id integer NOT NULL,
    template_id integer NOT NULL,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT menus_restaurant_id_fkey FOREIGN KEY (restaurant_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT menus_template_id_fkey FOREIGN KEY (template_id) REFERENCES templates (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS menu_recipes;
CREATE TABLE menu_recipes (
    menu_id integer NOT NULL,
    product_id integer NOT NULL,
    CONSTRAINT menu_recipes_menu_id_fkey FOREIGN KEY (menu_id) REFERENCES menus (id) ON DELETE CASCADE,
    CONSTRAINT menu_recipes_product_id_fkey FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS bought_templates;
CREATE TABLE bought_templates (
    restaurant_id integer NOT NULL,
    template_id integer NOT NULL,
    CONSTRAINT bought_templates_restaurant_id_fkey FOREIGN KEY (restaurant_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT bought_templates_template_id_fkey FOREIGN KEY (template_id) REFERENCES templates (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS evaluations;
CREATE TABLE evaluations(
    restaurant_id integer NOT NULL,
    template_id integer NOT NULL,
    rating integer NOT NULL check (rating >= 0 and rating <= 5),
    CONSTRAINT evaluations_restaurant_id_fkey FOREIGN KEY (restaurant_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT evaluations_template_id_fkey FOREIGN KEY (template_id) REFERENCES templates (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS admin;
CREATE TABLE admin(
    id integer NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    password_hash varchar(255) NOT NULL,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS newsletters;
CREATE TABLE newsletters(
    id integer NOT NULL AUTO_INCREMENT,
    mail_subject varchar(255) NOT NULL,
    mail_content varchar(4096) NOT NULL,
    mail_date timestamp NOT NULL,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS blog;
CREATE TABLE blog(
    id integer NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    content varchar(4096) NOT NULL,
    post_date timestamp NOT NULL,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS blog_comments;
CREATE TABLE blog_comments(
    id integer NOT NULL AUTO_INCREMENT,
    blog_id integer NOT NULL,
    restaurant_id integer NOT NULL,
    comment varchar(4096) NOT NULL,
    comment_date timestamp NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT blog_comments_blog_id_fkey FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE,
    CONSTRAINT blog_comments_restaurant_id_fkey FOREIGN KEY (restaurant_id) REFERENCES users (id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS crowdfunding;
CREATE TABLE crowdfunding(
    id integer NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    description varchar(4096) NOT NULL,
    goal integer NOT NULL,
    current_amount integer NOT NULL,
    end_date timestamp NOT NULL,
    success boolean NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO templates (name, description, price, image)
VALUES ('default', 'Default template', 0, '/~S4832423/img/default.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('slice', 'Pizza template', 10, '/~S4832423/img/slice.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('cake', 'Cake template useful for bakeries', 10, '/~S4832423/img/cake.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('pasta', 'Pasta themed', 10, '/~S4832423/img/pasta.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('salad', 'Vegetarian menus', 10, '/~S4832423/img/salad.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('oven', 'For pizza places', 10, '/~S4832423/img/oven.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('christmas', 'Christmas time', 10, '/~S4832423/img/christmas.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('easter', 'Happy Easter', 10, '/~S4832423/img/easter.svg');

/*
INSERT INTO templates (name, description, price, image)
VALUES ('default', 'Default template', 0, '/img/default.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('slice', 'Pizza template', 10, '/img/slice.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('cake', 'Cake template useful for bakeries', 10, '/img/cake.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('pasta', 'Pasta themed', 10, '/img/pasta.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('salad', 'Vegetarian menus', 10, '/img/salad.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('oven', 'For pizza places', 10, '/img/oven.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('christmas', 'Christmas time', 10, '/img/christmas.svg');
INSERT INTO templates (name, description, price, image)
VALUES ('easter', 'Happy Easter', 10, '/img/easter.svg');
*/
INSERT INTO admin (email, password_hash)
VALUES (
        'smartmenusaw@gmail.com',
        '$2y$10$SqbbrQw9lTwHIpdISyoKQOfL8MglSCpPeQ1TyvCKJRv/1zpSTjV8O' -- password: admin
    );