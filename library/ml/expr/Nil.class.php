<?php

namespace library\ml\expr;

/**
 * Expression NULL / NIL
 * @author hakurou
 * @version 1.0.0
 */
class Nil extends Exp
{
	/**
	 * Constructeur
	 */
    public function __construct()
    {
    }
    
	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
        return null;;
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		
	}
}

?>