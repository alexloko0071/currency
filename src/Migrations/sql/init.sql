do $$
declare

  type_id      int;

begin

  CREATE SCHEMA currency;

  create table if not exists currency.type
  (
    id serial PRIMARY KEY,
    name varchar(12) NOT NULL
  );

  create table IF NOT EXISTS  currency.currency
  (
    id serial PRIMARY KEY,
    url varchar(512) NOT NULL,
    order_number int NOT NULL,
    type_id int NOT NULL,
    CONSTRAINT currency_type_fk FOREIGN KEY (type_id) REFERENCES currency.type(id)
  );

  INSERT INTO currency.type (name) VALUES ('xml') RETURNING id INTO type_id;

  INSERT INTO currency.currency (url, order_number, type_id) VALUES (
    'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml', 1, type_id);

  INSERT INTO currency.type (name) VALUES ('json') RETURNING id INTO type_id;

  INSERT INTO currency.currency (url, order_number, type_id) VALUES (
    'https://www.cbr-xml-daily.ru/daily_json.js', 2, type_id);

end $$;

