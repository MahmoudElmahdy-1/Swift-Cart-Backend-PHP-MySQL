CREATE OR REPLACE VIEW itemsview AS
SELECT items.* , categories.* , (items.items_price - (items.items_price * items.items_discount / 100)) AS priceafterdiscount FROM items
INNER JOIN categories ON items.items_categories = categories.categories_id ;

//////////////////////////////////////////////////////////////////////////////////

CREATE OR REPLACE VIEW favoritesview AS
SELECT favorite.* , items.* , users.users_id FROM favorite
INNER JOIN users ON users.users_id = favorite.favorite_usersid
INNER JOIN items ON items.items_id = favorite.favorite_itemsid

//// after adding priceafterdiscount ////
CREATE OR REPLACE VIEW favoritesview AS
SELECT favorite.* , items.* , users.users_id ,
    (items.items_price - (items.items_price * items.items_discount / 100)) AS priceafterdiscount
FROM favorite
INNER JOIN users ON users.users_id = favorite.favorite_usersid
INNER JOIN items ON items.items_id = favorite.favorite_itemsid;

//////////////////////////////////////////////////////////////////////////////////

CREATE OR REPLACE VIEW cartview AS
SELECT SUM(items.items_price - items.items_price * items.items_discount / 100) as allitemsprice , COUNT(cart.cart_itemsid) as allitemscount , cart.* , items.* FROM cart
INNER JOIN items ON cart.cart_itemsid = items.items_id
WHERE cart_orders = 0
GROUP BY cart.cart_usersid , cart.cart_itemsid , cart.cart_orders ;

//////////////////////////////////////////////////////////////////////////////////

CREATE OR REPLACE VIEW ordersview AS
SELECT orders.* , address.* FROM orders
LEFT JOIN address ON address.address_id = orders.orders_address ;

//// after adding coupon name and percentage ////
CREATE OR REPLACE VIEW ordersview AS
SELECT orders.*, address.*, coupon.coupon_name, coupon.coupon_percentage
FROM orders
LEFT JOIN address ON address.address_id = orders.orders_address
LEFT JOIN coupon ON coupon.coupon_id = orders.orders_coupon;

//////////////////////////////////////////////////////////////////////////////////

CREATE OR REPLACE VIEW ordersdetailsview AS
SELECT SUM(items.items_price - items.items_price * items.items_discount / 100) as allitemsprice , COUNT(cart.cart_itemsid) as allitemscount , cart.* , items.* , ordersview.* FROM cart
INNER JOIN items ON cart.cart_itemsid = items.items_id
INNER JOIN ordersview ON ordersview.orders_id = cart.cart_orders
WHERE cart_orders != 0
GROUP BY cart.cart_usersid , cart.cart_itemsid , cart.cart_orders ;

//// without adding ordersview ////
CREATE OR REPLACE VIEW ordersdetailsview AS
SELECT SUM(items.items_price - items.items_price * items.items_discount / 100) as allitemsprice , COUNT(cart.cart_itemsid) as allitemscount , cart.* , items.* FROM cart
INNER JOIN items ON cart.cart_itemsid = items.items_id
WHERE cart_orders != 0
GROUP BY cart.cart_usersid , cart.cart_itemsid , cart.cart_orders ;

//////////////////////////////////////////////////////////////////////////////////

CREATE OR REPLACE VIEW topsellingview AS
SELECT COUNT(cart.cart_id) AS countitems , cart.* , items.* , (items_price - (items_price * items_discount / 100)) as priceafterdiscount FROM cart
INNER join items ON cart.cart_itemsid = items.items_id
WHERE cart.cart_orders != 0
GROUP BY cart.cart_itemsid
