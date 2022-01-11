<?php

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['Magmell\Contao\Inserttags\Hooks\InserttagsHook', 'doReplace'];

// automatic invoke did not work, force-link the hook here
use Magmell\Contao\Inserttags\EventListener\ParseBackendTemplateListener;

$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = [ParseBackendTemplateListener::class, '__invoke'];
