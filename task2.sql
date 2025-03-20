delete from categories where id not in (select category_id from products);

delete from products where id not in (select product_id from availabilities where amount > 0);

delete from stocks where id not in (select stock_id from availabilities);
