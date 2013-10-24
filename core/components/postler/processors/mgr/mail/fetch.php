<?php
/**
 * Processor: Fetch the mails and import into MODx
 */

$logs = $modx->postler->read();
// var_dump($logs);
$modx->log(modX::LOG_LEVEL_WARN, implode('<br/>', $logs));
$modx->log(modX::LOG_LEVEL_INFO,'An information message in normal colors.');
$modx->log(modX::LOG_LEVEL_ERROR,'An error in red!');
$modx->log(modX::LOG_LEVEL_WARN,'A warning in blue!');
$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
return $modx->error->success('');