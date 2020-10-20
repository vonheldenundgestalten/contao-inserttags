<?php

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['Magmell\Contao\Inserttags\Hooks\InserttagsHook', 'doReplace'];
