<?php
/**
*
* @package Get Stuff
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\get_stuff\acp;

class get_stuff_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $cache;
		global $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$text_aray = $sql_aray = $column_aray = array();
	//	$user->add_lang('acp/info_acp_get_stuff');
		
		// Aantal Users
		$column = $user->lang['GS_USERS'] . '|' . $user->lang['GS_NWUSERS'] . '|' . $user->lang['GS_SIPUSERS'];
		$sql = 'SELECT (SELECT COUNT(user_id) FROM ' . USERS_TABLE . ') AS totalusers, 
			    (SELECT GROUP_CONCAT(concat_ws(", ", FROM_UNIXTIME(user_regdate), username, user_ip), "<br />")  
				FROM ' . USERS_TABLE . ' WHERE FROM_UNIXTIME(user_regdate) >= DATE_ADD(CURDATE(), INTERVAL -2 DAY) ORDER BY user_regdate desc) AS newuser, 
			    (SELECT GROUP_CONCAT(concat_ws(", ", username, a.user_ip, FROM_UNIXTIME(a.user_regdate), b.aantal), "<br />") 
				FROM ' . USERS_TABLE . ' a, (SELECT user_ip, COUNT(*) AS aantal FROM ' . USERS_TABLE . ' 
				GROUP BY user_ip HAVING COUNT(*) > 1) b WHERE a.user_ip = b.user_ip AND LENGTH(a.user_ip) > 0 
				ORDER BY a.user_ip) AS usersameip';

		$template->assign_block_vars('user', array(
			'FIELDS'	=> sizeof(explode('|', $column)),
			'FIELD'		=> implode('</th><th>', explode('|', $column)),
			'TEXT'		=> $user->lang['USERS']
			)
		);
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$template->assign_block_vars('user.users', array(
			'FIELDS'	=> $row['totalusers'] . '</td><td  valign="top">' . str_replace('<br />,' , '<br />', 
						   $row['newuser']) . '</td><td  valign="top">' . str_replace('<br />,' , '<br />', $row['usersameip'])
			)
		);		

		$poll_txt = array();
		$poll_id = request_var('poll', '');
		$sql = 'SELECT topic_id, poll_title FROM ' . TOPICS_TABLE . ' WHERE  poll_title <> "" ORDER BY topic_time DESC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('polls', array(
				'ID'		=> $row['topic_id'],
				'TEXT'		=> 'Poll: ' . $row['poll_title'],
				'SELECTED'	=> ($row['topic_id'] == $poll_id) ? ' selected="selected"' : ''
				)
			);
			$poll_txt[$row['topic_id']] = $row['poll_title'];
		}
		$template->assign_block_vars('polls', array(
			'ID'		=> '1A',
			'TEXT'		=> $user->lang['GS_WRITEBY'] . ' ' . $user->data['username'],
			'SELECTED'	=> ('1A' == $poll_id) ? ' selected="selected"' : '')
		);
		$template->assign_block_vars('polls', array(
			'ID'		=> '1B',
			'TEXT'		=> $user->lang['GS_WRITETO'] . ' ' . $user->data['username'],
			'SELECTED'	=> ('1B' == $poll_id) ? ' selected="selected"' : '')
		);
	
		if ($poll_id)
		{
			$text_aray = array(0 => $user->lang['GS_IPSORT'], 
							   1 => $user->lang['GS_OPTIONSORT'], 
							   2 => $user->lang['GS_GRAPH'],
							   3 => $user->lang['GS_NAMESORT'], 
							   4 => $user->lang['GS_RESULT'], 
							   5 => $user->lang['GS_TOTALMSG'], 
							   6 => $user->lang['GS_WRITEBY'] . ' ' . $user->data['username'], 
							   7 => $user->lang['GS_WRITETO'] . ' ' . $user->data['username']);
			
			$column_aray = $sql_aray = array();
			$column_aray[] = $user->lang['GS_CHOSEN'] . '|' . $user->lang['GS_NAME'] . '|' . $user->lang['GS_IP'];
			$column_aray[] = $user->lang['GS_CHOSEN'] . '|' . $user->lang['GS_NAME'] . '|' . $user->lang['GS_IP'];
			$column_aray[] = '';
			$column_aray[] = $user->lang['GS_CHOSEN'] . '|' . $user->lang['GS_NAME'] . '|' . $user->lang['GS_IP'];
			$column_aray[] = $user->lang['GS_CHOSEN'] . '|' . $user->lang['GS_TOTAL'];
			$column_aray[] = $user->lang['GS_NAME'] .   '|' . $user->lang['GS_TOTALMSG'] . '|' . $user->lang['GS_TOTALTOPS'] . '|' . $user->lang['GS_TOTALPB'];
			$column_aray[] = $user->lang['SORT_DATE'] . '|' . $user->lang['SUBJECT'] . '|' . $user->lang['MESSAGE'] . '|' . $user->lang['GS_WRITETO'];
			$column_aray[] = $user->lang['SORT_DATE'] . '|' . $user->lang['GS_NAME'] . '|' . $user->lang['GS_IP'] . '|'. $user->lang['SUBJECT'] . '|' . $user->lang['MESSAGE'];			
			
			$sql_aray[] = 'SELECT CONCAT_WS(CHAR(124), p.poll_option_text, u.username, v.vote_user_ip) AS resultaat 
						   FROM ' . POLL_VOTES_TABLE . ' v
						   LEFT JOIN ' . POLL_OPTIONS_TABLE . ' p ON v.poll_option_id = p.poll_option_id AND v.topic_id = p.topic_id 
						   LEFT JOIN ' . USERS_TABLE . ' u ON  v.vote_user_id = u.user_id
						   WHERE v.topic_id = ' . $poll_id . ' ORDER BY v.vote_user_ip';

			$sql_aray[] = 'SELECT CONCAT_WS(CHAR(124), p.poll_option_text, u.username, v.vote_user_ip) AS resultaat 
						   FROM ' . POLL_VOTES_TABLE . ' v 
						   LEFT JOIN ' . POLL_OPTIONS_TABLE . ' p ON v.poll_option_id = p.poll_option_id AND v.topic_id = p.topic_id 
						   LEFT JOIN ' . USERS_TABLE . ' u ON  v.vote_user_id = u.user_id
						   WHERE v.topic_id = ' . $poll_id . ' ORDER BY v.poll_option_id';		

			$sql_aray[] = 'SELECT * FROM ' . POLL_OPTIONS_TABLE . ' 
						   WHERE topic_id = ' . $poll_id . ' ORDER BY poll_option_id';					

			$sql_aray[] = 'SELECT CONCAT_WS(CHAR(124), p.poll_option_text, u.username, v.vote_user_ip) AS resultaat 
						   FROM ' . POLL_VOTES_TABLE . ' v
						   LEFT JOIN ' . POLL_OPTIONS_TABLE . ' p ON v.poll_option_id = p.poll_option_id AND v.topic_id = p.topic_id 
						   LEFT JOIN ' . USERS_TABLE . ' u ON  v.vote_user_id = u.user_id
						   WHERE v.topic_id = ' . $poll_id . ' ORDER BY u.username';
					
			$sql_aray[] = 'SELECT CONCAT_WS(CHAR(124), p.poll_option_text, count(v.poll_option_id)) AS resultaat  
						   FROM ' . POLL_VOTES_TABLE . ' v
						   LEFT JOIN ' . POLL_OPTIONS_TABLE . ' p ON v.poll_option_id = p.poll_option_id AND v.topic_id = p.topic_id 
						   LEFT JOIN ' . USERS_TABLE . ' u ON  v.vote_user_id = u.user_id
						   WHERE v.topic_id = ' . $poll_id . ' 
						   GROUP BY v.poll_option_id ORDER BY COUNT(v.poll_option_id) DESC';

			$sql_aray[] = 'SELECT CONCAT_WS(CHAR(124),(
						   SELECT CONCAT_WS(CHAR(124), username, user_posts) FROM ' . USERS_TABLE . ' 
						   WHERE user_id = pv.vote_user_id), (
						   SELECT COUNT(*) FROM ' . POSTS_TABLE . ' 
						   WHERE poster_id = pv.vote_user_id), (
						   SELECT COUNT(*) FROM ' . PRIVMSGS_TABLE . ' 
						   WHERE author_id = pv.vote_user_id)) AS resultaat 
						   FROM ' . POLL_VOTES_TABLE . ' pv 
						   WHERE pv.topic_id = ' . $poll_id . ' ORDER BY (SELECT COUNT(*) FROM ' . POSTS_TABLE . ' 
						   WHERE poster_id = pv.vote_user_id) ASC';		

			$sql_aray[] = 'SELECT CONCAT_WS(CHAR(124), FROM_UNIXTIME(message_time), message_subject, message_text,(
						   SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = SUBSTRING(p.to_address, 3, 10))) AS resultaat, p.bbcode_bitfield, p.bbcode_uid 
						   FROM ' . PRIVMSGS_TABLE . ' p 
						   WHERE author_id = ' . $user->data['user_id'] . ' ORDER BY message_time DESC';

			$sql_aray[] = 'SELECT CONCAT_WS(CHAR(124), FROM_UNIXTIME(message_time), uz.username, author_ip, message_subject, message_text) AS resultaat, p.bbcode_bitfield, p.bbcode_uid
						   FROM ' . PRIVMSGS_TABLE . ' p 
						   LEFT JOIN ' . USERS_TABLE . ' uz on uz.user_id = p.author_id 
						   LEFT JOIN ' . USERS_TABLE . ' ut on ut.user_id = SUBSTRING(p.to_address, 3, 10)
						   WHERE SUBSTRING(p.to_address, 3, 10) = ' . $user->data['user_id']. ' ORDER BY message_time DESC';	  					
						
			foreach ($text_aray as $key => $value)
			{
				if ($poll_id == '1A' || $poll_id == '1B' && $key > 5)
				{
					$key = ($poll_id == '1A') ? 6 : 7;
					$template->assign_block_vars('record', array(
						'FIELDS'	=> sizeof(explode('|', $column_aray[$key])),
						'FIELD'		=> implode('</th><th>', explode('|', $column_aray[$key])),
						'TEXT'		=> $text_aray[$key]
						)
					);
				
					if (!function_exists('generate_text_for_display'))
					{
						include($phpbb_root_path . 'includes/functions_content.' . $phpEx);
					}
					$sql = $sql_aray[$key];
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$row['resultaat'] = generate_text_for_display($row['resultaat'], $row['bbcode_uid'], $row['bbcode_bitfield'], 1111);
						$template->assign_block_vars('record.records', array(
							'FIELDS'	=> implode('</td><td valign="top">', explode('|', strip_tags($row['resultaat'])))
							)
						);
					}
					break;
				} elseif ($poll_id > 1 && $key < 6)
				{
						$template->assign_block_vars('record', array(
							'FIELDS'	=> sizeof(explode('|', $column_aray[$key])),
							'FIELD'		=> implode('</th><th>', explode('|', $column_aray[$key])),
							'TEXT'		=> $text_aray[$key]
							)
						);
					if ($key != 2)
					{
						$sql = $sql_aray[$key];
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							$template->assign_block_vars('record.records', array(
								'FIELDS'		=> implode('</td><td>', explode('|', $row['resultaat']))
								)
							);
						}
					} else
					{
						$sql = $sql_aray[$key];
						$result = $db->sql_query($sql);
					
						$poll_info = $vote_counts = $poldata = array();
						while ($row = $db->sql_fetchrow($result))
						{
							$poll_info[] = $row;
							$option_id = (int) $row['poll_option_id'];
							$vote_counts[$option_id] = (int) $row['poll_option_total'];
						}
							
						$poll_total = 0;
						foreach ($poll_info as $poll_option)
						{
							$poll_total += $poll_option['poll_option_total'];
						}
						
						foreach ($poll_info as $poll_option)
						{
							$option_pct = ($poll_total > 0) ? $poll_option['poll_option_total'] / $poll_total : 0;
							$poldata[] = '[\''.$poll_option['poll_option_text'].'\', ' . round($option_pct, 3) . ']';
						}

						$template->assign_block_vars('record.records', array(
							'POLDATA'	=> implode(', ', $poldata),
							)
						);
					}
				}	
			}
		}
		
		$this->tpl_name = 'acp_get_stuff';
		$this->page_title = 'ACP_GET_STUFF';
	}
}

?>
