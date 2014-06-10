<?php

namespace library\ml\expr;

/**
 * Expression pour les mots clés
 * @author hakurou
 * @version 1.0.0
 */
class ReservedWord extends Exp
{
	protected $value;
	
	/**
	 * Constructeur
	 * @param String $value						Nom du mot réservé
	 */
    public function __construct($value)
	{
		parent::__construct(\library\ml\analysis\Lexer::TT_PRI);
		
		$this->value = $value;
	}
	
	/**
	 * @see Exp::interpret
	 */
	public function interpret($symbolsTable, $register, $expList = array())
	{
		
	}
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		
	}
}

?>