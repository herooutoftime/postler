<?php
/**
 * systemSettings transport file for postler extra
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
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key' => 'postler.server',
  'name' => 'Postler Server',
  'description' => 'Description for setting one',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'finch.arvixe.com',
  'area' => 'system',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key' => 'postler.user',
  'name' => 'Postler User',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'anti@herooutoftime.com',
  'area' => 'system',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key' => 'postler.pass',
  'name' => 'Postler Password',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'text-password',
  'inputType' => 'password',
  'value' => 'ibelod',
  'area' => 'system',
), '', true, true);
$systemSettings[4] = $modx->newObject('modSystemSetting');
$systemSettings[4]->fromArray(array (
  'key' => 'postler.port',
  'name' => 'Postler Port',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => '110',
  'area' => 'system',
), '', true, true);
$systemSettings[5] = $modx->newObject('modSystemSetting');
$systemSettings[5]->fromArray(array (
  'key' => 'postler.ssl',
  'name' => 'Postler SSL',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'combo-boolean',
  'value' => true,
  'area' => 'system',
), '', true, true);
$systemSettings[6] = $modx->newObject('modSystemSetting');
$systemSettings[6]->fromArray(array (
  'key' => 'postler.special',
  'name' => 'Postler Special',
  'description' => 'Special means some additional string, e.g.: "/imap/ssl/novalidate-cert"',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => '/imap/ssl/novalidate-cert',
  'area' => 'system',
), '', true, true);
$systemSettings[7] = $modx->newObject('modSystemSetting');
$systemSettings[7]->fromArray(array (
  'key' => 'postler.folder',
  'name' => 'Postler Folder',
  'description' => 'Folder to look into',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'INBOX/mediainfo',
  'area' => 'system',
), '', true, true);
$systemSettings[8] = $modx->newObject('modSystemSetting');
$systemSettings[8]->fromArray(array (
  'key' => 'postler.email',
  'name' => 'Postler Mail Address',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => '',
  'area' => 'system',
), '', true, true);
$systemSettings[9] = $modx->newObject('modSystemSetting');
$systemSettings[9]->fromArray(array (
  'key' => 'postler.success_email',
  'name' => 'Postler Success Mail Address',
  'description' => 'Address to send success mails in return. This mail should be used to update resources',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'you@domain.com',
  'area' => 'system',
), '', true, true);
$systemSettings[10] = $modx->newObject('modSystemSetting');
$systemSettings[10]->fromArray(array (
  'key' => 'postler.prefix',
  'name' => 'Postler Prefix',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'MODx Resource',
  'area' => 'system',
), '', true, true);
$systemSettings[11] = $modx->newObject('modSystemSetting');
$systemSettings[11]->fromArray(array (
  'key' => 'postler.publish',
  'name' => 'Postler Publish',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'combo-boolean',
  'value' => true,
  'area' => 'system',
), '', true, true);
$systemSettings[12] = $modx->newObject('modSystemSetting');
$systemSettings[12]->fromArray(array (
  'key' => 'postler.container',
  'name' => 'Postler Container',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => '',
  'area' => 'system',
), '', true, true);
$systemSettings[13] = $modx->newObject('modSystemSetting');
$systemSettings[13]->fromArray(array (
  'key' => 'postler.author',
  'name' => 'Postler Author',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => '',
  'area' => 'system',
), '', true, true);
$systemSettings[14] = $modx->newObject('modSystemSetting');
$systemSettings[14]->fromArray(array (
  'key' => 'postler.template',
  'name' => 'Postler Template',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 1,
  'area' => 'system',
), '', true, true);
$systemSettings[15] = $modx->newObject('modSystemSetting');
$systemSettings[15]->fromArray(array (
  'key' => 'postler.export_dir',
  'name' => 'Postler Export Dir',
  'description' => 'Description for setting two',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'assets/attachments/',
  'area' => 'system',
), '', true, true);
$systemSettings[16] = $modx->newObject('modSystemSetting');
$systemSettings[16]->fromArray(array (
  'key' => 'postler.html_content_by_element',
  'name' => 'Postler HTML Element',
  'description' => 'HTML Element containing the content to fetch.<br/>XPATH compatible:<pre>//div[@class="content"]</pre>',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => '',
  'area' => 'system',
), '', true, true);
$systemSettings[17] = $modx->newObject('modSystemSetting');
$systemSettings[17]->fromArray(array (
  'key' => 'postler.use_markdown',
  'name' => 'Postler Use Markdown',
  'description' => 'Use the markdown parser',
  'namespace' => 'postler',
  'xtype' => 'combo-boolean',
  'value' => true,
  'area' => 'system',
), '', true, true);
$systemSettings[18] = $modx->newObject('modSystemSetting');
$systemSettings[18]->fromArray(array (
  'key' => 'postler.compare_by',
  'name' => 'Postler Property Comparison',
  'description' => 'Which property should be used to find resources',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'pagetitle',
  'area' => 'system',
), '', true, true);
$systemSettings[19] = $modx->newObject('modSystemSetting');
$systemSettings[19]->fromArray(array (
  'key' => 'postler.after_import_action',
  'name' => 'Postler After Import Action',
  'description' => 'What do you wish to do with e-mails after succesful import?',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'pagetitle',
  'area' => 'system',
), '', true, true);
$systemSettings[20] = $modx->newObject('modSystemSetting');
$systemSettings[20]->fromArray(array (
  'key' => 'postler.delete_keywords',
  'name' => 'Postler Keywords to delete',
  'description' => 'A comma seperated list of keywords to check for delete action',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'delete, remove, expunge, trash',
  'area' => 'system',
), '', true, true);
$systemSettings[21] = $modx->newObject('modSystemSetting');
$systemSettings[21]->fromArray(array (
  'key' => 'postler.delete_address',
  'name' => 'Postler Address to delete action',
  'description' => 'Address to look out for in CC to remove resources',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'delete@herooutoftime.com',
  'area' => 'system',
), '', true, true);
$systemSettings[22] = $modx->newObject('modSystemSetting');
$systemSettings[22]->fromArray(array (
  'key' => 'postler.context',
  'name' => 'Postler context to save resources',
  'description' => 'Postler context to save resources',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'example',
  'area' => 'system',
), '', true, true);
$systemSettings[23] = $modx->newObject('modSystemSetting');
$systemSettings[23]->fromArray(array (
  'key' => 'postler.delete_after',
  'name' => 'Postler Delete After Import',
  'description' => 'Postler attempts to mark the mail as deleted after successful import',
  'namespace' => 'postler',
  'xtype' => 'textfield',
  'value' => 'example',
  'area' => 'system',
), '', true, true);
return $systemSettings;
