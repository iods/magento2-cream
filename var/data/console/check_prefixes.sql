Find incorrect prefixes for order and invoice settings in Magebto 2. Sometimes, after using the data migration tool, Magento uses the wrong prefixes. This usually becomes unnoticed at first and can quickly become a disaster, leading to duplicate order numbers. Magento uses tables to work out which prefixes to use on which store, and also to work…
check_prefixes_and_autoincrements_for_magento_2_orders.sql
-- Get all stores where orders, invoices, etc use the wrong prefix
-- E.g. the '2' in order number '200002345'

SELECT store_id, prefix, entity_type, sequence_table FROM sales_sequence_meta
JOIN sales_sequence_profile ON sales_sequence_profile.meta_id = sales_sequence_meta.meta_id
WHERE prefix &lt;&gt; store_id
ORDER BY store_id;

-- Get all stores that use the wrong prefix autoincrement table for orders, invoices, etc.
-- E.g. the '2345' in order number '200002345'

SELECT store_id, prefix, entity_type, sequence_table FROM sales_sequence_meta
JOIN sales_sequence_profile ON sales_sequence_profile.meta_id = sales_sequence_meta.meta_id
WHERE CAST(SUBSTRING_INDEX(sequence_table, "_", -1) AS UNSIGNED) &lt;&gt; store_id
ORDER BY store_id;