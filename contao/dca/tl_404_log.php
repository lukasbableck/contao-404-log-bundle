<?php

use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_404_log'] = [
	'config' => [
		'dataContainer' => DC_Table::class,
		'sql' => [
			'keys' => [
				'id' => 'primary',
				'ip' => 'index',
				'tstamp' => 'index',
				'url' => 'index',
			],
		],
	],
	'list' => [
		'sorting' => [
			'mode' => 2,
			'fields' => ['tstamp'],
			'flag' => 1,
			'panelLayout' => 'filter;search,limit',
		],
		'label' => [
			'fields' => ['tstamp', 'url'],
		],
		'global_operations' => [
			'all',
			'delete'
		],
		'operations' => [
			'delete',
			'show'
		],
	],
	'fields' => [
		'id' => [
			'sql' => "int(10) unsigned NOT NULL auto_increment",
		],
		'tstamp' => [
			'sql' => "int(10) unsigned NOT NULL default '0'",
		],
		'rootPage' => [
			'search' => true,
			'sql' => "int(10) unsigned NOT NULL default '0'",
		],
		'ip' => [
			'search' => true,
			'sql' => "varchar(64) NOT NULL default ''",
		],
		'url' => [
			'search' => true,
			'sql' => "text NULL",
		],
		'referrer' => [
			'search' => true,
			'sql' => "text NULL",
		],
		'agent' => [
			'search' => true,
			'sql' => "text NULL",
		],
	],
];