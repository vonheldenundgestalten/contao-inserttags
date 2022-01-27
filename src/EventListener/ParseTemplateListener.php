<?php

namespace Magmell\Contao\Inserttags\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\InsertTags;
use Contao\Input;
use Contao\Template;

/**
 * @Hook("parseTemplate")
 */
class ParseTemplateListener
{
    public function __invoke(Template $template): void
    {
        var_dump($template->getName());
        if ('be_main' === false) {
            // modify only if we're not in any action mode, popup or dynamic context
            // modify only if there is no HTML content element involved
            if(
                !Input::get('act')
                AND !Input::get('context')
                AND !Input::get('picker')
                AND strpos($buffer, '<div class="cte_type published">HTML</div>') === false
                AND strpos($buffer, '<div class="cte_type unpublished">HTML</div>') === false
            ){
                // var_dump('Backend Insert Tags loaded'); exit;
                $objIt = new InsertTags();
                $buffer = $objIt->replace($buffer, true);                
            }            
        }
        
        // return $buffer;
    }
}
