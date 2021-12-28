<?php
/**
 * Cache Rules Everything Around Magento
 *
 * @version   000.1.0
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021-2022, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Cream\Console\Command;

use Magento\Catalog\Model\Product\Image;
use Magento\Framework\App\Area;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheImageClearCommand extends Command
{
    protected ObjectManager $_objectManager;

    protected State $_state;

    public function __construct(
        State $state
    ) {
        $this->_state = $state;
        $this->_objectManager = ObjectManager::getInstance();
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('cache:image:clear');
        $this->setDescription('Flush and clear the image cache in Magento.');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_state->setAreaCode(Area::AREA_ADMINHTML);
        $this->_objectManager->create(Image::class)->clearCache();
        $output->writeln('Cleared the Magento image cache.');
    }
}