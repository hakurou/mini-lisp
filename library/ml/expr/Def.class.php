<?php

namespace library\ml\expr;

/**
 * Expression definition de symboles
 * @author hakurou
 * @version 1.0.0
 */
class Def extends Exp
{
	protected $ident;
	protected $value;	
	
	/**
	 * Constructeur
	 * @param String $ident					Nom du symbole
	 * @param Exp $value					Expression de valeur
	 */
    public function __construct($ident = "", $value = "")
    {
    	parent::__construct(\library\ml\analysis\Lexer::TT_PRI);
        $this->ident = $ident;
        $this->value = $value;
    }
    
	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
		$expr = $this->getExpr($this->value, $symbolsTable, $register);

        $symbolsTable->set($this->ident, $expr);
    }
	
	/**
	 * Récupère la valeur du stmbole
	 * @return Int Const					Type d'expression ou null
	 */
	protected function getExpr($expr, $symbolsTable, $register)
	{
		if($expr->getType() == \library\ml\analysis\Lexer::TT_WORD ||
			$expr->getType() == \library\ml\analysis\Lexer::TT_FUNC_CALL)
		{
			$argType = $expr->interpret($symbolsTable, $register);
			if($argType != \library\ml\symbols\Register::T_EXPR)
				trigger_error('Def::getExpr: Error, bad type for expression', E_USER_ERROR);
			
			$expr = $register->popExpr();
		}

		return $expr;
	}
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		$parser->nextToken();
		$ident = $parser->getCurrentToken();

		if($ident->getType() != \library\ml\analysis\Lexer::TT_WORD)
			trigger_error('parseDefine: Unexpected token at arg 1', E_USER_ERROR);

		$d = new \library\ml\expr\Def($ident->getValue(), $parser->parseExpr());
		
		$parser->nextToken();

        if($parser->getCurrentToken()->getType() != \library\ml\analysis\Lexer::TT_RIGHT_PARENTHESIS)
            trigger_error('Def::parse: Unexpected token', E_USER_ERROR);
		
		return $d;
	}
}

?>