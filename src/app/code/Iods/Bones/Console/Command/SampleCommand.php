<?php
/**
 * Description of a module goes here for Magento 2
 *
 * @package   Iods_Bones
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2020, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Bones\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputArgument, InputInterface};
use Symfony\Component\Console\Output\OutputInterface;

class SampleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('iods:bones')
            ->setDescription('Sample command as an example for module templates.')
            ->addArgument(
                'text',
                InputArgument::OPTIONAL,
                'Add some random text to display after the command.'
            );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = $input->getArgument('text');
        if ($text) {
            $t = '<info>A sample command with args having no interactions with the cli.</info>';
        } else {
            $t = '<info>A sample command having no interactions with the cli.</info>';
        }
        $output->writeln($t);
    }
}
