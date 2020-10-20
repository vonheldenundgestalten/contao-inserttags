<?php

namespace Magmell\Contao\Inserttags\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Magmell\Contao\Inserttags\ContaoInserttagsBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoInserttagsBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
