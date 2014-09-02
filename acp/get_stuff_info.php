<?php
/**
*
* @package Get Stuff
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @package module_install
*/

namespace forumhulp\getstuff\acp;

class get_stuff_info
{
	function module()
	{
		return array(
			'filename'	=> '\forumhulp\getstuff\acp\get_stuff_module',
			'title'		=> 'ACP_GET_STUFF',
			'version'	=> '3.1.0',
            'modes'     => array('index' => array('title' => 'ACP_GET_STUFF', 'auth' => 'acl_a_board', 'cat' => array('ACP_FORUM_LOGS')),
			),
		);
	}
}
