<?php

namespace library\ml\expr;

/**
 * Expression d'appel de fonction
 * @author hakurou
 * @version 1.0.0
 */
class FunCall extends Exp
{
    protected $funcName;
	protected $args;
    
	/**
	 * Constructeur
	 * @param Exp $funcName						Fonction a appeler
	 */
    public function __construct($funcName, $args = array())
    {
    	parent::__construct(\library\ml\analysis\Lexer::TT_FUNC_CALL);
        $this->funcName = $funcName;
        $this->args = $args;
    }
    
	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
    	if($this->funcName->getType() != \library\ml\analysis\Lexer::TT_LAM)
		{
	    	$argType = $this->funcName->interpret($symbolsTable, $register);
			if($argType == \library\ml\symbols\Register::T_EXPR)
				$sym = $register->popExpr();
			else
				trigger_error('FunCall::interpret: Error, unexpected expression', E_USER_ERROR);
		}
		else
			$sym = $this->funcName;
		
		return $sym->interpret($symbolsTable, $register, $this->args);
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		
	}
}

?>