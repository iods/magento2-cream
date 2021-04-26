Export Magento Related, Crosssell, Upsell Products from Database
export.sql
/* Related Products */
SELECT e.sku as sku, GROUP_CONCAT(ee.sku) as related_product FROM catalog_product_link l
INNER JOIN catalog_product_entity e on e.entity_id=l.product_id
INNER JOIN catalog_product_entity ee on ee.entity_id=l.linked_product_id
WHERE l.link_type_id=1
GROUP BY e.sku

/* Crosssell Products */
SELECT e.sku as sku, GROUP_CONCAT(ee.sku) as crossel_product FROM catalog_product_link l
INNER JOIN catalog_product_entity e on e.entity_id=l.product_id
INNER JOIN catalog_product_entity ee on ee.entity_id=l.linked_product_id
WHERE l.link_type_id=5
GROUP BY e.sku

/* Upsell Products */
SELECT e.sku as sku, GROUP_CONCAT(ee.sku) as upsell_product FROM catalog_product_link l
INNER JOIN catalog_product_entity e on e.entity_id=l.product_id
INNER JOIN catalog_product_entity ee on ee.entity_id=l.linked_product_id
WHERE l.link_type_id=4
GROUP BY e.sku

Magento SQL query to attach products that are not added to a website to the default website (id 1)
INSERT INTO catalog_product_website
(product_id, website_id)
(SELECT catalog_product_entity.entity_id, '1'
FROM catalog_product_entity LEFT JOIN catalog_product_website ON catalog_product_entity.entity_id = catalog_product_website.product_id
GROUP BY catalog_product_entity.entity_id
HAVING COUNT(catalog_product_website.product_id) = 0
ORDER BY sku DESC)

/** Empties tables containing information about orders. */
START TRANSACTION;

DELETE FROM sales_order WHERE TRUE;
DELETE FROM sales_creditmemo_comment WHERE TRUE;
DELETE FROM sales_creditmemo_item WHERE TRUE;
DELETE FROM sales_creditmemo WHERE TRUE;
DELETE FROM sales_creditmemo_grid WHERE TRUE;
DELETE FROM sales_invoice_comment WHERE TRUE;
DELETE FROM sales_invoice_item WHERE TRUE;
DELETE FROM sales_invoice WHERE TRUE;
DELETE FROM sales_invoice_grid WHERE TRUE;
DELETE FROM quote_address_item WHERE TRUE;
DELETE FROM quote_item_option WHERE TRUE;
DELETE FROM quote WHERE TRUE;
DELETE FROM quote_address WHERE TRUE;
DELETE FROM quote_item WHERE TRUE;
DELETE FROM quote_payment WHERE TRUE;
DELETE FROM quote_shipping_rate WHERE TRUE;
DELETE FROM quote_id_mask WHERE TRUE;
DELETE FROM sales_shipment_comment WHERE TRUE;
DELETE FROM sales_shipment_item WHERE TRUE;
DELETE FROM sales_shipment_track WHERE TRUE;
DELETE FROM sales_shipment WHERE TRUE;
DELETE FROM sales_shipment_grid WHERE TRUE;
DELETE FROM sales_order_address WHERE TRUE;
DELETE FROM sales_order_item WHERE TRUE;
DELETE FROM sales_order_payment WHERE TRUE;
DELETE FROM sales_order_status_history WHERE TRUE;
DELETE FROM sales_order_grid WHERE TRUE;
DELETE FROM sales_order_tax WHERE TRUE;

/* ROLLBACK; */
COMMIT;