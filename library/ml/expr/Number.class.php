<?php

namespace library\ml\expr;

/**
 * Expression de nombre
 * @author hakurou
 * @version 1.0.0
 */
class Number extends Exp
{
    protected $value;
    
	/**
	 * Constructeur
	 * @param Float $value				Valeur du nombre
	 */
    public function __construct($value)
    {
    	parent::__construct(\library\ml\analysis\Lexer::TT_NUMBER);
        $this->value = $value;
    }
    
	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
    	$register->pushNumber(floatval($this->value));
		
        return \library\ml\symbols\Register::T_NUMBER;
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		
	}
}

?>