<?php

 /*               DO NOT EDIT THIS FILE

  Edit the file in the MyComponent config directory
  and run ExportObjects

 */



$packageNameLower = 'postler'; /* No spaces, no dashes */

$components = array(
    /* These are used to define the package and set values for placeholders */
    'packageName' => 'postler',  /* No spaces, no dashes */
    'packageNameLower' => $packageNameLower,
    'packageDescription' => 'Postler imports emails into MODx',
    'version' => '1.0.0',
    'release' => 'beta1',
    'author' => 'Andreas Bilz',
    'email' => '<http://www.herooutoftime.com>',
    'authorUrl' => 'http://www.herooutoftime.com',
    'authorSiteName' => "HOOT",
    // 'packageDocumentationUrl' => 'http://bobsguides.com/postler-tutorial.html',
    'copyright' => '2013',

    /* no need to edit this except to change format */
    'createdon' => strftime('%m-%d-%Y'),

    'gitHubUsername' => 'herooutoftime',
    'gitHubRepository' => 'postler',

    /* two-letter code of your primary language */
    'primaryLanguage' => 'en',

    /* Set directory and file permissions for project directories */
    'dirPermission' => 0755,  /* No quotes!! */
    'filePermission' => 0644, /* No quotes!! */

    /* Define source and target directories */

    /* path to MyComponent source files */
    'mycomponentRoot' => $this->modx->getOption('mc.root', null,
        MODX_CORE_PATH . 'components/mycomponent/'),

    /* path to new project root */
    'targetRoot' => MODX_ASSETS_PATH . 'mycomponents/' . $packageNameLower . '/',


    /* *********************** NEW SYSTEM SETTINGS ************************ */

    /* If your extra needs new System Settings, set their field values here.
     * You can also create or edit them in the Manager (System -> System Settings),
     * and export them with exportObjects. If you do that, be sure to set
     * their namespace to the lowercase package name of your extra */

    'newSystemSettings' => array(
        'postler.server' => array( // key
            'key' => 'postler.server',
            'name' => 'Postler Server',
            'description' => 'Description for setting one',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'finch.arvixe.com',
            'area' => 'system',
        ),
        'postler.user' => array( // key
            'key' => 'postler.user',
            'name' => 'Postler User',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'anti@herooutoftime.com',
            'area' => 'system',
        ),
        'postler.pass' => array( // key
            'key' => 'postler.pass',
            'name' => 'Postler Password',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'text-password',
            'inputType' => 'password',
            'value' => 'ibelod',
            'area' => 'system',
        ),
        'postler.port' => array( // key
            'key' => 'postler.port',
            'name' => 'Postler Port',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => '110',
            'area' => 'system',
        ),
        'postler.ssl' => array( // key
            'key' => 'postler.ssl',
            'name' => 'Postler SSL',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'combo-boolean',
            'value' => true,
            'area' => 'system',
        ),
        'postler.special' => array( // key
            'key' => 'postler.special',
            'name' => 'Postler Special',
            'description' => 'Special means some additional string, e.g.: "/imap/ssl/novalidate-cert"',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => '/imap/ssl/novalidate-cert',
            'area' => 'system',
        ),
        'postler.folder' => array( // key
            'key' => 'postler.folder',
            'name' => 'Postler Folder',
            'description' => 'Folder to look into',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'INBOX/mediainfo',
            'area' => 'system',
        ),
        'postler.email' => array( // key
            'key' => 'postler.email',
            'name' => 'Postler Mail Address',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => '',
            'area' => 'system',
        ),
        'postler.success_email' => array( // key
            'key' => 'postler.success_email',
            'name' => 'Postler Success Mail Address',
            'description' => 'Address to send success mails in return. This mail should be used to update resources',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'you@domain.com',
            'area' => 'system',
        ),
        'postler.prefix' => array( // key
            'key' => 'postler.prefix',
            'name' => 'Postler Prefix',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'MODx Resource',
            'area' => 'system',
        ),
        'postler.publish' => array( // key
            'key' => 'postler.publish',
            'name' => 'Postler Publish',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'combo-boolean',
            'value' => true,
            'area' => 'system',
        ),
        'postler.container' => array( // key
            'key' => 'postler.container',
            'name' => 'Postler Container',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => '',
            'area' => 'system',
        ),
        'postler.author' => array( // key
            'key' => 'postler.author',
            'name' => 'Postler Author',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => '',
            'area' => 'system',
        ),
        'postler.template' => array( // key
            'key' => 'postler.template',
            'name' => 'Postler Template',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 1,
            'area' => 'system',
        ),
        'postler.export_dir' => array( // key
            'key' => 'postler.export_dir',
            'name' => 'Postler Export Dir',
            'description' => 'Description for setting two',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'assets/attachments/',
            'area' => 'system',
        ),
        'postler.html_content_by_element' => array( // key
            'key' => 'postler.html_content_by_element',
            'name' => 'Postler HTML Element',
            'description' => 'HTML Element containing the content to fetch.<br/>XPATH compatible:<pre>//div[@class="content"]</pre>',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => '',
            'area' => 'system',
        ),
        'postler.use_markdown' => array( // key
            'key' => 'postler.use_markdown',
            'name' => 'Postler Use Markdown',
            'description' => 'Use the markdown parser',
            'namespace' => 'postler',
            'xtype' => 'combo-boolean',
            'value' => true,
            'area' => 'system',
        ),
        'postler.compare_by' => array( // key
            'key' => 'postler.compare_by',
            'name' => 'Postler Property Comparison',
            'description' => 'Which property should be used to find resources',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'pagetitle',
            'area' => 'system',
        ),
        'postler.after_import_action' => array( // key
            'key' => 'postler.after_import_action',
            'name' => 'Postler After Import Action',
            'description' => 'What do you wish to do with e-mails after succesful import?',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'pagetitle',
            'area' => 'system',
        ),
        'postler.delete_keywords' => array( // key
            'key' => 'postler.delete_keywords',
            'name' => 'Postler Keywords to delete',
            'description' => 'A comma seperated list of keywords to check for delete action',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'delete, remove, expunge, trash',
            'area' => 'system',
        ),
        'postler.delete_address' => array( // key
            'key' => 'postler.delete_address',
            'name' => 'Postler Address to delete action',
            'description' => 'Address to look out for in CC to remove resources',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'delete@herooutoftime.com',
            'area' => 'system',
        ),
        'postler.context' => array( // key
            'key' => 'postler.context',
            'name' => 'Postler context to save resources',
            'description' => 'Postler context to save resources',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'example',
            'area' => 'system',
        ),
        'postler.delete_after' => array( // key
            'key' => 'postler.delete_after',
            'name' => 'Postler Delete After Import',
            'description' => 'Postler attempts to mark the mail as deleted after successful import',
            'namespace' => 'postler',
            'xtype' => 'textfield',
            'value' => 'example',
            'area' => 'system',
        ),
    ),

    /* ************************ NEW SYSTEM EVENTS ************************* */

    /* Array of your new System Events (not default
     * MODX System Events). Listed here so they can be created during
     * install and removed during uninstall.
     *
     * Warning: Do *not* list regular MODX System Events here !!! */

    // 'newSystemEvents' => array(
    //     'OnMyEvent1' => array(
    //         'name' => 'OnMyEvent1',
    //     ),
    //     'OnMyEvent2' => array(
    //         'name' => 'OnMyEvent2',
    //         'groupname' => 'postler',
    //         'service' => 1,
    //     ),
    // ),

    /* ************************ NAMESPACE(S) ************************* */
    /* (optional) Typically, there's only one namespace which is set
     * to the $packageNameLower value. Paths should end in a slash
    */

    'namespaces' => array(
        'postler' => array(
            'name' => 'postler',
            'path' => '{core_path}components/postler/',
            'assets_path' => '{assets_path}components/postler/',
        ),

    ),

    /* ************************ CONTEXT(S) ************************* */
    /* (optional) List any contexts other than the 'web' context here
    */

    // 'contexts' => array(
    //     'postler' => array(
    //         'key' => 'postler',
    //         'description' => 'postler context',
    //         'rank' => 2,
    //     )
    // ),

    /* *********************** CONTEXT SETTINGS ************************ */

    /* If your extra needs Context Settings, set their field values here.
     * You can also create or edit them in the Manager (Edit Context -> Context Settings),
     * and export them with exportObjects. If you do that, be sure to set
     * their namespace to the lowercase package name of your extra.
     * The context_key should be the name of an actual context.
     * */

    // 'contextSettings' => array(
    //     'postler_context_setting1' => array(
    //         'context_key' => 'postler',
    //         'key' => 'postler_context_setting1',
    //         'name' => 'postler Setting One',
    //         'description' => 'Description for setting one',
    //         'namespace' => 'postler',
    //         'xtype' => 'textfield',
    //         'value' => 'value1',
    //         'area' => 'postler',
    //     ),
    //     'postler_context_setting2' => array(
    //         'context_key' => 'postler',
    //         'key' => 'postler_context_setting2',
    //         'name' => 'postler Setting Two',
    //         'description' => 'Description for setting two',
    //         'namespace' => 'postler',
    //         'xtype' => 'combo-boolean',
    //         'value' => true,
    //         'area' => 'postler',
    //     ),
    // ),

    /* ************************* CATEGORIES *************************** */
    /* (optional) List of categories. This is only necessary if you
     * need to categories other than the one named for packageName
     * or want to nest categories.
    */

    'categories' => array(
        'postler' => array(
            'category' => 'postler',
            'parent' => '',  /* top level category */
        ),
        // 'category2' => array(
        //     'category' => 'Category2',
        //     'parent' => 'postler', /* nested under postler */
        // )
    ),

    /* *************************** MENUS ****************************** */

    /* If your extra needs Menus, you can create them here
     * or create them in the Manager, and export them with exportObjects.
     * Be sure to set their namespace to the lowercase package name
     * of your extra.
     *
     * Every menu should have exactly one action */

    // 'menus' => array(
    //     'postler' => array(
    //         'text' => 'postler',
    //         'parent' => 'components',
    //         'description' => 'ex_menu_desc',
    //         'icon' => '',
    //         'menuindex' => 0,
    //         'params' => '',
    //         'handler' => '',
    //         'permissions' => '',

    //         'action' => array(
    //             'id' => '',
    //             'namespace' => 'postler',
    //             'controller' => 'index',
    //             'haslayout' => true,
    //             'lang_topics' => 'postler:default',
    //             'assets' => '',
    //         ),
    //     ),
    // ),


    /* ************************* ELEMENTS **************************** */

    /* Array containing elements for your extra. 'category' is required
       for each element, all other fields are optional.
       Property Sets (if any) must come first!

       The standard file names are in this form:
           SnippetName.snippet.php
           PluginName.plugin.php
           ChunkName.chunk.html
           TemplateName.template.html

       If your file names are not standard, add this field:
          'filename' => 'actualFileName',
    */


    'elements' => array(

        // 'propertySets' => array( /* all three fields are required */
        //     'PropertySet1' => array(
        //         'name' => 'PropertySet1',
        //         'description' => 'Description for PropertySet1',
        //         'category' => 'postler',
        //     ),
        //     'PropertySet2' => array(
        //         'name' => 'PropertySet2',
        //         'description' => 'Description for PropertySet2',
        //         'category' => 'postler',
        //     ),
        // ),

        'snippets' => array(
            'postler' => array(
                'category' => 'postler',
                'description' => 'Description for Snippet one',
                'static' => true,
            ),

        ),
        // 'plugins' => array(
        //     'Plugin1' => array( /* minimal postler */
        //         'category' => 'postler',
        //     ),
        //     'Plugin2' => array( /* postler with static, events, and property sets */
        //         'category' => 'postler',
        //         'description' => 'Description for Plugin one',
        //         'static' => false,
        //         'propertySets' => array( /* all property sets to be connected to element */
        //             'PropertySet1',
        //         ),
        //         'events' => array(
        //             /* minimal postler - no fields */
        //             'OnUserFormSave' => array(),
        //             /* postler with fields set */
        //             'OnMyEvent1' => array(
        //                 'priority' => '0', /* priority of the event -- 0 is highest priority */
        //                 'group' => 'plugins', /* should generally be set to 'plugins' */
        //                 'propertySet' => 'PropertySet1', /* property set to be used in this pluginEvent */
        //             ),
        //             'OnMyEvent2' => array(
        //                 'priority' => '3',
        //                 'group' => 'plugins',
        //                 'propertySet' => '',
        //             ),
        //             'OnDocFormSave' => array(
        //                 'priority' => '4',
        //                 'group' => 'plugins',
        //                 'propertySet' => '',
        //             ),


        //         ),
        //     ),
        // ),
        // 'chunks' => array(
        //     'Chunk1' => array(
        //         'category' => 'postler',
        //     ),
        //     'Chunk2' => array(
        //         'description' => 'Description for Chunk two',
        //         'category' => 'postler',
        //         'static' => false,
        //         'propertySets' => array(
        //             'PropertySet2',
        //         ),
        //     ),
        // ),
        // 'templates' => array(
        //     'Template1' => array(
        //         'category' => 'postler',
        //     ),
        //     'Template2' => array(
        //         'category' => 'postler',
        //         'description' => 'Description for Template two',
        //         'static' => false,
        //         'propertySets' => array(
        //             'PropertySet2',
        //         ),
        //     ),
        // ),
        'templateVars' => array(
            'message_id' => array(
                'category' => 'postler',
                'description' => 'Description for TV one',
                'caption' => 'TV One',
                'propertySets' => array(
                    'PropertySet1',
                    'PropertySet2',
                ),
                'templates' => array(
                    'default' => 1,
                    'Template1' => 4,
                    'Template2' => 4,


                ),
            )
        ),
    ),
    /* (optional) will make all element objects static - 'static' field above will be ignored */
    'allStatic' => false,


    /* ************************* RESOURCES ****************************
     Important: This list only affects Bootstrap. There is another
     list of resources below that controls ExportObjects.
     * ************************************************************** */
    /* Array of Resource pagetitles for your Extra; All other fields optional.
       You can set any resource field here */
    // 'resources' => array(
    //     'Resource1' => array( /* minimal postler */
    //         'pagetitle' => 'Resource1',
    //         'alias' => 'resource1',
    //         'context_key' => 'postler',
    //     ),
    //     'Resource2' => array( /* postler with other fields */
    //         'pagetitle' => 'Resource2',
    //         'alias' => 'resource2',
    //         'context_key' => 'postler',
    //         'parent' => 'Resource1',
    //         'template' => 'Template2',
    //         'richtext' => false,
    //         'published' => true,
    //         'tvValues' => array(
    //             'Tv1' => 'SomeValue',
    //             'Tv2' => 'SomeOtherValue',
    //         ),
    //     ),
    // ),


    /* Array of languages for which you will have language files,
     *  and comma-separated list of topics
     *  ('.inc.php' will be added as a suffix). */
    'languages' => array(
        'en' => array(
            'default',
            'properties',
            'forms',
        ),
        'de' => array(
            'default',
            'properties',
            'forms',
        ),
    ),
    /* ********************************************* */
    /* Define optional directories to create under assets.
     * Add your own as needed.
     * Set to true to create directory.
     * Set to hasAssets = false to skip.
     * Empty js and/or css files will be created.
     */
    'hasAssets' => false,

    'assetsDirs' => array(
        /* If true, a default (empty) CSS file will be created */
        'css' => true,

        /* If true, a default (empty) JS file will be created */
        'js' => true,

        'images' => true,
        'audio' => true,
        'video' => true,
        'themes' => true,
    ),
    /* minify any JS files */
    'minifyJS' => true,
    /* Create a single JS file from all JS files */
    'createJSMinAll' => true,
    /* if this is false, regular jsmin will be used.
       JSMinPlus is slower but more reliable */
    'useJSMinPlus' => true,

    /* These will automatically go under assets/components/yourcomponent/js/
       Format: directory:filename
       (no trailing slash on directory)
       if 'createCmpFiles is true, these will be ignored.
    */
    $jsFiles = array(
        'postler.js',
    ),


    /* ********************************************* */
    /* Define basic directories and files to be created in project*/

    'docs' => array(
        'readme.txt',
        'license.txt',
        'changelog.txt',
        'tutorial.html'
    ),

    /* (optional) Description file for GitHub project home page */
    'readme.md' => true,
    /* assume every package has a core directory */
    'hasCore' => true,

    /* ********************************************* */
    /* (optional) Array of extra script resolver(s) to be run
     * during install. Note that resolvers to connect plugins to events,
     * property sets to elements, resources to templates, and TVs to
     * templates will be created automatically -- *don't* list those here!
     *
     * 'default' creates a default resolver named after the package.
     * (other resolvers may be created above for TVs and plugins).
     * Suffix 'resolver.php' will be added automatically */
    'resolvers' => array(
        'default',
        'addUsers'
    ),

    /* (optional) Validators can abort the install after checking
     * conditions. Array of validator names (no
     * prefix of suffix) or '' 'default' creates a default resolver
     *  named after the package suffix 'validator.php' will be added */

    'validators' => array(
        'default',
        'hasGdLib'
    ),

    /* (optional) install.options is needed if you will interact
     * with user during the install.
     * See the user.input.php file for more information.
     * Set this to 'install.options' or ''
     * The file will be created as _build/install.options/user.input.php
     * Don't change the filename or directory name. */
    'install.options' => 'install.options',


    /* Suffixes to use for resource and element code files (not implemented)  */
    'suffixes' => array(
        'modPlugin' => '.php',
        'modSnippet' => '.php',
        'modChunk' => '.html',
        'modTemplate' => '.html',
        'modResource' => '.html',
    ),


    /* ********************************************* */
    /* (optional) Only necessary if you will have class files.
     *
     * Array of class files to be created.
     *
     * Format is:
     *
     * 'ClassName' => 'directory:filename',
     *
     * or
     *
     *  'ClassName' => 'filename',
     *
     * ('.class.php' will be appended automatically)
     *
     *  Class file will be created as:
     * yourcomponent/core/components/yourcomponent/model/[directory/]{filename}.class.php
     *
     * Set to array() if there are no classes. */
    'classes' => array(
        'postler' => 'postler:postler',
    ),

    /* ************************************
     *  These values are for CMPs.
     *  Set any of these to an empty array if you don't need them.
     *  **********************************/

    /* If this is false, the rest of this section will be ignored */

    'createCmpFiles' => false,

    /* IMPORTANT: The array values in the rest of
       this section should be all lowercase */

    /* This is the main action file for your component.
       It will automatically go in core/component/yourcomponent/
    */

    'actionFile' => 'index.php',

    /* CSS file for CMP */

    'cssFile' => 'mgr.css',

    /* These will automatically go to core/components/yourcomponent/processors/
       format directory:filename
       '.class.php' will be appended to the filename

       Built-in processor classes include getlist, create, update, duplicate,
       import, and export. */

    'processors' => array(
        'mgr/snippet:getlist',
        'mgr/snippet:changecategory',
        'mgr/snippet:remove',

        'mgr/chunk:getlist',
        'mgr/chunk:changecategory',
        'mgr/chunk:remove',
    ),

    /* These will automatically go to core/components/yourcomponent/controllers[/directory]/filename
       Format: directory:filename */

    'controllers' => array(
        ':index.php',
        'mgr:header.php',
        'mgr:home.php',
    ),

    /* These will automatically go in assets/components/yourcomponent/ */

    'connectors' => array(
        'connector.php'

    ),
    /* These will automatically go to assets/components/yourcomponent/js[/directory]/filename
       Format: directory:filename */

    'cmpJsFiles' => array(
        ':postler.js',
        'sections:home.js',
        'widgets:home.panel.js',
        'widgets:snippet.grid.js',
        'widgets:chunk.grid.js',
    ),


    /* *******************************************
     * These settings control exportObjects.php  *
     ******************************************* */
    /* ExportObjects will update existing files. If you set dryRun
       to '1', ExportObjects will report what it would have done
       without changing anything. Note: On some platforms,
       dryRun is *very* slow  */

    'dryRun' => '0',

    /* Array of elements to export. All elements set below will be handled.
     *
     * To export resources, be sure to list pagetitles and/or IDs of parents
     * of desired resources
    */
    'process' => array(
        // 'contexts',
        'snippets',
        // 'plugins',
        'templateVars',
        // 'templates',
        // 'chunks',
        // 'resources',
        // 'propertySets',
        'systemSettings',
        // 'contextSettings',
        // 'systemEvents',
        // 'menus'
    ),
    /*  Array  of resources to process. You can specify specific resources
        or parent (container) resources, or both.

        They can be specified by pagetitle or ID, but you must use the same method
        for all settings and specify it here. Important: use IDs if you have
        duplicate pagetitles */
    // 'getResourcesById' => false,

    // 'exportResources' => array(
    //     'Resource1',
    //     'Resource2',
    // ),
    /* Array of resource parent IDs to get children of. */
    // 'parents' => array(),
    /* Also export the listed parent resources
      (set to false to include just the children) */
    // 'includeParents' => false,


    /* ******************** LEXICON HELPER SETTINGS ***************** */
    /* These settings are used by LexiconHelper */
    'rewriteCodeFiles' => false,  /* remove ~~descriptions */
    'rewriteLexiconFiles' => true, /* automatically add missing strings to lexicon files */
    /* ******************************************* */

    /* Array of aliases used in code for the properties array.
     * Used by the checkproperties utility to check properties in code against
     * the properties in your properties transport files.
     * if you use something else, add it here (OK to remove ones you never use.
     * Search also checks with '$this->' prefix -- no need to add it here. */
    'scriptPropertiesAliases' => array(
        'props',
        'sp',
        'config',
        'scriptProperties'
    ),
);

return $components;