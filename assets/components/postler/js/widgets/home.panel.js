/**
* JS file for postler extra
*
* Copyright 2013 by Andreas Bilz <http://www.herooutoftime.com>
* Created on 10-20-2013
*
 * postler is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * postler is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * postler; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
* @package postler
*/

/* These are for LexiconHelper:
 $modx->lexicon->load('postler:default');
 include 'postler.class.php'
 */

postler.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+'postler'+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,stateful: true
            ,stateId: 'postler-home-tabpanel'
            ,stateEvents: ['tabchange']
            ,getState:function() {
                return {activeTab:this.items.indexOf(this.getActiveTab())};
            }
            ,items: [{
                title: _('resources')
                ,defaults: { autoHeight: true }
                ,items: [{
                    border: false
                    ,bodyStyle: 'padding: 10px'
                },{
                    xtype: 'postler-grid-s'
                    ,preventRender: true
                }]
            }]
        }]
    });
    postler.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(postler.panel.Home,MODx.Panel);
Ext.reg('postler-panel-home',postler.panel.Home);
        