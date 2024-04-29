<?php

namespace Magmell\Contao\Inserttags\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\System;
use Contao\FrontendTemplate;
use Contao\InsertTags;
use Contao\ArticleModel;
use Contao\PageModel;
use Contao\Input;

/**
 * @Hook("parseFrontendTemplate")
 */
class ParseFrontendTemplateListener
{

    public function __invoke(string $buffer, string $templateName, FrontendTemplate $template): string
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')) && $templateName != 'ce_html') {
            if (!isset($GLOBALS['objPage']) || !$GLOBALS['objPage']) {
                $a = ArticleModel::findById(Input::get("id"));
                $b = PageModel::findByPk($a->pid);
                
                if($b->trail) {
                    $GLOBALS['objPage'] = PageModel::findByPk($b->trail[0]);
                }
            }
            $buffer = System::getContainer()->get('contao.insert_tag.parser')->replace($buffer);
        }

        return $buffer;
    }
}
