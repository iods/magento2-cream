Clean the Magento core_session table
gistfile1.sql
DELETE FROM core_session WHERE session_expires < unix_timestamp()
@seansan
seansan commented on Sep 8, 2017
add a delta date? so anything older than .... 30 days os

https://stackoverflow.com/questions/5504395/insert-timestamp-into-a-database-7-days