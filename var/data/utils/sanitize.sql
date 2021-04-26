/*
 * Sanitize SQL for Magento Development Environment
 *
 * Split into Admin, Customer, Catalog cleanup.
 *
 * 1. Admin Cleanup
 *      * Update the Admin User password
 *      * Create the Developer account and password
 *
 * 2. Customer Cleanup
 *      * Yah
 *
 * 3. Catalog Cleanup
 *      * Boi
 */

/* [1] Update the Admin User password */
UPDATE admin_user
   SET password = MD5('admin')
 WHERE username = 'admin';

UPDATE admin_user
   SET firstname = CONCAT('FN-', user_id),
       last
