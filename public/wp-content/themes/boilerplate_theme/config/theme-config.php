<?php

// Timezone FR par défaut
date_default_timezone_set('Europe/Paris');

/**
 *	Définition des constantes de configuration
 *
 */
$config = [
	'MODE_DEV' => true,
	'HAS_BARBA' => true,
	'HAS_WPML' => true,
	'TEXTDOMAIN' => '',
];

/**----------------------------------------------------**/
/**----------- Ne pas modifier ci-dessous -------------**/
/**----------------------------------------------------**/

foreach($config as $key => $val)
	defined( $key ) or define($key, $val);