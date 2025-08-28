<?php

class AlinkHooks
{
    /**
     * Register parser functions.
     * @param Parser $parser
     * @return bool
     */
    public static function onParserFirstCallInit(Parser $parser)
    {
        $parser->setFunctionHook('alink', [ 'Alink', 'process_alink' ], SFH_OBJECT_ARGS);
        $parser->setFunctionHook('aimg', [ 'Alink', 'process_aimg' ], SFH_OBJECT_ARGS);
        return true;
    }
}
