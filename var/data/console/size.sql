Get the size of all your mysql databases
foo.sql
SELECT
  table_schema as "db name",
  SUM( data_length + index_length) / 1024 / 1024  as "Data Base Size in MB"
FROM
  information_schema.TABLES
GROUP BY
  table_schema;