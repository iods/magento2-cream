SELECT -- Round to two decimal places and prepend with $ CONCAT('$', FORMAT(SUM(sales_order.`grand_total`), 2)) AS 'Lifetime Sales', COUNT(sales_order.entity_id) AS 'Orders', customer_entity.email AS 'Email', MAX(sales_order.created_at) AS 'Most Recent Order Date' FROM `customer_entity` LEFT JOIN sales_order ON customer_entity.entity_id = sales_order.customer_id GROUP BY customer_entity.entity_id ORDER BY SUM(sales_order.`grand_total`) DESC LIMIT 500
SELECT
-- Round to two decimal places and prepend with $
CONCAT('$', FORMAT(SUM(sales_order.`grand_total`), 2)) AS 'Lifetime Sales',
COUNT(sales_order.entity_id) AS 'Orders',
customer_entity.email AS 'Email',
MAX(sales_order.created_at) AS 'Most Recent Order Date'
FROM `customer_entity`
LEFT JOIN sales_order ON customer_entity.entity_id = sales_order.customer_id
GROUP BY customer_entity.entity_id
ORDER BY SUM(sales_order.`grand_total`) DESC
LIMIT 500
INTO OUTFILE '/Users/jonwoolley/desktop/customer-sales.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';