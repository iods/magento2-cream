<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Helper;

/**
 * Class CronCollection - only get collections
 * @package Newizze\Postpayment\Helper\Cron
 */
class CronCollection extends Order
{
    protected $debugMode = false;

    /*** @var array orders with shipped out status */
    private $shippedOutCollection = [];

    /*** @var array orders with upload to incasso status*/
    private $incassoCollection = [];

    /*** @var array order for csv data*/
    protected $incassoResult = [[
        'Order Number',
        'Phone Number',
        'Email Address',
        'Customer Firstname',
        'Customer Lastname'
    ]];

    /*** @var array order with csv data*/
    protected $shippedOutResult = [[
        'Order Number',
        'Phone Number',
        'Email Address',
        'Customer Firstname',
        'Customer Lastname',
        'Address',
        'City',
        'Country',
        'Payment Link',
        'Grand Total Amount',
        'Grand Total Base',
        'Store Name',
        'Product Name',
        'Vat'
    ]];

    /**
     * Run script
     */
    public function execute()
    {
        try {
            $orders = $this->prepareOrders();
            if (empty($orders)) {
                $this->logger->log('Empty collection now', null, Order::LOG_FILE);
                $this->emptyCollection();
                return;
            }

            foreach ($orders as $order) {
                if ($order['status'] == Order::ORDER_SHIPPED_OUT_STATUS) {
                    $this->orderIsShippedOut($order);
                } else {
                    $this->orderIsNotShippedOut($order);
                }
            }
            $this->sendShippedOutCollection();
            $this->sendUploadToIncassoCollection();
        } catch (\Exception $exception) {
            $this->logger->log($exception->getMessage(), null, Order::LOG_FILE);
        }
        return;
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getOrdersSql()
    {
        $date = new \DateTime();
        $lastNinetyDays = $date->modify('-30 days');

        $filedToSelect = implode(',', [
            '`main_table`.`entity_id`',
            '`main_table`.`status`',
            '`main_table`.`customer_email`',
            '`main_table`.`customer_lastname`',
            '`main_table`.`customer_firstname`',
            '`main_table`.`increment_id`',
            '`main_table`.`grand_total`',
            '`main_table`.`base_grand_total`',
            '`store`.`store_id`',
            '`store_website`.`name`',
            '`payment`.`method` AS `payment_method`',
            '`address`.`postcode`',
            '`address`.`street`',
            '`address`.`city`',
            '`address`.`country_id`',
            '`address`.`telephone`',
            '`address`.`address_type`',
            '`address`.`vat_id`'
        ]);

        $join = 'INNER JOIN `sales_order_payment` AS `payment` ON main_table.entity_id=payment.parent_id ';
        $join .= "INNER JOIN `sales_order_address` AS `address` ON main_table.entity_id=address.parent_id AND `address`.`address_type`='billing' ";
        $join .= 'INNER JOIN `store` ON store.store_id=main_table.store_id ';
        $join .= 'INNER JOIN `store_website` ON store_website.website_id=store.website_id ';

        $where = "(`payment`.`method` IN('postpayment', 'wezz_payment_page')) ";
        $where .= "AND (`main_table`.`created_at` >= '".$lastNinetyDays->format('Y-m-d')."')";
        return "SELECT {$filedToSelect} FROM `sales_order` AS `main_table` {$join} WHERE {$where}";
    }

    /**
     * @param $orders
     * @return string
     */
    private function getProductsByOrdersIdSql($orders)
    {
        $orderIds = [];
        $params = implode(',', [
            'order_id',
            'name',
            'item_id',
            'qty_ordered'
        ]);
        foreach ($orders as $order) {
            $orderIds[] = $order['entity_id'];
        }
        return "SELECT {$params} FROM sales_order_item WHERE order_id IN (".implode(',', $orderIds).")";
    }

    /**
     * Union products to orders
     * @throws \Exception
     */
    private function prepareOrders()
    {
        /*** all orders by condition */
        $orders = $this->resourceConnection->getConnection()->fetchAll($this->getOrdersSql());

        /*** all ordered group products, [order_id => [products]]*/
        $alterProducts = $this->resourceConnection
            ->getConnection()
            ->fetchAll($this->getProductsByOrdersIdSql($orders), [], \PDO::FETCH_ASSOC|\PDO::FETCH_GROUP);

        foreach ($orders as $k => $order) {
            $orders[$k]['product'] = $alterProducts[$order['entity_id']];
        }

        return $orders;
    }

    /**
     * If status equally order_shippied_out
     * @param $order
     */
    private function orderIsShippedOut($order)
    {
        $this->shippedOutCollection[] = $order;
    }

    /**
     * If status is not equally order_shippied_out
     * @param $order
     */
    private function orderIsNotShippedOut($order)
    {
        if ($order['status'] == Order::UPLOAD_TO_INCASSO_STATUS) {
            $this->incassoCollection[] = [
                'telephone' => $order['telephone'],
                'increment_id' => $order['increment_id'],
                'customer_email' => $order['customer_email'],
                'customer_firstname' => $order['customer_firstname'],
                'customer_lastname' => $order['customer_lastname']
            ];
        }
    }

    /**
     * Send orders in shipped_out status
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function sendShippedOutCollection()
    {
        if (empty($this->shippedOutCollection)) {
            //nofity empty collection
            $this->emptyCollection();
            return;
        }
        //send csv
        $this->prepareShippedOutCollection();
    }

    /**
     * Send orders in upload_to_incasso status
     */
    private function sendUploadToIncassoCollection()
    {
        if (empty($this->incassoCollection)) {
            //notify empty collection
            $this->emptyCollection();
            return;
        }
        //send csv
        $this->prepareUploadToIncassoCollection();
    }

    /**
     * Prepare shipped_out collection for csv
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function prepareShippedOutCollection()
    {
        foreach ($this->shippedOutCollection as $value) {
            $this->shippedOutResult[] = [
                $value['increment_id'],
                $value['telephone'],
                $value['customer_email'],
                $value['customer_firstname'],
                $value['customer_lastname'],
                $value['street'],
                $value['city'],
                $this->countryFactory->create()->loadByCode($value['country_id'])->getName(),
                'Payment Link',
                'Grand Total Amount',
                'Grand Total Base',
                $this->_storeManager->getStore($value['store_id'])->getBaseUrl(),
                $this->getProductsFromOrder($value),
                $value['name'],
                $value['vat_id'],
            ];
        }
        $this->filename = 'shipped_out_collection_' . date('Y-m-d') . '.csv';
        try {
            if ($absolutePath = $this->writeTempCsvFile($this->shippedOutResult)) {
                $this->send($absolutePath);
            }
        } catch (\Exception $exception) {
            $this->logger->log($exception->getMessage(), null, Order::LOG_FILE);
        }
    }

    /**
     * Prepare upload_to_incasso for csv
     */
    protected function prepareUploadToIncassoCollection()
    {
        foreach ($this->incassoCollection as $value) {
            $this->incassoResult[] = [
                $value['increment_id'],
                $value['telephone'],
                $value['customer_email'],
                $value['customer_firstname'],
                $value['customer_lastname'],
            ];
        }
        $this->filename = 'upload_to_incasso_collection_' . date('Y-m-d') . '.csv';
        try {
            if ($absolutePath = $this->writeTempCsvFile($this->incassoResult)) {
                $this->send($absolutePath);
            }
        } catch (\Exception $exception) {
            $this->logger->log($exception->getMessage(), null, Order::LOG_FILE);
        }
    }

    /**
     * @param $order
     * @return string
     */
    private function getProductsFromOrder($order)
    {
        if (!isset($order['product'])) {
            return '-';
        }
        $products = [];
        foreach ($order['product'] as $product) {
            $products[] = 'QTY ' . $product['qty_ordered'] . ' : ' . $product['name'];
        }
        return implode(', ', $products);
    }

}
