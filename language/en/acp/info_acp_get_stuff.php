<?php
/**
*
* @package Get Stuff
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$revision = 'v3.1.0';
$name = 'Get Stuff ' . $revision;

$lang = array_merge($lang, array(
	'ACP_GET_STUFF'	=> 'Get Stuff',
	
	'ACP_GET_STUFF_EXPLAIN'	=> 'Get Stuff shows a summary of users who have signed in the last two days. Users with duplicate IP addresses are always in focus. In the dropdownbox, choose one of the existing polls on your forum and Get Stuff shows four tables sorted in different ways.<br />The tables are sorted by IP address, name, option and result, so you can easily recognize dual votes.<br />As a bonus, you can also view your received or sent private messages. More details are just not there, all at a glance.',
	
	'POLL_TEXT'		=> 'Make your choice',
	'GS_USERS'		=> 'Total users',
	'GS_NWUSERS'	=> 'New users last 2 days',
	'GS_SIPUSERS'	=> 'Users with samen IP',
	
	'GS_IPSORT' 	=> 'IP sorted',
	'GS_OPTIONSORT' => 'Choice sorted',
	'GS_NAMESORT' 	=> 'Name sorted',
	'GS_RESULT' 	=> 'Result',
	'GS_GRAPH'		=> 'Graph',
	'GS_TOTALMSG' 	=> 'Total messages',
	'GS_WRITEBY' 	=> 'PM\'s written by',
	'GS_WRITETO'	=> 'PM\'s written to',
	
	'GS_CHOSEN'		=> 'Option',
	'GS_NAME'		=> 'Name',
	'GS_IP'			=> 'IP address',
	'GS_TOTAL'		=> 'Total',
	'GS_TOTALMSG'	=> 'Total messages',
	'GS_TOTALTOPS'	=> 'Total topics',
	'GS_TOTALPB'	=> 'Total PB\'s',
	'GS_RECIPIENTS'	=> 'Recipient'
));

?>
