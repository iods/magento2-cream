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

use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Quote\Model\QuoteFactory;

class Quote extends Base
{
    protected $tableQuote;
    protected $tableQuoteItem;
    protected $quoteFactory;
    public function __construct(Context $context, ObjectManagerInterface $objectManager, QuoteFactory $quoteFactory)
    {
        parent::__construct($context, $objectManager);
        $this->quoteFactory = $quoteFactory->create();
        $this->tableQuote = $this->helperDb->getSqlTableName('quote');
        $this->tableQuoteItem = $this->helperDb->getSqlTableName('quote_item');
    }

    public function getQuote($quoteId = 0)
    {
        return $this->getQuoteById($quoteId);
    }

    public function quoteExists($quoteId = 0)
    {
        $exists = false;
        try {
            $sql = "SELECT * FROM " . $this->tableQuote . " quote where quote.entity_id = $quoteId";
            $result = $this->helperDb->sqlQueryFetchOne($sql);
            $exists = $result && !empty($result);
        } catch (\Exception $e) {
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            $exists = false;
        } finally {
            return $exists;
        }
    }

    private function getQuoteById($quoteId = 0)
    {
        $quote = null;
        try {
            $quote = $this->quoteExists($quoteId) ? $this->quoteFactory->load($quoteId) : null;
        } catch (\Exception $e) {
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            $quote = null;
        } finally {
            return $quote;
        }
    }
}
