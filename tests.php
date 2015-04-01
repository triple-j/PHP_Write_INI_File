<?php

require_once('write_ini_file.php');

$ini_string = <<<EOF

trailing = "i'm not in a section"

[simple]
val_one = "some value"
val_two = 567

[array]
val_arr[] = "arr_elem_one"
val_arr[] = "arr_elem_two"
val_arr[] = "arr_elem_three"

[array_keys]
val_arr_two[6] = "key_6"
val_arr_two[some_key] = "some_key_value"

EOF;

/*
$ini_string = <<<EOF
; This is a sample configuration file
; Comments start with ';', as in php.ini

[first_section]
one = 1
five = 5
animal = BIRD

[second_section]
path = "/usr/local/bin"
URL = "http://www.example.com/~username"

[third_section]
phpversion[] = "5.0"
phpversion[] = "5.1"
phpversion[] = "5.2"
phpversion[] = "5.3"
EOF;
*/

$ini_data = parse_ini_string($ini_string, true);

/*
echo "<pre>".PHP_EOL;
echo "INPUT".PHP_EOL;
var_dump($ini_string);
echo "DATA".PHP_EOL;
var_dump($ini_data);
echo "IsEmpty?".PHP_EOL;
var_dump(empty($ini_data));
*/

$built_ini_string = build_ini_string($ini_data);

/*
echo "OUTPUT".PHP_EOL;
var_dump($built_ini_string);

echo "wirte file".PHP_EOL;
var_dump(write_ini_file("test.ini",$ini_data));
*/
?>
<table cellpadding="4" cellspacing="2" border="1">
	<thead>
		<tr>
			<th>Input</th>
			<th>Output</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td valign="top"><pre><?php var_dump($ini_string); ?></pre></td>
			<td valign="top"><pre><?php var_dump($built_ini_string); ?></pre></td>
		</tr>
	</tbody>
</table>
