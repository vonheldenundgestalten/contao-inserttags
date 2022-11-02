<?php

namespace Magmell\Contao\Inserttags\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;
use Contao\InsertTags;


/**
 * @Hook("parseFrontendTemplate")
 */
class ParseFrontendTemplateListener
{

    public function __invoke(string $buffer, string $templateName, FrontendTemplate $template): string
    {
        if (TL_MODE == 'BE' && $templateName != 'ce_html') {
            if (!$GLOBALS['objPage']) {
                $a = ArticleModel::findById(Input::get("id"));
                $b = PageModel::findByPk($a->pid);
                $GLOBALS['objPage'] = PageModel::findByPk($b->trail[0]);
            }
            $objIt = new InsertTags();
            $buffer = $objIt->replace($buffer, true);
        }

        return $buffer;
    }
}
