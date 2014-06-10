<?php

namespace library\ml\expr;

/**
 * Expression saut de ligne, si si il y cette expression en Scheme :p
 * @author hakurou
 * @version 1.0.0
 */
class NewLine extends Exp
{
	/**
	 * Constructeur
	 */
    public function __construct()
    {
		parent::__construct(\library\ml\analysis\Lexer::TT_PRI);
    }

	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
        echo '<br />';
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		$parser->nextToken();
		
		if($parser->getCurrentToken()->getType() != \library\ml\analysis\Lexer::TT_RIGHT_PARENTHESIS)
            trigger_error('parseNewLine: Unexpected token', E_USER_ERROR);
		
		return new NewLine();
	}
}

?>