<?php
/**
 * snippets transport file for postler extra
 *
 * Copyright 2013 by Andreas Bilz <http://www.herooutoftime.com>
 * Created on 10-18-2013
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
/* @var xPDOObject[] $snippets */


$snippets = array();

$snippets[1] = $modx->newObject('modSnippet');
$snippets[1]->fromArray(array (
  'id' => 1,
  'description' => 'Description for Snippet one',
  'name' => 'postler',
), '', true, true);
$snippets[1]->setContent(file_get_contents($sources['source_core'] . '/elements/snippets/postler.snippet.php'));

return $snippets;
