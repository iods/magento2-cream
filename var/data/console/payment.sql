SELECT
o.grand_total AS 'Order Total',
o.created_at AS 'Payment Day',
p.method AS 'Payment Method',
CONCAT_WS(' ', o.customer_firstname, o.customer_lastname) AS 'Customer Name',
o.increment_id AS 'Order Number'

FROM sales_flat_order o
LEFT JOIN sales_flat_order_payment p ON p.entity_id = o.entity_id
WHERE (o.created_at BETWEEN '2016-01-01' AND '2016-12-31')