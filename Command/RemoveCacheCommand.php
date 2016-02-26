<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class RemoveCacheCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('image-workshop:cache:remove')
            ->setDescription('Remove image cached files')
            ->addOption('filters', 'f', InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY, 'Filters list')
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> command removes image cached files.

If you use --filters parameter:
<info>php app/console %command.name% --filters=thumbnail --filters=thumbnail2</info>
All cache for a given filters will be lost.

<info>php app/console %command.name%</info>
Cache for all paths and filters will be lost when executing this command without parameters.
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filters = $input->getOption('filters');
        if (empty($filters)) {
            $filters = null;
        }

        $cacheManager = $this->getContainer()->get('image_workshop.cache_resolver');
        if (false === ($cacheDirectory = $cacheManager->getCacheDirectory())) {
            $output->writeln('<info>Cache is empty</info>');
            return;
        }

        $fs = new Filesystem();
        if (null === $filters) {
            $fs->remove($cacheDirectory);

            $output->writeln('<info>Cache directory remove</info>');
            return;
        }

        $fs->remove(array_map(function($filter) use ($cacheManager) {
            return $cacheManager->getCacheDirectory().'/'.$filter;
        }, $filters));

        $output->writeln('<info>Cache directory cleaned</info>');
    }
}
