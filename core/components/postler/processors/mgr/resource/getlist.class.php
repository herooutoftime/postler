<?php
/**
 * Processor file for Workflow extra
 *
 * Copyright 2013 by Andreas Bilz Andreas Bilz <andreas@subsolutions.at>
 * Created on 09-30-2013
 *
 * Workflow is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Workflow is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Workflow; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package workflow
 * @subpackage processors
 */

/* @var $modx modX */


class PostlerResourceGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'modResource';
    public $languageTopics = array('postler:default');
    // public $defaultSortField = 'createdon';
    // public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->innerJoin('modTemplateVarResource','TemplateVarResources');
        // $c->innerJoin('modTemplateVarResource','TemplateVarResources2');
        $c->innerJoin('modTemplateVar','TemplateVar','TemplateVarResources.tmplvarid = TemplateVar.id');
        // $c->innerJoin('modTemplateVar','TemplateVar2','TemplateVarResources.tmplvarid = TemplateVar2.id');
        // if($this->getProperty('state')) {
        //     $c->where(array(
        //         'TemplateVar.name' => 'wfStatus',
        //         'TemplateVarResources.value' => $this->getProperty('state'),
        //     ));
        // } else {
            $c->where(array(
                'TemplateVar.name' => 'message_id',
                'TemplateVarResources.value:!=' => null,
            ));
        // }

        $orderCase = '(CASE WHEN editedon = 0 THEN createdon ELSE editedon END)';
        $c->sortby($orderCase, 'DESC');
        $c->select($this->modx->getSelectColumns('modResource','modResource', '', array('id', 'pagetitle', 'published', 'publishedon')));
        $c->select(array(
            'message_id' => $this->modx->getSelectColumns('modTemplateVarResource','TemplateVarResources', '', array('value')),
        ));
        return $c;
    }


    /**
     * Convert category ID to category name for objects with a category.
     * Convert template ID to template name for objects with a template
     *
     * Note: It's much more efficient to do these with a join, but that can
     * only be done for objects known to have the field. This code can
     * be used on any object.
     *
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $fields = $object->toArray();
        $cacheOptions = array(
            xPDO::OPT_CACHE_KEY => '',
            xPDO::OPT_CACHE_HANDLER => 'xPDOFileCache',
            xPDO::OPT_CACHE_EXPIRES => 0,
        );
        // $content = $this->modx->cacheManager->get('newsletter/' . $newsletter->get('docid'), $cacheOptions);
        // $cacheManager = $this->modx->getCacheManager();
        // var_dump($cacheManager->get('postler/' . $fields['id'], $cacheOptions));
        $cache = file_get_contents($this->modx->getOption('core_path') . 'cache/postler/'. $fields['id'] . '.cache.php');
        $fields['mail'] = $cache;
        return $fields;
    }
}
return 'PostlerResourceGetlistProcessor';
