Magento - Validate stock against index values for all simple products
checkinvidx.sql
SELECT DISTINCT
	catalog_product_entity.entity_id,
	catalog_product_entity.sku,
	catalog_product_entity.type_id,
	cataloginventory_stock_item.qty AS `stock qty`,
	cataloginventory_stock_item.is_in_stock,
	cataloginventory_stock_status_idx.qty AS `idx qty`,
	cataloginventory_stock_status_idx.stock_status
FROM cataloginventory_stock_item INNER JOIN cataloginventory_stock_status_idx ON cataloginventory_stock_item.product_id = cataloginventory_stock_status_idx.product_id
	 INNER JOIN catalog_product_entity ON catalog_product_entity.entity_id = cataloginventory_stock_item.product_id
WHERE cataloginventory_stock_item.qty <> cataloginventory_stock_status_idx.qty
      and  catalog_product_entity.type_id="simple"