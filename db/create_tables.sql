DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id integer NOT NULL AUTO_INCREMENT,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password_hash varchar(255) NOT NULL,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id integer NOT NULL AUTO_INCREMENT,
    restaurant_id integer NOT NULL,
    type varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    price integer NOT NULL,
    vegan boolean NOT NULL,
    vegetarian boolean NOT NULL,
    gluten_free boolean NOT NULL,
    lactose_free boolean NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT products_restaurant_id_fkey FOREIGN KEY (restaurant_id) REFERENCES users (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS ingredients;
CREATE TABLE ingredients (
    id integer NOT NULL AUTO_INCREMENT,
    restaurant_id integer NOT NULL,
    name varchar(255) NOT NULL,
    source varchar(255),
    PRIMARY KEY (id),
    CONSTRAINT ingredients_restaurant_id_fkey FOREIGN KEY (restaurant_id) REFERENCES users (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS recipes;
CREATE TABLE recipes (
    product_id integer NOT NULL,
    ingredients_id integer NOT NULL,
    CONSTRAINT recipes_product_id_fkey FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    CONSTRAINT recipes_ingredients_id_fkey FOREIGN KEY (ingredients_id) REFERENCES ingredients (id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS templates;
CREATE TABLE templates (
    id integer NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
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

INSERT INTO templates (name) VALUES ('default');