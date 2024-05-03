<?php

namespace Magmell\Contao\Inserttags\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Input;
use Contao\System;
use Contao\Template;
use Contao\StringUtil;
use Contao\BackendTemplate;

/**
 * @Hook("parseBackendTemplate")
 */
class ParseBackendTemplateListener extends BackendTemplate
{
    public function __invoke(string $buffer, string $template): string
    {
        if ('be_main' === $template) {
            // modify only if we're not in any action mode, popup or dynamic context
            // modify only if there is no HTML content element involved
            if(
                !Input::get('act')
                AND !Input::get('context')
                AND !Input::get('picker')
                AND strpos($buffer, '<div class="cte_type published">HTML</div>') === false
                AND strpos($buffer, '<div class="cte_type unpublished">HTML</div>') === false
            ){
                $buffer = System::getContainer()->get('contao.insert_tag.parser')->replace($buffer);
                
                if (!empty($GLOBALS['TL_CSS']) && \is_array($GLOBALS['TL_CSS']))
                {
                    $strStyleSheets = '';

                    foreach (array_unique($GLOBALS['TL_CSS']) as $stylesheet)
                    {
                        $options = StringUtil::resolveFlaggedUrl($stylesheet);
                        $strStyleSheets .= Template::generateStyleTag($this->addStaticUrlTo($stylesheet), $options->media, $options->mtime);
                    }

                    $this->stylesheets .= $strStyleSheets;
                    $buffer = str_replace('<head>', '<head>' . $this->stylesheets, $buffer);
                }
            }            
        }
        return $buffer;
    }
}
