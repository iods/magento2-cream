# Display the number of SKUs in a attribute set
SELECT eas.attribute_set_name, COUNT(cpe.sku)
FROM eav_attribute_set AS eas
LEFT JOIN catalog_product_entity AS cpe ON cpe.attribute_set_id = eas.attribute_set_id
WHERE entity_type_id = 4
GROUP BY eas.attribute_set_name

# To see if an email to a user has been successfulyy sent in the sales_order table and sales_shipment table
SELECT s.email_sent AS "Shipment Email Sent", o.email_sent AS "Order Email Sent", s.order_id
FROM sales_shipment AS s
  LEFT JOIN sales_order AS o
  ON (o.entity_id = s.order_id)
WHERE o.customer_email = 'email@address.com';