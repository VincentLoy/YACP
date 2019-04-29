<?php
/**
 * @package Yet_Another_Countdown_Plugin
 * @version 0.1.1
 */

/*
Plugin Name: Yet Another Countdown Plugin
Plugin URI: https://vincentloy.github.io/YACP/
Description: YACP allow you to add a countdown to any Wordpress post and page. It's easy to use, open source, and developer friendly
Author: Vincent Loy
Version: 0.1.1
Author URI: https://vincent-loy.fr/
License: GPLv3

YACP is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
YACP is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with YACP. If not, see https://www.gnu.org/licenses/gpl-3.0.en.html
*/

use YACP\YACP;

include "libs/YACP.php";

new YACP();
