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
                $buffer = System::getContainer()->get('contao.insert_tag.parser')->replace($buffer);         
            }            
        }
        
        // return $buffer;
    }
}
