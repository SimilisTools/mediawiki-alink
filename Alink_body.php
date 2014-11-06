<?php

class Alink {

	private static $attrs_ref = array( "href", "rel", "target", "class", "id", "content", "name", "itemprop" ); 
	private static $attrs_like = array( "data-" );
	private static $protocols = array( "https://", "http://", "ftp://" );
	
	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	public static function process_alink( &$parser, $frame, $args ) {

		$attrs = array();
		$text = "";
		
		foreach ( $args as $arg ) {
			$arg_clean = trim( $frame->expand( $arg ) );
			$arg_proc = explode( "=", $arg_clean, 2 );
			
			if ( count( $arg_proc ) == 1 ){
				$text = trim( $arg_proc[0] );
			} else {
			
				if ( in_array( trim( $arg_proc[0] ), self::$attrs_ref ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				
				foreach ( self::$attrs_like as $attr_like ) {
					if ( strpos( $arg_proc[0], $attr_like ) == 0 ) {
						$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
					}
				}
			}
		}
		
		// Code for dealing with internal - external
		$external = 0;  
		if ( isset( $attrs["href"] ) ) {
			foreach ( self::$protocols as $protocol ) {
				$detect = strpos( $attrs["href"], $protocol );
				if ( is_int( $detect ) ) {
						$external = 1;
				}
			}
		}

		if ( $external == 0 ) {
			if ( isset( $attrs["href"] ) ) {
				global $wgArticlePath;
				$page = $attrs["href"];
				$page = str_replace( " ", "_", $page );
				$attrs["href"] = $wgArticlePath;
				$attrs["href"] = str_replace( "$1", urlencode( $page ), $attrs["href"] );
			}
		}
		
		// If no text, use href
		
		if ( $text == "" && isset( $attrs["href"] ) ) {
			$text = $attrs["href"];
		}

		$tag = 	Html::element(
			'a',
				$attrs,
			$text
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}
	
	

}
