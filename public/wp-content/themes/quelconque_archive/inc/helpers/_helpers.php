<?php

require_once dirname(__FILE__).'/common.php';

dh_require_multiple(dirname(__FILE__), [
	'images.php',
	'templates.php',
	'date-time.php',
	['barba-js.php', HAS_BARBA],
	['wpml.php', HAS_WPML],
]);