<?php
/**
 * menus transport file for postler extra
 *
 * Copyright 2013 by Andreas Bilz <http://www.herooutoftime.com>
 * Created on 10-20-2013
 *
 * @package postler
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $menus */

$action = $modx->newObject('modAction');
$action->fromArray( array (
  'id' => 1,
  'namespace' => 'postler',
  'controller' => 'index',
  'haslayout' => true,
  'lang_topics' => 'postler:default',
  'assets' => '',
), '', true, true);

$menus[1] = $modx->newObject('modMenu');
$menus[1]->fromArray( array (
  'text' => 'postler',
  'parent' => 'components',
  'description' => 'ex_menu_desc',
  'icon' => '',
  'menuindex' => 0,
  'params' => '',
  'handler' => '',
  'permissions' => '',
  'id' => 1,
), '', true, true);
$menus[1]->addOne($action);

return $menus;
