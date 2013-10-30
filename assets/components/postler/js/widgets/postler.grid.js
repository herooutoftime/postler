/**
 * JS file for postler extra
 *
 * Copyright 2013 by Bob Ray <http://bobsguides.com>
 * Created on 04-13-2013
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

postler.grid.s = function (config) {
    config = config || {};
    this.sm = new Ext.grid.CheckboxSelectionModel();

    Ext.applyIf(config, {
        url: postler.config.connector_url
        ,baseParams: {
           action: 'mgr/resource/getlist'
        }
        ,pageSize: 50
        ,fields: ['id','pagetitle','editedon','deleted','published','publishedon','createdon','message_id','mail']
        ,paging: true
        ,autosave: false
        ,remoteSort: false
        ,autoExpandColumn: 'description'
        ,cls: 'postler-grid'
        ,sm: this.sm
        ,columns: [this.sm, {
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 50
        },{
            header: _('pagetitle')
            ,dataIndex: 'pagetitle'
            ,sortable: true
            ,width: 100
        },{
            header: _('message_id')
            ,dataIndex: 'message_id'
            ,sortable: true
            ,width: 100
        },{
            header: _('published')
            ,dataIndex: 'published'
            ,width: 40
            ,editor: { xtype: 'combo-boolean' ,renderer: 'boolean' }
            ,sortable: true
        },{
            header: _('publishedon')
            ,dataIndex: 'publishedon'
            ,width: 100
            ,sortable: true
        },{
            header: _('createdon')
            ,dataIndex: 'createdon'
            ,width: 100
            ,sortable: true
        },{
            header: _('editedon')
            ,dataIndex: 'editedon'
            ,width: 100
            ,sortable: true
        }]
        ,viewConfig: {
            forceFit: true,
            enableRowBody: true,
            showPreview: true,
            getRowClass: function (rec, ri, p) {
                var cls = 'postler-row';

                if (this.showPreview) {
                    return cls + ' postler-resource-expanded';
                }
                return cls + ' postler-resource-collapsed';
            }
        }
        ,tbar: [{
            text: _('postler.batch_actions')
            // ,menu: this.getBatchMenu()
        },'->',{
            text: _('postler.action.fetch')
            ,handler: this.fetch
            ,scope: this
        }]
    });
    postler.grid.s.superclass.constructor.call(this, config)
};

Ext.extend(postler.grid.s, MODx.grid.Grid, {
     reloads: function () {
        this.getStore().baseParams = {
            action: 'mgr/resource/getList'
            ,orphanSearch: 'mod'
        };

        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,fetch: function() {
        var topic = '/postler/';
        var register = 'mgr';
        if (this.console === null || this.console === undefined) {
            this.console = MODx.load({
               xtype: 'modx-console'
               ,title: 'Postler-Console'
               ,register: register
               ,topic: topic
               ,show_filename: 0
               ,listeners: {
                 'shutdown': {fn:function() {
                     // Ext.getCmp('modx-layout').refreshTrees();
                 },scope:this}
               }
            });
        } else {
            this.console.setRegister(register, topic);
        }
        // this.console.show(Ext.getBody());

        MODx.msg.confirm({
            title: _('postler.fetch.title')
            ,text: _('postler.fetch.text')
            ,url: postler.config.connector_url
            ,params: {
                action: 'mgr/mail/fetch'
                ,register: register
                ,topic: topic
            }
            ,listeners: {
                'success': {fn:function() {
                    this.console.show(Ext.getBody());
                    this.console.fireEvent('complete');
                    this.refresh;
                }, scope:this}
            }
        });
    }
    ,getMenu: function() {
        return [{
            text: _('postler.show_mail')
            ,handler: this.showMailWindow
            ,scope: this
        }]
    }
    ,getSelectedAsList: function () {
        var sels = this.getSelectionModel().getSelections();
        if (sels.length <= 0) return false;

        var cs = '';
        for (var i = 0; i < sels.length; i++) {
            cs += ',' + sels[i].data.id;
        }
        cs = Ext.util.Format.substr(cs, 1);
        return cs;
    }
    ,showMailWindow: function(btn, e) {
        if (!this.mailWindow) {
            this.mailWindow = MODx.load({
                xtype: 'postler-mail-window'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.mailWindow.setValues(this.menu.record);
        this.mailWindow.show(e.target);
    }
});
Ext.reg('postler-grid-s', postler.grid.s);


postler.window.MailWindow = function (config) {
    config = config || {};
    console.log(config.record);
    Ext.applyIf(config, {
        title: _('postler.mail_window.title')
        ,url: postler.config.connector_url
        ,baseParams: {
            action: 'mgr/mail/get'
        }
        ,width: 750
        ,fields: [{
            xtype: 'hidden'
            ,name: 's'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('pagetitle')
            ,value: config.record.pagetitle
            ,disabled: true
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('postler.mail_window.message_id')
            ,value: config.record.message_id
            ,disabled: true
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('postler.mail_window.mail')
            ,name: 'mail'
            ,hiddenName: 'mail'
            ,anchor: '100%'
            ,height: 300
            ,value: config.record.mail
        }]
    });
    postler.window.MailWindow.superclass.constructor.call(this, config);
};
Ext.extend(postler.window.MailWindow, MODx.Window);
Ext.reg('postler-mail-window', postler.window.MailWindow);