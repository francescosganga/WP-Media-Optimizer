<?php

/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via
 * web, è anche possibile copiare questo file in «wp-config.php» e
 * riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni MySQL
 * * Prefisso Tabella
 * * Chiavi Segrete
 * * ABSPATH
 *
 * È possibile trovare ultetriori informazioni visitando la pagina del Codex:
 *
 * @link https://codex.wordpress.org/it:Modificare_wp-config.php
 *
 * È possibile ottenere le impostazioni per MySQL dal proprio fornitore di hosting.
 *
 * @package WordPress
 */

define('WP_MEMORY_LIMIT', '128M');
// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'dbs98445' );

/** Nome utente del database MySQL */
define( 'DB_USER', 'dbu126920' );

/** Password del database MySQL */
define( 'DB_PASSWORD', 'Lolfight82!' );

/** Hostname MySQL  */
define( 'DB_HOST', 'db5000103925.hosting-data.io' );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'S5j)4;66_1%YBquet#bI}0/0:>9kGq;eGSa+AwMSt4QB15F?T%,-,*JSJ7,ds*PT' );
define( 'SECURE_AUTH_KEY',  'A=e-{kmx<])5XT;Wx`i8[I;CGXzRa7BE<ic[WF%V1JwIgR2jsCuE<5bTZe]Qu!Ys' );
define( 'LOGGED_IN_KEY',    'jO<iCE:S0B}e:C=Th>fdb|87P5vASSR{rzAOY((@Nj!MTk,,Cra>A#^o8=d(-?Xr' );
define( 'NONCE_KEY',        ':uKsy^gTsR2Sd]W;}U7toEnK[dkUFD]Se$EtkXtA5=SaQ%>$3S m7pmT-x3rEF]s' );
define( 'AUTH_SALT',        ')rpkK~l3fvtL+Ko+R1FLJ&M{J~[o6#VfJdKW?@B?3)OgUgZ+JA=Aj!?FWM5SBQ&Q' );
define( 'SECURE_AUTH_SALT', 'Y]$t_SR?E#JWjewF+e]0C1x{O:ExXWdEG:S,gN@VV2[3T3j4VcVIM<rP=li=[m?}' );
define( 'LOGGED_IN_SALT',   'Wh7s<Ca[KA5&=b8yPI%Ly/UXfStN&<*59_FHC)2ov}Qla.7ctAg`(tstJ%_h@iY{' );
define( 'NONCE_SALT',       't|BPm?HIsAR0aDJ:]&5a;Q.@],8|;Y9XiVgJ_`M|T`n/VdoaB<`Q_%-TXJ<<ciy}' );

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix = 's2k3_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi
 * durante lo sviluppo.
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 */
 // Abilitare la modalità WP_DEBUG
define('WP_DEBUG', true);

// Abilitare il salvataggio del log nel file /wp-content/debug.log
define('WP_DEBUG_LOG', true);

// Disabilitare la stampa di errori e avvisi
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors',0);

/* Finito, interrompere le modifiche! Buon creazione di contenuti. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta le variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');