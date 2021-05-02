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

namespace Iods\Core\Rewrite\Magento\Indexer\Model;

use Iods\Core\Model\Indexer\Model\Processor\ValidateIndexes;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Indexer\ConfigInterface;
use Magento\Framework\Indexer\IndexerInterface;
use Magento\Framework\Indexer\IndexerInterfaceFactory;
use Magento\Framework\Mview\ProcessorInterface;
use Magento\Indexer\Model\Indexer\CollectionFactory;
use Magento\Indexer\Model\Processor;

class Processor extends \Magento\Indexer\Model\Processor
{
    protected ValidateIndexes $_validateIndexes;

    private $_sharedIndexesComplete;

    protected ConfigInterface $_config;

    protected IndexerInterfaceFactory $_indexerFactory;

    protected Indexer\CollectionFactory|CollectionFactory $_indexersFactory;

    protected ProcessorInterface $_mviewProcessor;

    public function __construct(
        ConfigInterface $config,
        IndexerInterfaceFactory $indexerFactory,
        CollectionFactory $indexersFactory,
        ProcessorInterface $mviewProcessor,
        ValidateIndexes $validateIndexes = null
    ) {
        $this->_config = $config;
        $this->_indexerFactory = $indexerFactory;
        $this->_indexersFactory = $indexersFactory;
        $this->_mviewProcessor = $mviewProcessor;
        $this->_validateIndexes = $validateIndexes ?: ObjectManager::getInstance()->get(ValidateIndexes::class);
    }

    // Regenerate indexes for all invalid indexers
    public function reindexAllInvalid()
    {
        foreach (array_keys($this->config->getIndexers()) as $indexerId) {

            $indexer = $this->indexerFactory->create();
            $indexer->load($indexerId);
            $indexerConfig = $this->config->getIndexer($indexerId);

            if ($indexer->isInvalid()) {
                // Skip indexers having shared index that was already complete
                $sharedIndex = $indexerConfig['shared_index'] ?? null;
                if (!in_array($sharedIndex, $this->_sharedIndexesComplete)) {
                    $indexer->reindexAll();

                    if (!empty($sharedIndex) && $this->makeSharedValid->execute($sharedIndex)) {
                        $this->_sharedIndexesComplete[] = $sharedIndex;
                    }
                }
            }
        }
    }

    // Regenerate indexes for all indexers
    public function reindexAll()
    {
        $indexers = $this->_indexersFactory->create()->getItems();
        foreach ($indexers as $indexer) {
            $indexer->reindexAll();
        }
    }

    // Update indexer views
    public function updateMview(): void
    {
        $this->_mviewProcessor->update('indexer');
    }

    // Clean indexer view changelogs
    public function clearChangelog(): void
    {
        $this->_mviewProcessor->clearChangelog('indexer');
    }
}
