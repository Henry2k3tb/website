CREATE TABLE Role (
  id int PRIMARY KEY,
  name varchar(20) NOT NULL
);
CREATE TABLE Users (
  id int PRIMARY KEY,
  fullname varchar(50),
  email varchar(150),
  phone_number int,
  address varchar(200),
  passwords varchar(32),
)
;

CREATE TABLE Category (
  id int PRIMARY KEY,
  name varchar(100)  NOT NULL
)
;

CREATE TABLE Product (
  id int PRIMARY KEY,
  category_id int,
  title varchar(300),
  price int,
  discount int,
  thumbnail varchar(500),
  pro_discription longtext
)
;

CREATE TABLE Galery (
  id int PRIMARY KEY,
  product_id int,
  thumbnail varchar(500)
)
;

CREATE TABLE FeedBack (
  id int PRIMARY KEY,
  firstname varchar(30),
  lastname varchar(30),
  email varchar(150),
  phone_number varchar(20),
  subject_name varchar(200),
  notes varchar(500)
)
;

CREATE TABLE Orders (
  id int PRIMARY KEY,
  user_id int,
  fullname varchar(50),
  email varchar(150),
  phone_number varchar(20),
  address varchar(200),
  notes varchar(255),
  order_date datetime,
  status int,
  total_money int
)
;

CREATE TABLE Order_Details (
  id int PRIMARY KEY,
  order_id int,
  product_id int,
  price int,
  num int,
  total_money int
)
;

ALTER TABLE Role ADD FOREIGN KEY (id) REFERENCES User (role_id)
;

ALTER TABLE Product ADD FOREIGN KEY (category_id) REFERENCES Category (id)

;
ALTER TABLE Product ADD FOREIGN KEY (id) REFERENCES Galery (product_id)

;
ALTER TABLE Product ADD FOREIGN KEY (id) REFERENCES Order_Details (product_id)
;

ALTER TABLE Orders ADD FOREIGN KEY (user_id) REFERENCES User (id)
;

ALTER TABLE Orders ADD FOREIGN KEY (id) REFERENCES Order_Details (order_id)

