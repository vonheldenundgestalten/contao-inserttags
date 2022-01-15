<?php

namespace Magmell\Contao\Inserttags\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\InsertTags;
use Contao\Input;

/**
 * @Hook("parseBackendTemplate")
 */
class ParseBackendTemplateListener
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
                $objIt = new InsertTags();
                $buffer = $objIt->replace($buffer, true);                
            }            
        }
        
        return $buffer;
    }
}
