Exclude certain data from MySQL DB Dump
new_gist_file_0
# Find out tha start and end for each table data and definition
grep -n 'Table structure\|Dumping data for table' superatv_prod-FULL-20170221.sql

...
406:-- Table structure for table `avatax_log`
429:-- Dumping data for table `avatax_log`
1361:-- Table structure for table `avatax_queue`
...

sed '429,1361 d' dump.sql > cleandump.sql
