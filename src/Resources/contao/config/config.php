<?php

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['Magmell\Contao\Inserttags\Hooks\InserttagsHook', 'doReplace'];

// automatic invoke did not work, force-link the hook here
use Magmell\Contao\Inserttags\EventListener\ParseFrontendTemplateListener;

$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = [ParseFrontendTemplateListener::class, '__invoke'];

//use Magmell\Contao\Inserttags\EventListener\ParseBackendTemplateListener;
//use Magmell\Contao\Inserttags\EventListener\ParseTemplateListener;

// $GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = [ParseBackendTemplateListener::class, '__invoke'];
// $GLOBALS['TL_HOOKS']['parseTemplate'][] = [ParseTemplateListener::class, '__invoke'];
