<?php

$dvds = [
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('JVC200123', 'ACHME DISC', 1.00, 'dvds', 'nice movie');
INSERT INTO dvds (product_id, size) VALUES (LAST_INSERT_ID(), 700);
COMMIT;
",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('JVC200124', 'ACHME DISC', 2.00, 'dvds', 'nice movie');
INSERT INTO dvds (product_id, size) VALUES (LAST_INSERT_ID(), 750);
COMMIT;
",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('JVC200125', 'ACHME DISC', 5.00, 'dvds', 'very nice movie');
INSERT INTO dvds (product_id, size) VALUES (LAST_INSERT_ID(), 689);
COMMIT;
",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('JVC200126', 'ACHME DISC', 3.00, 'dvds', 'nicest movie');
INSERT INTO dvds (product_id, size) VALUES (LAST_INSERT_ID(), 766);
COMMIT;
",
  "START TRANSACTION;
INSERT INTO products (sku, name, price, category, description) VALUES ('JVC200127', 'ACHME DISC', 2.00, 'dvds', 'this is also nice movie');
INSERT INTO dvds (product_id, size) VALUES (LAST_INSERT_ID(), 355);
COMMIT;
",
  "START TRANSACTION;
INSERT INTO products (sku, name, price, category, description) VALUES ('JVC200128', 'ACHME DISC', 2.50, 'dvds', 'another nice movie');
INSERT INTO dvds (product_id, size) VALUES (LAST_INSERT_ID(), 560);
COMMIT;
",
  "START TRANSACTION;
INSERT INTO products (sku, name, price, category, description) VALUES ('JVC200129', 'ACHME DISC', 3.50, 'dvds', 'another movie');
INSERT INTO dvds (product_id, size) VALUES (LAST_INSERT_ID(), 660);
COMMIT;
",
];

$books = [
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('GGWP0007', 'War and Peace', 20.00, 'books', 'nice book');
  INSERT INTO books (product_id, weight) VALUES (LAST_INSERT_ID(), 2);
  COMMIT;
  ",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('GGWP0008', 'Cotton Prince', 15.00, 'books', 'child book');
  INSERT INTO books (product_id, weight) VALUES (LAST_INSERT_ID(), 1);
  COMMIT;
  ",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('GGWP0009', 'Rings of the Lord', 30.00, 'books', 'fake book');
  INSERT INTO books (product_id, weight) VALUES (LAST_INSERT_ID(), 2);
  COMMIT;
  ",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('GGWP0010', 'Anna Karenina', 25.00, 'books', 'this is a book');
  INSERT INTO books (product_id, weight) VALUES (LAST_INSERT_ID(), 2);
  COMMIT;
  ",
];

$furnitures = [
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('TR120555', 'Chair', 30.00, 'furnitures', 'nice chair');
  INSERT INTO furnitures (product_id, height, width, length) VALUES (LAST_INSERT_ID(), 60, 50, 40);
  COMMIT;
  ",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('TR120556', 'Dinner Table', 200.00, 'furnitures', 'strong table');
  INSERT INTO furnitures (product_id, height, width, length) VALUES (LAST_INSERT_ID(), 150, 70, 60);
  COMMIT;
  ",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('TR120557', 'Sofa', 500.00, 'furnitures', 'simple sofa');
  INSERT INTO furnitures (product_id, height, width, length) VALUES (LAST_INSERT_ID(), 200, 85, 70);
  COMMIT;
  ",
  "START TRANSACTION;
  INSERT INTO products (sku, name, price, category, description) VALUES ('TR120558', 'Coffee Table', 100.00, 'furnitures', 'small coffee table');
  INSERT INTO furnitures (product_id, height, width, length) VALUES (LAST_INSERT_ID(), 40, 50, 40);
  COMMIT;
  ",
];

$productInsertQueries = [...$books, ...$dvds, ...$furnitures];