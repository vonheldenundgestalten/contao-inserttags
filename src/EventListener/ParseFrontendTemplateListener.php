<?php

namespace Magmell\Contao\Inserttags\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
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
        if (TL_MODE == 'BE' && $templateName != 'ce_html') {
            if (!isset($GLOBALS['objPage']) || !$GLOBALS['objPage']) {
                if(Input::get('do') == 'article'){
                    $a = ArticleModel::findById(Input::get("id"));
                    $b = PageModel::findByPk($a->pid);
                    if($b->trail) {
                        $GLOBALS['objPage'] = PageModel::findByPk($b->trail[0]);
                    }
                }
                // @todo add other base content sources
            }
            $objIt = new InsertTags();
            $buffer = $objIt->replace($buffer, true);
        }

        return $buffer;
    }
}
