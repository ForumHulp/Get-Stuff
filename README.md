Get-Stuff
=========

Get Stuff shows a summary of users who have signed in the last two days. Users with duplicate IP addresses are always in focus. 
[![Build Status](https://travis-ci.org/ForumHulp/Get-Stuff.svg?branch=master)](https://travis-ci.org/ForumHulp/Get-Stuff)

In the dropdownbox, choose one of the existing polls on your forum and Get Stuff shows four tables sorted in different ways.
The tables are sorted by IP address, name, option and result, so you can easily recognize dual votes.

As a bonus, you can also view your received or sent private messages. More details are just not there, all at a glance.

## Requirements
* phpBB 3.1-dev or higher
* PHP 5.3 or higher

## Installation
You can install this on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:

1. Copy the entire contents of this repo to to `FORUM_DIRECTORY/ext/forumhulp/getstuff/`
2. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
3. Click Get Stuff => `Enable`.

Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0.

## Uninstallation
Navigate in the ACP to `Customise -> Extension Management -> Extensions` and click Get Stuff => `Disable`.

To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/getstuff/` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2014 - John Peskens (ForumHulp.com)