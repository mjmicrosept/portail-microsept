<?php
/**
 * KM Websolutions Projects
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2010 KM Websolutions
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Class Sidebar
 * Theme sidebar widget.
 */
class Sidebar extends \yii\widgets\Menu
{
    /**
     * @inheritdoc
     */
    public $itemOptions = ['class' => 'nav-item'];
    public $linkTemplate = '<a class="nav-link" href="{url}">{icon} {label} {badge}</a>';
    public $submenuTemplate = "
                    <ul class=\"nav-dropdown-items\">\n{items}\n</ul>";
    public $activateParents = true;
    /**
     * @inheritdoc
     */
    protected function renderItem($item)
    {
        if(isset($item['items'])) {
            $labelTemplate = '
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="{url}">{label}</a>';
            $linkTemplate = '
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="{url}">{icon} {label} {badge}</a>';
        }
        else {
            $labelTemplate = $this->labelTemplate;
            $linkTemplate = $this->linkTemplate;
        }

        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $linkTemplate);
            /*$replace = !empty($item['icon']) ? [
                '{url}' => Url::to($item['url']),
                '{label}' => $item['label'],
                '{icon}' => '<i class="' . $item['icon'] .(empty($item['class']) ? '' : ' '.$item['class']).'" aria-hidden="true"></i>'
            ] : [
                '{url}' => Url::to($item['url']),
                '{label}' => $item['label'],
                '{icon}' => null,
            ];*/
            $replace = [];
            $replace +=['{url}'=> Url::to($item['url'])];
            $replace += ['{label}'=> $item['label']];

            if(!empty($item['icon']))
                $replace += ['{icon}'=> '<i class="' . $item['icon'] .(empty($item['class']) ? '' : ' '.$item['class']).'" aria-hidden="true"></i>'];
            else
                $replace += ['{icon}'=> null];

            if(!empty($item['badge'])){
                $text = 'INFO';
                if(!empty($item['info']))
                    $text = $item['info'];
                $replace += ['{badge}' => '<span class="'.$item['badge'].'">'.$text.'</span>'];
            }
            else{
                $replace += ['{badge}' => null];
            }

            return strtr($template, $replace);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $labelTemplate);
            $replace = !empty($item['icon']) ? [
                '{label}' => $item['label'],
                '{icon}' => '<i class="' . $item['icon'] . '" aria-hidden="true"></i>'
            ] : [
                '{label}' => '<span class="nav-label">'.$item['label'].'</span>',
            ];
            return strtr($template, $replace);
        }
    }
    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }
            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $menu .= strtr($this->submenuTemplate, [
                    //'{show}' => $item['active'] ? " style='display: block'" : '',
                    '{show}' => '',
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = '
                ' . Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }
    /**
     * @inheritdoc
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }
        return array_values($items);
    }
    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            $arrayRoute = explode('/', ltrim($route, '/'));
            $arrayThisRoute = explode('/', $this->route);
            if ($arrayRoute[0] !== $arrayThisRoute[0]) {
                return false;
            }
            if (isset($arrayRoute[1]) && $arrayRoute[1] !== $arrayThisRoute[1]) {
                return false;
            }
            if (isset($arrayRoute[2]) && $arrayRoute[2] !== $arrayThisRoute[2]) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
