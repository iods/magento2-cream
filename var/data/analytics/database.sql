/* find the largest tables on the server */
SELECT CONCAT(table_schema, '.', table_name)                                          'db.table',
       CONCAT(ROUND(table_rows / 1000000, 2), 'M')                                    rows,
       CONCAT(ROUND(data_length / ( 1024 * 1024 * 1024 ), 2), 'G')                    DATA,
       CONCAT(ROUND(index_length / ( 1024 * 1024 * 1024 ), 2), 'G')                   idx,
       CONCAT(ROUND(( data_length + index_length ) / ( 1024 * 1024 * 1024 ), 2), 'G') total_size,
       ROUND(index_length / data_length, 2)                                           idxfrac
FROM   information_schema.TABLES
ORDER  BY data_length + index_length DESC
LIMIT  10;

/* find the size of all databases on the server */
SELECT table_schema                                                                        db_name,
       count(*)                                                                            table_count,
       CONCAT(sum(ROUND(table_rows / 1000000, 2)), 'M')                                    rows,
       CONCAT(sum(ROUND(data_length / ( 1024 * 1024 * 1024 ), 2)), 'G')                    DATA,
       CONCAT(sum(ROUND(index_length / ( 1024 * 1024 * 1024 ), 2)), 'G')                   idx,
       CONCAT(sum(ROUND(( data_length + index_length ) / ( 1024 * 1024 * 1024 ), 2)), 'G') total_size
FROM   information_schema.TABLES
GROUP BY table_schema
ORDER  BY table_schema;

/* find the max size of a record's suspected column */
SELECT MAX(LENGTH(`my_column_name`)) FROM `my_table_name`;

/* find all columns containing blob data */
select *
from information_schema.COLUMNS
where TABLE_SCHEMA = 'my_database_name' and
	DATA_TYPE in ('blob','mediumblob','longblob','text','mediumtext','longtext');

/* get full process list and complete query for any active processes */
SHOW FULL PROCESSLIST;