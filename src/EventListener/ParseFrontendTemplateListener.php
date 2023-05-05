<?php

namespace Magmell\Contao\Inserttags\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;
use Contao\InsertTags;
use Contao\ArticleModel;
use Contao\PageModel;
use Contao\Input;
use Contao\System;

/**
 * @Hook("parseFrontendTemplate")
 */
class ParseFrontendTemplateListener
{

    public function __invoke(string $buffer, string $templateName, FrontendTemplate $template): string
    {

        global $objPage;

        // Becouse TL_MODE is deprecated in Contao 5.*, we will use this instead. Its recommended solution from Contao itself
        $isBackend = System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest());
        
        if ($isBackend && $templateName != 'ce_html') {
            if (!$objPage) {
                $a = ArticleModel::findById(Input::get("id"));
                $b = PageModel::findByPk($a->pid);
                //$objPage = PageModel::findByPk($b->trail[0]);
            }
            $objIt = new InsertTags();
            $buffer = $objIt->replaceInternal($buffer, true);
        }

        return $buffer;
    }
}
