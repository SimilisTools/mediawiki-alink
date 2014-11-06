<?php

class Alink {

	private $attrs_ref = array( "href", "rel", "target", "class", "id", "content", "name" ); 
	private $attrs_like = array( "data-" );
	private $protocols = array( "https://", "http://", "ftp://" );
	
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
					if ( strpos( $arg_proc[0], $attr_like ) ) {
						$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
					}
				}
			}
		}
		
		if ( isset( $attrs["href"] ) ) {
			foreach ( self::$protocols as $protocol ) {
				if ( strpos( $attrs["href"], $protocol ) != 0 ) {
					// TODO create URL
				}
			}
		}
		
		if ( $text == "" && isset( $attrs["href"] ) ) {
			$text = $attrs["href"];
		}

		$tag = 	Html::element(
			'a',
				$attrs
		);
		
		return $tag;
	}
	
	

}