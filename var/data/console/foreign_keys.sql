Magento: Create SQL queries to recreate all foreign keys which exist in database magento_source but not in database magento_dest
gistfile1.sql
SELECT
	CONCAT('ALTER TABLE ', u1.table_name, ' ADD CONSTRAINT ', u1.CONSTRAINT_NAME, ' FOREIGN KEY (', u1.column_name, ') REFERENCES ', u1.referenced_table_name, ' (', u1.referenced_column_name, ') ON DELETE CASCADE ON UPDATE CASCADE;') as 'sql_query'
FROM information_schema.key_column_usage u1
LEFT JOIN information_schema.key_column_usage u2
ON
	u1.table_name = u2.table_name
	AND u1.column_name = u2.column_name
	AND u2.table_schema = 'magento_dest'
	AND u2.referenced_table_name IS NOT NULL
WHERE
	u1.referenced_table_name IS NOT NULL
	AND u1.table_schema = 'magento_source'
	AND u2.table_name IS NULL;