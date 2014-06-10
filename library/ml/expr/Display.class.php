<?php

namespace library\ml\expr;

/**
 * Expression saut de ligne, si si il y cette expression en Scheme :p
 * @author hakurou
 * @version 1.0.0
 */
class Display extends Exp
{
    protected $printContent;
    
	/**
	 * constructeur
	 * @param Exp $value				Expression à afficher
	 */
    public function __construct($value = null)
    {
    	parent::__construct(\library\ml\analysis\Lexer::TT_PRI);
        $this->printContent = $value;
    }
    
	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
    	$argType = $this->printContent->interpret($symbolsTable, $register);
		
		while($argType != null && $argType == \library\ml\symbols\Register::T_EXPR)
		{
			$exp = $register->popExpr();
			$argType = $exp->interpret($symbolsTable, $register);
		}
		
		if($argType == \library\ml\symbols\Register::T_STRING)
        	echo $register->popString();
		if($argType == \library\ml\symbols\Register::T_NUMBER)
        	echo $register->popNumber();
		
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		$expr = $parser->parseExpr();

        $d = new \library\ml\expr\Display($expr);
        $parser->nextToken();

        if($parser->getCurrentToken()->getType() != \library\ml\analysis\Lexer::TT_RIGHT_PARENTHESIS)
            trigger_error('Display::parse: Unexpected token', E_USER_ERROR);
        
        return $d;
	}
}

?>