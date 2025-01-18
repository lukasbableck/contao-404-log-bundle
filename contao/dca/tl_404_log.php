<?php

use Contao\DataContainer;
use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_404_log'] = [
	'config' => [
		'dataContainer' => DC_Table::class,
		'notEditable' => true,
		'notCopyable' => true,
		'closed' => true,
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
			'mode' => DataContainer::MODE_SORTED,
			'fields' => ['tstamp'],
			'flag' => DataContainer::SORT_ASC,
			'panelLayout' => 'filter;search,limit',
		],
		'label' => [
			'fields' => ['tstamp', 'url'],
			'showColumns' => true,
		],
		'global_operations' => [
			'all',
		],
		'operations' => [
			'delete',
			'show',
		],
	],
	'fields' => [
		'id' => [
			'sql' => 'int(10) unsigned NOT NULL auto_increment',
		],
		'tstamp' => [
			'flag' => DataContainer::SORT_DAY_DESC,
			'eval' => ['rgxp' => 'datim'],
			'sql' => "int(10) unsigned NOT NULL default '0'",
		],
		'rootPage' => [
			'search' => true,
			'foreignKey' => 'tl_page.title',
			'sql' => "int(10) unsigned NOT NULL default '0'",
		],
		'ip' => [
			'search' => true,
			'sql' => "varchar(64) NOT NULL default ''",
		],
		'url' => [
			'search' => true,
			'sql' => 'text NULL',
		],
		'referrer' => [
			'search' => true,
			'sql' => 'text NULL',
		],
		'agent' => [
			'search' => true,
			'sql' => 'text NULL',
		],
	],
];
