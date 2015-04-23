<?php
/**
 *  PHP_Write_INI_File is a set of functions to make it easy to write INI
 *  files that are parsable by PHP's built-in `parse_ini_file()` function.
 *
 *  Copyright (C) 2015 Jeremie Jarosh
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with this library; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 *  USA
 */

function build_ini_string( $ini_data ) {
	$ini_string  = "";
	$add_newline = false;

	if ( !is_array($ini_data) || empty($ini_data) ) { return false; }

	// sort array making sure values not in sections are at the top
	foreach ( $ini_data as $key=>$val ) {
		if ( is_array($val) ) {
			unset($ini_data[$key]);
			$ini_data[$key] = $val;
		}
	}

	// build ini string
	foreach ( $ini_data as $key=>$val ) {
		if ( is_array($val) ) {
			// section
			if ( $add_newline ) {
				$ini_string .= PHP_EOL;
				$add_newline = false;
			}

			$ini_string .= "[$key]" . PHP_EOL;

			foreach ($val as $sub_key => $sub_val) {
				if (is_array($sub_val)) {
					// array
					if ( array_keys($sub_val) === range(0, count($sub_val) - 1) ) {
						// sequential array
						foreach ( $sub_val as $seq_val ) {
							$ini_string .= "{$sub_key}[] = " . (is_numeric($seq_val) ? $seq_val : "\"$seq_val\"") . PHP_EOL;
						}
					} else {
						// associative array
						foreach ( $sub_val as $assoc_key=>$assoc_val ) {
							$ini_string .= "{$sub_key}[{$assoc_key}] = " . (is_numeric($assoc_val) ? $assoc_val : "\"$assoc_val\"") . PHP_EOL;
						}
					}
				} elseif (empty($sub_val)) {
					// empty
					$ini_string .= "$sub_key = " . PHP_EOL;
				} else {
					// string or number
					$ini_string .= "$sub_key = " . (is_numeric($sub_val) ? $sub_val : "\"$sub_val\"") . PHP_EOL;
				}
			}
		} else {
			// not in a section
			$ini_string .= "$key = " . (is_numeric($val) ? $val : "\"$val\"") . PHP_EOL;
		}
		$add_newline = true;
	}

	return $ini_string;
}

function write_ini_file( $filename, $ini_data, $flags=0 ) {
	$ini_string = build_ini_string($ini_data);
	return $ini_string ? file_put_contents( $filename, $ini_string, $flags ) : false;
}
