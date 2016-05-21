<?php


if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

//self executing anonymous function to prevent global scope assumptions
call_user_func( function() {

	$GLOBALS['wgExtensionCredits']['parserhook'][] = array(
		'path' => __FILE__,
		'name' => 'Alink',
		'version' => '0.1.2',
		'url' => 'https://github.com/SimilisTools/mediawiki-alink',
		'author' => array( 'Toniher' ),
		'descriptionmsg' => 'alink-desc',
	);

	$GLOBALS['wgAutoloadClasses']['Alink'] = __DIR__.'/Alink_body.php';
	$GLOBALS['wgMessagesDirs']['Alink'] = __DIR__ . '/i18n';
	$GLOBALS['wgExtensionMessagesFiles']['Alink'] = __DIR__ . '/Alink.i18n.php';
	$GLOBALS['wgExtensionMessagesFiles']['AlinkMagic'] = __DIR__ . '/Alink.i18n.magic.php';

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = 'wfRegisterAlink';

} );

/**
 * @param $parser Parser
 * @return bool
 */
function wfRegisterAlink( $parser ) {
	$parser->setFunctionHook( 'alink', 'Alink::process_alink', SFH_OBJECT_ARGS );
	$parser->setFunctionHook( 'aimg', 'Alink::process_aimg', SFH_OBJECT_ARGS );
	return true;
}
