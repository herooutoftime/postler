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
var postler = function (config) {
    config = config || {};
    postler.superclass.constructor.call(this, config);
};
Ext.extend(postler, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}
});
Ext.reg('postler', postler);

var postler = new postler();