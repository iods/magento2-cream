Magento - Get configurable product's total stock qty and is_in_stock status using one child's product ID
getconfigstock.sql
SELECT
 	count(product_id),
 	sum(cataloginventory_stock_item.qty) as child_qty,
 	sum(cataloginventory_stock_item.is_in_stock) > 0 as some_child_in_stock
FROM cataloginventory_stock_item
WHERE product_id in (
	SELECT
		parent.product_id
	FROM
		catalog_product_super_link as parent
	WHERE
		parent.parent_id=(
				SELECT
					parent.parent_id
				FROM
					catalog_product_super_link as parent
				WHERE
					parent.product_id=1076131))