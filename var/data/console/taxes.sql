
#### Generate a report for all orders which were charged taxes in a particular state.
```sql
SELECT DISTINCT item.order_id, ord.customer_email, ord.customer_firstname, ord.customer_lastname,
  ra.street, ra.city, ra.region, ra.postcode, ra.telephone,
  ord.base_subtotal_invoiced, ord.base_tax_amount, ord.base_shipping_amount, ord.base_total_invoiced,
  ord.shipping_tax_amount
	FROM magento.sales_flat_order_address as ra
	LEFT JOIN magento.sales_flat_order_item as item
		ON ra.parent_id = item.order_id
	LEFT JOIN magento.sales_flat_order as ord
		ON item.order_id = ord.entity_id
	where (item.tax_percent > 0 OR ord.base_tax_amount <> "" OR ord.shipping_tax_amount <> "") and (ra.region = 'Texas' or ra.region_id = '57')
	GROUP BY ord.entity_id
```