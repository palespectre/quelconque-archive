<?php

/**
 *	Chargement des fichiers fils sous la nomenclature
 *	hooks-slug.php
 */

dh_require_multiple(dirname(__FILE__), [
	'hooks-reset.php',
	'hooks-setup.php',
	'hooks-roles.php',
	'hooks-wp_enqueue_scripts.php',
	'hooks-advanced-structure.php',
	['hooks-mode-dev.php', MODE_DEV],
	['hooks-barba-js.php', HAS_BARBA],
	['hooks-wpml.php', HAS_WPML],
]);