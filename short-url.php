<?php
/*
Plugin Name: Short URL for Posts
Plugin URI: http://www.praateek.com
Description: This will convert all links in <a href tag. This converts your long urls too shorter ones.
Version: 1.0
Author: Praateek Mahajan
Author URI: http://www.praateek.com and http://iuv.be
*/
/*  Copyright 2010  Praateek Mahajan  (email : otpraateek@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Add Filter from WP API
add_filter('the_content', 'iuvbe', '1');

function iuvbe($content)
{
    //Parse all PHP Highlight request from user
    preg_match_all("/<a href=\"(.*?)\">/", $content, $lurl);
    //Clean Commands

    //Watch out each code one by one

    $lurl = array_map( 'esc_url', (array) $lurl[1] );
    foreach ($lurl as $code) {
        $newcode = trim( wp_remote_retrieve_body( wp_remote_get( "http://iuv.be/api/new?url=$code" ) ) );

        if ( $newcode != "Invalid Protocol" )
                $content = str_replace($code, $newcode, $content);
    }

    //return the content most easy one
    return $content;
}
?>