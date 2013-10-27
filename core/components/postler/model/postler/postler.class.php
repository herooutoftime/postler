<?php
// error_reporting(-1);
/**
 * postler class file for postler extra
 *
 * Copyright 2013 by Andreas Bilz <http://www.herooutoftime.com>
 * Created on 10-18-2013
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
 *
 * @package postler
 */

 class Postler {

 	public $modx;
	public $resource;

	protected $conn;
	protected $params;
	protected $prepare;
	protected $mail;

	private $mails;

	public function __construct(modX &$modx, $options = array())
	{
		$this->modx =& $modx;
        $corePath = $modx->getOption('postler.core_path',null,
            $modx->getOption('core_path').'components/postler/');
        $assetsUrl = $modx->getOption('postler.assets_url',null,
            $modx->getOption('assets_url').'components/postler/');
		$basePath = $this->modx->getOption('postler.core_path',$config,$this->modx->getOption('core_path').'components/postler/');
		
		$config = array();

		$this->config = array_merge(array(
            'corePath' => $corePath,
            'chunksPath' => $corePath.'elements/chunks/',
            'modelPath' => $corePath.'model/',
            'processorsPath' => $corePath.'processors/',

            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
        ),$config);

        $this->modx->addPackage('postler',$this->config['modelPath']);

		// header('Content-Type: text/html; charset=utf-8');
		// Autoload composer packages
		require $basePath . 'vendor/autoload.php';

		$this->prepare = array();
		$this->params = array_merge($options, array(
			'runtime'			=> array(),
			'from'				=> array(),
			'resource'			=> array(),
			'server'			=> $this->modx->getOption('postler.server'),
			'user'				=> $this->modx->getOption('postler.user'),
			'pass'				=> $this->modx->getOption('postler.pass'),
			'port'				=> $this->modx->getOption('postler.port'),
			'special'			=> $this->modx->getOption('postler.special'),
			'mailbox'			=> $this->modx->getOption('postler.mailbox'),
			'folder'			=> $this->modx->getOption('postler.folder'),
			'email'				=> $this->modx->getOption('postler.email'),					//Only import mails from this mail address
			'prefix'			=> $this->modx->getOption('postler.prefix'),				//Only import mails with this subject
			'strip_prefix'		=> $this->modx->getOption('postler.strip_prefix'),
			'publish'			=> $this->modx->getOption('postler.publish'),				//Immediately publish true or false
			'container'			=> $this->modx->getOption('postler.container'),				//Define a container, empty means root
			'context'			=> $this->modx->getOption('postler.context', null, 'web'),
			'author'			=> $this->modx->getOption('postler.author'),				//Find a user with this email and set as author
			'template'			=> $this->modx->getOption('postler.template'),				//Set a template
			'import_attachments'=> $this->modx->getOption('postler.import_attachments'),
			'import_directory'	=> $this->modx->getOption('postler.import_dir'),			//Choose a directory to store the attachments (relative to base_path)
			'import_tv_image'	=> $this->modx->getOption('postler.import_tv_image'),
			'import_tv_file'	=> $this->modx->getOption('postler.import_tv_file'),
			'content_element'	=> $this->modx->getOption('postler.content_element'),
			'use_markdown'		=> $this->modx->getOption('postler.use_markdown'),			//Use markdown parser
			'compare_by'		=> $this->modx->getOption('postler.compare_by'),
			'success_email'		=> $this->modx->getOption('postler.success_email'),			//Mail address to send success mails to, if this is set all emails will be sent to this address. Default replies to sender
			'delete_keywords'	=> $this->modx->getOption('postler.delete_keywords'),	//Keywords to look out for for delete action
			'delete_address'	=> $this->modx->getOption('postler.delete_address'),	//Keywords to look out for for delete action
			'dryrun'			=> $this->modx->getOption('postler.dryrun'),
			'delete_after'		=> $this->modx->getOption('postler.delete_after'),
			'store_mail'		=> $this->modx->getOption('postler.store_mail'),
			'mail_directory'	=> $this->modx->getOption('postler.mail_directory'),
			'allowed_filetypes'	=> explode(',', $this->modx->getOption('postler.allowed_filetypes')),
			'save_mail'			=> $this->modx->getOption('postler.save_mail'),
			'save_mail_dir'		=> $this->modx->getOption('postler.save_mail_dir', null, 'postler/'),
			'tv_message_id'		=> $this->modx->getOption('postler.tv_message_id'),
			'send_html'			=> $this->modx->getOption('postler.html_emails'),
			// 'resend'	=> $this->modx->getOption('postler.resend', null, FALSE)		//Mail me even on a reply (which is not needed really)
			));
		if($this->params['dryrun'])
			$this->logs['parameters'][] = 'BE AWARE: THIS IS A SIMULATION! NO DATA WILL BE STORED!';
	}

	public function initialize($ctx = 'mgr') {
        $output = '';
        switch ($ctx) {
            case 'mgr':
                if (!$this->modx->loadClass('Postler.request.postlerControllerRequest',
                    $this->config['modelPath'],true,true)) {
                        return 'Could not load controller request handler.';
                }
                $this->request = new postlerControllerRequest($this);
                $output = $this->request->handleRequest();
                break;
        }
        return $output;
    }

	/**
	 * Open imap connection
	 * @return boolean	True or false
	 */
	public function connect()
	{
		$start = $this->modx->getMicroTime();
		// $this->params['port'] = 143;
		// $this->params['special'] = '/imap';
		$this->params['host'] = '{'.$this->params['server'].':'.$this->params['port'].$this->params['special'].'}'.$this->params['folder'];
		$this->logs['connection'][] = $this->params['host'];
		$this->logs['connection'][] = $this->params['server'];
		$this->logs['connection'][] = $this->params['port'];
		$this->logs['connection'][] = $this->params['special'];
		$this->logs['connection'][] = $this->params['folder'];

		// $this->params['host'] = '{imap.gmail.com:993/imap/ssl}INBOX';
		// $this->params['user'] = 'andreas.bilz@gmail.com';
		// $this->params['pass'] = 'vd231ipu09';

		$this->conn = imap_open($this->params['host'], $this->params['user'], $this->params['pass']) 
			or die('Cannot connect: ' . print_r(imap_errors()));
		
		$end = $this->modx->getMicroTime();
		$this->logs['timing']['connection'] = sprintf("%2.4f", $end - $start);
		if($this->conn)
			return true;
		return false;
	}
	
	/**
	 * Close imap connection
	 * @return [type]
	 */
	public function close()
	{
		imap_close($this->conn);
	}

	/**
	 * Fetch specific messages
	 * @return array
	 */
	public function search() {
		$start = $this->modx->getMicroTime();
		$criteria_str[] = 'UNDELETED';
		if($this->params['email'])
			$criteria_str[] = 'FROM "' . $this->params['email'] . '"';
		if($this->params['prefix'])
			$criteria_str[] = 'SUBJECT "' . $this->params['prefix'] . '"';
		$this->logs['criteria'][] = 'CRITERIA ' . implode(' ', $criteria_str);
		// if(!empty($this->params['prefix']))
		// 	$criteria_str .= 'SUBJECT "' . $this->params['prefix'] . '"';
        $search = imap_search($this->conn, implode(' ', $criteria_str));
        $end = $this->modx->getMicroTime();
        $this->logs['timing']['criteria'] = sprintf("%2.4f", $end - $start);
        return $search;
	}

	/**
	 * Get a message
	 * @param  integer $uid
	 * @return array
	 */
	public function get($uid)
	{
		$msg = array(
			'uid'		=> $uid,
			'header'    => imap_headerinfo($this->conn, $uid),
        	'body'      => imap_fetchbody($this->conn, $uid, 1),
        	'structure' => imap_fetchstructure($this->conn, $uid)
        	);
		return $msg;
	}
	
	/**
	 * @todo Attempt to make criteria as flexible as possible
	 */
	public function read()
	{

		if(!$this->connect())
			return false;
		
		$found = $this->search();
		$cnt = 0;
		// $found = array(277);
		if(!is_array($found))
			$this->logs['result'][] = 'No mails were found';
		foreach($found as $uid) {
			$this->logs['item'] = array();
			$this->logs['reports'] = array();

			$mail = $this->get($uid);
			if(!$mail)
				continue;
			
			$this->mail = $mail;
			$this->params['runtime']['uid'] = $uid;

			//Exclude certain messages by subject
			if(!empty($this->params['exclude']) && strpos(imap_utf8($mail['header']->subject), $this->params['exclude']) !== FALSE)
				continue;

			// Analyze the current message
			// False means we removed a message and go to the next in line
			if(!$this->analyze($mail))
				continue;
			
			$start = $this->modx->getMicroTime();
			$this->import();
			$end = $this->modx->getMicroTime();
			$this->logs['timing']['import'] = sprintf("%2.4f", $end - $start);

			// Mail me when new, replies won't be sent again (v0.1)
			// Used to update a resource
			if(!$this->params['dryrun'])
				if($this->params['runtime']['send'])
					if(!$this->sendmail())
						return 'Error sending mail!';

			// Mark message as deleted from inbox
			if(!$this->params['dryrun'])
				if(!$this->params['delete_after'])
					if(!imap_delete($this->conn, $this->params['runtime']['uid']))
						echo 'Imap could not delete message';
			
			// Sum up the total timings
			$this->logs['timing']['total'] = array_sum($this->logs['timing']);
			
			// Generate report output
			$this->logs['reports'][] = $this->generate_output();
			$cnt++;
		}
		$this->close();
		return $this->logs;
	}

	/**
	 * Analyze a message and prepare data
	 * 
	 * @param  array $mail
	 * @return boolean
	 */
	public function analyze($mail)
	{
		$start = $this->modx->getMicroTime();
		// echo '<br/>';
		// echo iconv_mime_decode($mail['header']->subject,0,"UTF-8") . ' - ' . $mail['header']->date . '<br/>';

		/**
		 * Analyze header
		 * * Subject
		 * ** to update
		 * ** to delete
		 */
		// Let's check if we are having a reply (UPDATE) or a new mail
        $this->params['runtime'] = array(
        	'message_id' => $mail['header']->message_id,
        	'send' => TRUE,
        	'update' => FALSE,
        	);

        // Find the message id in the subject
        // If TRUE: Sets TV 'message_id' to find the resource by
        preg_match('/<(.*)>/', $mail['header']->subject, $reply);
        if(count($reply) >= 1) {
        	$this->params['runtime'] = array(
        		'update' => TRUE,
        		'send' => FALSE,
        		'message_id' => $reply[0],
        		);
        }

        $this->params['from']['name'] = $mail['header']->from[0]->personal;
		$this->params['from']['address'] = $mail['header']->from[0]->mailbox . '@' . $mail['header']->from[0]->host;

        // Find any of the deposited strings which identifies a deleted message
        // And instantly remove the related resource!
        // if($this->removal_check())
        // 	if($this->remove())
        // 		return false;
        // var_dump($mail['structure']);
		// Default content will be the mail body
		$content = $mail['body'];
		// Choose encoding mode
		if($mail['structure']->encoding == 3)
    		$content = imap_base64($mail['body']);
		if($mail['structure']->encoding == 4)
    		$content = imap_qprint($mail['body']);

		// Special encoding ISO-8859-1 => UTF8
		if($mail['structure']->parameters[0]->value == 'iso-8859-1')
			$content = mb_convert_encoding($content, "UTF-8", "Windows-1252");

		$this->params['runtime']['content'] = $content;
		
		// XPATH querying
		if(!empty($this->params['content_element']))
			$content = $this->search_dom($this->params['runtime']['content']);
		
		$attachments = $this->get_attachments($mail['structure']);
		foreach ($attachments as $k => $at) {
        	// If the attachment is a .md file and we should use markdown, use it...
        	if(in_array(pathinfo($at['filename'], PATHINFO_EXTENSION), $this->params['allowed_filetypes']) && pathinfo($at['filename'], PATHINFO_EXTENSION) === 'md' && $this->params['use_markdown']) {
        		// var_dump($at);
        		$this->params['runtime']['markdown'] = imap_fetchbody($this->conn, $mail['uid'], $at['part']);
        		// $content = $this->parse_md();
        		continue;
        	}
        }

		// Lets give markdown a chance
		if($this->params['use_markdown'] && $this->params['runtime']['markdown'])
			$content = $this->parse_md($this->params['runtime']['markdown']);
		
		// Do we need to import attachments as well?
		$tv = array();
		if($this->params['import_attachments']) {
	 		// $import_directory = $this->modx->getOption('base_path') . $this->params['import_directory'];
	 		// var_dump($attachments);
	        // You are now able to get attachments' raw content
	        $att_storage = array();
	        // var_dump($attachments);

	        foreach ($attachments as $k => $at) {
	        	// If the attachment is a .md file and we should use markdown, use it...
	        	// if(pathinfo($at['filename'], PATHINFO_EXTENSION) === 'md' && $this->params['use_markdown']) {
	        	// 	$this->params['runtime']['content'] = quoted_printable_decode($content);
	        	// 	$content = $this->parse_md();
	        	// 	continue;
	        	// }
	        	
	        	// Do not handle MD files
	        	if(pathinfo($at['filename'], PATHINFO_EXTENSION) === 'md')
	        		continue;
	        	// If this filetype is not allowed go to next item
	        	if(!empty($this->params['allowed_filetypes'][0]))
	        		if(!in_array(pathinfo($at['filename'], PATHINFO_EXTENSION), $this->params['allowed_filetypes']))
	        			continue;
	            $filename = $at['filename'];
	            $att_storage[$k]['file'] = $filename;
	            // echo $filename;
	            $attachment = imap_fetchbody($this->conn, $mail['uid'], $at['part']);
	            
	 			$att_storage[$k]['image'] = false;
	            if ($attachment !== false && strlen($attachment) > 0 && $attachment != '') {

	            	$file_rel = $this->params['import_directory'] . date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . $filename;
	                
	                switch ($at['encoding']) {
	                    case '3':
	                    	$att_storage['image'] = $filename;
	                    	$att_storage[$k]['image'] = true;
	                        $attachment = base64_decode($attachment);
	                        $tv[$this->params['import_tv_image']] = $file_rel;
	                    break;
	 
	                    case '4':
	                        $attachment = quoted_printable_decode($attachment);
	                        $tv[$this->params['import_tv_file']] = $file_rel;
	                    break;

	                    default:
	                    	$tv[$this->params['import_tv_file']] = $file_rel;
	                    break;
	                }
	                if($this->modx->cacheManager->writeFile($this->modx->getOption('base_path') . $file_rel, $attachment))
	                	$this->logs['attachments'][] = 'FILE WAS SAVED: ' . $file_rel;
	            }
	        }
	    }
	
		// Do not update the pagetitle when updating!
        $pagetitle = array();
        if(!$this->params['runtime']['update']) {
        	$pagetitle = array('pagetitle' => trim(iconv_mime_decode($mail['header']->subject,0,"UTF-8")));
        	// Do we want to strip the prefix?
        	if($this->params['strip_prefix'])
        		$pagetitle = array('pagetitle' => trim(str_replace($this->params['prefix'], '', iconv_mime_decode($mail['header']->subject,0,"UTF-8"))));
        }

		$this->prepare = array(
			'resource' => array_merge(array(
				// 'pagetitle'	=> trim(str_replace($this->params['prefix'], '', $mail['header']->subject)),
				'content'		=> nl2br($content),
				'template'		=> $this->params['template'],
				'published'		=> $this->params['publish'],
				'publishedon'	=> strtotime($mail['header']->date),
				'parent'		=> $this->params['container'],
				'context_key'	=> $this->params['context'],
				'createdby'		=> $this->findUserByEmail($this->mail['header']->from[0]->mailbox . '@' . $this->mail['header']->from[0]->host),
			), $pagetitle),
			'tv' => array_merge(array(
				$this->params['tv_message_id']	=> $this->params['runtime']['message_id'],
			), $tv),
		);
		$end = $this->modx->getMicroTime();
		$this->logs['timing']['analyze'] = sprintf("%2.4f", $end - $start);
		return true;
	}

	/**
	 * Search the DOM for pattern and store its content
	 * 
	 * @todo Needs some lines of how-to!
	 * @return string
	 */
	public function search_dom($input = null)
	{
		require_once $this->modx->getOption('core_path') .'/components/postler/vendor/htmlpurifier-4.5.0-lite/library/HTMLPurifier.auto.php';

		$nice = '';
		$content = mb_convert_encoding($input, "HTML-ENTITIES", "UTF-8");
		$search = $this->params['content_element'];
		
		$dom = new DOMDocument;
		$dom->loadHTML($content);

		$xpath = new DOMXpath($dom); 
		$res = $xpath->query($search);

		if(!$res->length > 0) echo 'nothing in here';
		// $res->c14N(false,true);
		foreach ($res as $child) {
	        $nice .= $child->ownerDocument->saveXML( $child );
	    }

	    // Pretty the HTML - we know newsletters can be really ugly
	    $config = HTMLPurifier_Config::createDefault();
		$config->set('HTML.ForbiddenElements', array('td','span'));
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($nice);
		// return mb_convert_encoding($clean_html, "HTML-ENTITIES", "UTF-8");
	}

	/**
	 * Imports resources into MODx
	 * 
	 * Finds existing resources by 2 methods
	 * * by 'subject' which is compared to 'pagetitle'
	 * * by 'message_id' which is compared to TV 'message_id'
	 *
	 * @return boolean
	 */
	public function import()
	{
		$comparison = $this->params['compare_by'];
		// Which comparison mode is chosen
		// If ':' as a delimiter is found, we need to deal with a TV
		// Else not found we use the subject and compare with pagetitle
		if(strpos($comparison, ':') !== FALSE || $this->params['runtime']['update']) {
			// Identify the resource by the message id
			$msg_id = $this->prepare['tv']['message_id'];
			
			// Find TV with value
			$tmplvars = $this->modx->getObject('modTemplateVarResource', array('tmplvarid' => 1, 'value' => $msg_id));
			// Find the corresponding resource
			if($tmplvars)
				$this->resource = $this->modx->getObject('modResource', array('id' => $tmplvars->get('contentid')));
		} else {
			$pagetitle = $this->prepare['resource']['pagetitle'];
			$this->resource = $this->modx->getObject('modResource', array(
				'pagetitle:LIKE' => str_replace(array('"', '&', 'ü'), array('%', '%', '%'), $this->prepare['resource']['pagetitle']),
				'parent' => $this->params['container'],
				)
			);
		}
		// Store the mode of the resource
		$this->params['runtime']['mode'] = 'new';
		if($this->resource)
			$this->params['runtime']['mode'] = 'update';
			
		// Ok, no resource found earlier, let's create a new one
		if(!$this->resource)
			$this->resource = $this->modx->newObject('modResource');
		
		$this->resource->fromArray($this->prepare['resource']);

		// Just simulate - nothing will be saved
		// $this->params['dryrun'] = true;
		if(!$this->params['dryrun'])
			if(!$this->resource->save())	// Ups, something went wrong
				return 'false';
		
		// Save the mail in file-system
		if($this->params['save_mail'])
			$this->save_mail($this->mail, true);

		// Save all TVs
		if(!$this->params['dryrun']) {
			foreach ($this->prepare['tv'] as $key => $value) {
				if(!$this->resource->setTVValue($key, $value))
					return false;
			}
		}
		$this->params['resource'] = $this->resource->get('id');
		$this->prepare['resource']['id'] = $this->resource->get('id');
		return true;
	}
	
	/**
	 * Find user by email
	 * Finds a user by a given email and returns the user object
	 * @param string $email Email address
	 * @return object User object if found
	 */
	public function findUserByEmail($email)
	{
		$profile = $this->modx->getObject('modUserProfile', array('email' => $email));
		// No connected profile found => FALSE
		if(!$profile)
			return false;
		$user = $profile->getOne('User');
        $this->logs['resource'][] = 'USER ID: ' . $user->get('id');
        $this->logs['resource'][] = 'USER EMAIL: ' . $profile->get('email');
		return $user->get('id');
	}

	/**
	 * Save mail contents in MODx cache
	 * @param  mixed $mail Either object or string
	 * @return boolean       True on success, false on error
	 */
	public function save_mail($mail)
	{
		$cacheOptions = array(
            xPDO::OPT_CACHE_KEY => '',
            xPDO::OPT_CACHE_HANDLER => 'xPDOFileCache',
            xPDO::OPT_CACHE_EXPIRES => 0,
            );
        $cacheElementKey = $this->params['save_mail_dir'] . $this->resource->get('id');
        $this->modx->cacheManager->set($cacheElementKey, $mail, 0, $cacheOptions);
	}

	/**
	 * Generate output from array
	 * @param  array $array Array to output
	 * @return string        HTML
	 */
	public function generate_output($report = false)
	{
		if(!$array) {
			$report = array(
				'Logs'		=> $this->logs,
				'Runtime'	=> $this->params['runtime'],
				'Resource'	=> $this->prepare['resource'],
				'TV'		=> $this->prepare['tv'],
			);	
		}
		
		if(!is_array($report))
			return 'No data given';

		$table = array(
			'start' => '<table class="table table-condensed">',
			'end'	=> '</table>');
		$caption = array(
			'start' => '<caption>',
			'end' => '</caption>',
			);
		$row = array(
			'start' => '<tr>',
			'end' => '</tr>',
			);
		$column = array(
			'start' => '<td>',
			'end' => '</td>',
			);
		$delimiter = '';
		$spacer = '<hr/>';
		if(!$this->params['send_html']) {
			$table = array(
				'start' => "\n",
				'end' => "\n",
				);
			$caption = array(
				'start' => '*** ',
				'end' => ' ***' . "\n",
				);
			$row = array(
				'start' => '',
				'end' => "\n",
				);
			$column = array(
				'start' => '',
				'end' => '',
				);
			$delimiter = ': ';
			$spacer = str_repeat('-', 50);
		}

		$thumbQuery = array(
            'src' => null,
            'w' => 200,
            'h' => 100,
            // 'f' => $thumbnailType,
            // 'q' => $thumbnailQuality,
            // 'far' => 1,
            'HTTP_MODAUTH' => $this->modx->user->getUserToken($this->modx->context->get('key')),
            'wctx' => 'web',
            'source' => 1,
        );

		foreach($report as $title => $data) {
			$o[] = $table['start'];
			$o[] = $caption['start'] . $title . $caption['end'];
			$pad = max(array_map('strlen', array_keys($data))) + 5;
			foreach($data as $key => $value) {
				
				if(!$this->params['send_html'])
					$key = str_pad($key . $delimiter, $pad);
				
				// Output image TV as <img>
				if($this->params['send_html'])
					if($key == $this->params['import_tv_image']) {
						// $image = $this->modx->context->getOption('connectors_url', MODX_CONNECTORS_URL).'system/phpthumb.php?'.urldecode(http_build_query(array_merge($thumbQuery, array('src' => $value))));
      //               	$value = '<img src="' . $image . '" />';
						$value = '<img src="' . $this->modx->getOption('site_url') . $value . '" />';
					}
				
				if(is_array($value))
					$o[] = $row['start'] . $column['start'] . $key . $column['end'] . $column['start'] . serialize($value) . $column['end'] . $row['end'];
				else
					$o[] = $row['start'] . $column['start'] . $key . $column['end'] . $column['start'] . substr($value, 0, 250) . $column['end'] . $row['end'];
			}
			$o[] = $table['end'];
		}
		$o[] = $spacer;
		return implode('', $o);
	}

	/**
	 * Check for removal process
	 * 
	 * @return boolean
	 */
	public function removal_check()
	{
		$remove = false;
		// Check CC for email address to delete
		if($mail['header']->cc == $this->params['delete_address'])
			$remove = true;

		// Find a keyword for delete in subject
		$delete_strings = explode(',', $this->params['delete_keywords']);
        if($this->contains($mail['header']->subject, $delete_strings))
        	$remove = true;
        return $remove;
	}

	/**
	 * Mark resource as deleted and mark message as deleted
	 *
	 * @return boolean
	 */
	public function remove()
	{
		// Try to find it by message id
		// Find TV with value
		$tmplvars = $this->modx->getObject('modTemplateVarResource', array('tmplvarid' => 1, 'value' => $this->params['runtime']['message_id']));
		// Find the corresponding resource
		if($tmplvars)
			$res = $this->modx->getObject('modResource', array('id' => $tmplvars->contentid));
		
		// Not a resource
		if(!$res)
			return false;
		
		echo '<strong>WILL BE DELETED ' . $res->get('pagetitle') . '</strong>';
		$res->set('deleted', 1);
		if(!$res->save() || !imap_delete($this->conn, $this->params['runtime']['uid']))
			return false;
		return true;
	}

	/**
	 * Find array of strings in input
	 * 
	 * @param string $str String to search in
	 * @param array $search Array of strings
	 * @return boolean
	 */
	public function contains($str, $search)
	{
		$no = false;
		foreach($search as $pattern) {
			$pattern = trim($pattern);
			echo $pattern . '<br/>';
			if (preg_match("/\b$pattern\b/i", $str)) {
    			$no = true;
    		break;
  			}
		}
    	return $no;
	}

	/**
	 * Parse markdown inline or attachments
	 * 
	 * Attachments must have .md extension
	 * @return string
	 */ 
	public function parse_md($input = null)
	{
		$md = new \Michelf\Markdown;
		$md_html = $md->defaultTransform($input);
		return $md_html;
	}
	/**
	 * Send a mail as response for successful resource handling
	 * 
	 * This mail should be used to update resources as easy as possible by replying to it.
	 * @return boolean
	 */
	public function sendmail()
	{
		$to = $this->params['success_email'] ? $this->params['success_email'] : $this->params['from']['address'];
		$msg = $this->generate_output(true);
		$this->modx->getService('mail', 'mail.modPHPMailer');
		// $this->modx->mail->set(modMail::MAIL_BODY,'BLOB');
		$this->modx->mail->set(modMail::MAIL_FROM, 'anti@herooutoftime.com');
		$this->modx->mail->set(modMail::MAIL_FROM_NAME, 'MODX HOOT');
		$this->modx->mail->set(modMail::MAIL_SUBJECT, 'MODx Resource: ' . $this->prepare['tv']['message_id']);
		$this->modx->mail->set(modMail::MAIL_BODY, $msg);
		$this->modx->mail->address('to', $to);
		$this->modx->mail->address('reply-to', 'anti@herooutoftime.com');
		$this->modx->mail->setHTML($this->params['send_html']);
		if (!$this->modx->mail->send()) {
		    $this->logs[] = 'An error occurred while trying to send the email: '.$this->modx->mail->mailer->ErrorInfo;
		    return false;
		}
		$this->modx->mail->reset();
		$this->logs['reports'][] = 'EMAIL SENT TO: ' . $to;
		return true;
	}

	public function store_attachments($value='')
	{
		# code...
	}

	/**
	* Gets all attachments
	* 
	* @author: Axel de Vignon
	* @param $content: the email structure
	* @param $part: not to be set, used for recursivity
	* @return array(type, encoding, part, filename)
	*
	*/
	public function get_attachments($content, $part = null, $skip_parts = false) {
	    static $results;
	 
	    // First round, emptying results
	    if (is_null($part)) {
	        $results = array();
	    }
	    else {
	        // Removing first dot (.)
	        if (substr($part, 0, 1) == '.') {
	            $part = substr($part, 1);
	        }
	    }
	 
	    // Saving the current part
	    $actualpart = $part;
	    // Split on the "."
	    $split = explode('.', $actualpart);
	 
	    // Skipping parts
	    if (is_array($skip_parts)) {
	        foreach ($skip_parts as $p) {
	            // Removing a row off the array
	            array_splice($split, $p, 1);
	        }
	        // Rebuilding part string
	        $actualpart = implode('.', $split);
	    }
	 
	    // Each time we get the RFC822 subtype, we skip
	    // this part.
	    if (strtolower($content->subtype) == 'rfc822') {
	        // Never used before, initializing
	        if (!is_array($skip_parts)) {
	            $skip_parts = array();
	        }
	        // Adding this part into the skip list
	        array_push($skip_parts, count($split));
	    }
	 
	    // Checking ifdparameters
	    if (isset($content->ifdparameters) && $content->ifdparameters == 1 && isset($content->dparameters) && is_array($content->dparameters)) {
	        foreach ($content->dparameters as $object) {
	            if (isset($object->attribute) && preg_match('~filename~i', $object->attribute)) {
	                $results[] = array(
	                'type'          => (isset($content->subtype)) ? $content->subtype : '',
	                'encoding'      => $content->encoding,
	                'part'          => empty($actualpart) ? 1 : $actualpart,
	                'filename'      => $object->value
	                );
	            }
	        }
	    }
	 
	    // Checking ifparameters
	    else if (isset($content->ifparameters) && $content->ifparameters == 1 && isset($content->parameters) && is_array($content->parameters)) {
	        foreach ($content->parameters as $object) {
	            if (isset($object->attribute) && preg_match('~name~i', $object->attribute)) {
	                $results[] = array(
	                'type'          => (isset($content->subtype)) ? $content->subtype : '',
	                'encoding'      => $content->encoding,
	                'part'          => empty($actualpart) ? 1 : $actualpart,
	                'filename'      => $object->value
	                );
	            }
	        }
	    }
	 
	    // Recursivity
	    if (isset($content->parts) && count($content->parts) > 0) {
	        // Other parts into content
	        foreach ($content->parts as $key => $parts) {
	            $this->get_attachments($parts, ($part.'.'.($key + 1)), $skip_parts);
	        }
	    }
	    return $results;
	}
}