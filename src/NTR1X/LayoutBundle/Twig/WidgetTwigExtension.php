<?php

namespace NTR1X\LayoutBundle\Twig;

use NTR1X\LayoutBundle\Widget\WidgetManager;

use Peekmo\JsonPath\JsonStore;

class WidgetTwigExtension extends \Twig_Extension
{

    private $manager;

    public function __construct(WidgetManager $manager)
    {
        $this->manager = $manager;
    }

    public function getName()
    {
        return 'widget_extension';
    }

    public function getGlobals()
    {

        return [
            'widget' => array(
                'styles' => $this->manager->getStyles(),
                'scripts' => $this->manager->getScripts(),
                'templates' => $this->manager->getTemplates(),
            ),

        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('jsonPathExpression', [$this, 'jsonPathExpression']),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('jsonPath', [$this, 'jsonPath']),
        ];
    }

    public function jsonPath($context, $str)
    {
        $store = new JsonStore($context);
        return $store->get($str);
    }

    // $str = 'asdasd ad {$.asdad.234234} asdads ads  {$.get.asdasd}'
    /*
     * $context = {
     *   request: {
     *     get: ...,
     *     post: ...,
     *     ...
     *   },
     *   value: {
     *      ... свои данные
     *   }
     * }
     */

    public function jsonPathExpression($context, $str)
    {
        if (isset($str) && isset($context)) {
            return preg_replace_callback("/{([^}]+)}/", function ($matches) use (&$context) {
                $store = new JsonStore($context);
                $res = $store->get($matches[1]);
                if (isset($res) && is_array($res)) {
                    return implode(',', $res);
                }
                return $res;
            }, $str);
        }
        return null;
    }
}
