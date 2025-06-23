<?php

namespace Magmell\Contao\Inserttags\Hooks;

use Contao\Input;
use Contao\StringUtil;
use Contao\Validator;
use Contao\System;
use Symfony\Component\HttpFoundation\RequestStack; // <-- Add this


/**
 * Class InserttagsHook
 * @package Magmell\Contao\Inserttags\Hooks
 */

class InserttagsHook
{
    /**
     * @param $tag
     * @param $blnCache
     * @param $strTag
     * @param $flags
     * @param $tags
     * @param $arrCache
     * @param $_rit
     * @param $_cnt
     * @return false|string
     */
    public function doReplace($tag, $blnCache, $strTag, $flags, $tags, $arrCache, $_rit, $_cnt)
    {
        $return = '';
        $elements = explode("::", $tag);

        switch (strtolower($elements[0]))
        {
            case 'file_vendor':
                $arrGet = $_GET;
                Input::resetCache();
                $strFile = $elements[1];

                if (strpos($elements[1], '?') !== false)
                {
                    $arrChunks = explode('?', urldecode($elements[1]));
                    $strSource = StringUtil::decodeEntities($arrChunks[1]);
                    $strSource = str_replace('[&]', '&', $strSource);
                    $arrParams = explode('&', $strSource);

                    foreach ($arrParams as $strParam) {
                        $arrParam = explode('=', $strParam);
                        $_GET[$arrParam[0]] = $arrParam[1];
                    }

                    $strFile = $arrChunks[0];
                }

                if (Validator::isInsecurePath($strFile))
                {
                    throw new \RuntimeException('Invalid path ' . $strFile);
                }

                if (preg_match('/\.(php|tpl|xhtml|html5)$/', $strFile) && file_exists(System::getContainer()->getParameter('kernel.project_dir') . '/vendor/' . $strFile))
                {
                    ob_start();

                    try
                    {
                        include System::getContainer()->getParameter('kernel.project_dir') . '/vendor/' . $strFile;
                        $return = ob_get_contents();
                    } finally {
                        ob_end_clean();
                    }
                }

                $_GET = $arrGet;
                Input::resetCache();
                break;

            case 'form':
                $requestStack = System::getContainer()->get('request_stack');
                $request = $requestStack->getCurrentRequest();
                $session = $request ? $request->getSession() : null;
                $formData = $session ? $session->get('FORM_DATA', []) : [];

                if (isset($formData[$elements[1]])) {
                    $return = $formData[$elements[1]];
                } elseif (Input::get($elements[1])) {
                    $return = Input::get($elements[1]);
                } else {
                    $return = Input::post($elements[1]);
                }
                break;

            case 'get':
                $return = Input::get($elements[1]);
                break;
        }

        return (string)$return;
    }
}
