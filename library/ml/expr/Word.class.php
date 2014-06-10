<?php

namespace library\ml\expr;

/**
 * Expression représentant un mot (fonction, variable)
 * @author hakurou
 * @version 1.0.0
 */
class Word extends Exp
{
	protected $value;
	
	/**
	 * Constructeur
	 * @param String $value						Nom du mot
	 */
    public function __construct($value)
	{
		parent::__construct(\library\ml\analysis\Lexer::TT_WORD);
		$this->value = $value;
	}

	/**
	 * @see Exp::interpret
	 */
	public function interpret($symbolsTable, $register, $expList = array())
	{
		$exp = $symbolsTable->get($this->value);
		
		if($exp == null)
			trigger_error('Word::interpret: Undefined index "'.$this->value.'"', E_USER_ERROR);
		
		$register->pushExpr($exp);
		
		return \library\ml\symbols\Register::T_EXPR;
	}
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		
	}
}

?>