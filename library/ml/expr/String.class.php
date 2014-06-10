<?php

namespace library\ml\expr;

/**
 * Expression pour les chaines de caractères
 * @author hakurou
 * @version 1.0.0
 */
class String extends Exp
{
    protected $value;
    
	/**
	 * Constructeur
	 * @param String $value					Valeur de l'expression
	 */
    public function __construct($value)
    {
    	parent::__construct(\library\ml\analysis\Lexer::TT_STRING);
        $this->value = $value;
    }
    
    // public function getValue()
    // {
        // return $this->value;
    // }
    
    /**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
    	$register->pushString($this->value);
		
        return \library\ml\symbols\Register::T_STRING;
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		
	}
}

?>