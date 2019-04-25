-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables
CREATE TABLE accounts (
    'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'username' TEXT NOT NULL UNIQUE,
    'password' TEXT NOT NULL,
    'email' TEXT NOT NULL UNIQUE,
    'firstName' TEXT NOT NULL,
    'lastName' TEXT NOT NULL,
    'address1' TEXT NOT NULL,
    'address2' TEXT,
    'zipcode' TEXT NOT NULL,
    'city' TEXT NOT NULL,
    'state' TEXT NOT NULL,
    'country' TEXT NOT NULL, 
    'phone' TEXT NOT NULL,
    'session' TEXT UNIQUE
);

CREATE TABLE products (
    'productid' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'name' TEXT,
    'price' REAL,
    'description' TEXT,
    'image' TEXT,
    'stock' INTEGER,
    'categoryId' INTEGER,
);


COMMIT;
