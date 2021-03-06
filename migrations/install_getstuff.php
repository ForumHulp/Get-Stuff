<?php
/**
*
* @package Get Stuff
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\getstuff\migrations;

class install_getstuff extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['get_stuff_version']) && version_compare($this->config['get_stuff_version'], '3.1.0.RC4', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_FORUM_LOGS',
				array(
					'module_basename'	=> '\forumhulp\getstuff\acp\get_stuff_module',
					'module_langname'	=> 'ACP_GET_STUFF',
					'module_mode'		=> 'index'
				)
			)),

			array('config.add', array('get_stuff_version', '3.1.0.RC4')),
		);
	}
}
