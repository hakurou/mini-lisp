<?php

namespace library\ml\expr;

/**
 * Expression représentant une fonction
 * @author hakurou
 * @version 1.0.0
 */
class Lambda extends Exp
{
	protected $args;
	protected $exprList;
	
	/**
	 * Constructeur
	 * @param Array $args					Arguments de la fonction
	 * @param Array $exprList				Liste d'expressions contenu dans la fonction
	 */
    public function __construct($args = array(), $exprList = array())
    {
        if(count($args) == 0 && count($exprList) == 0)
            parent::__construct(\library\ml\analysis\Lexer::TT_PRI);
        else
            parent::__construct(\library\ml\analysis\Lexer::TT_LAM);
            
        $this->args = $args;
        $this->exprList = $exprList;
    }
    
	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
    	$returnExp = null;
        $symbolsTable->defineNewScope();
		
		// Passage arguments
		if(count($this->args) > 0)
		{
			foreach($this->args as $index => $arg)
			{
				if(isset($expList[$index]))
					$symbolsTable->set($arg, $expList[$index]);
				else
					$symbolsTable->set($arg, new Nil());					
			}
		}
		
		// Lecture du contenu 
		foreach($this->exprList as $index => $exp)
		{
			if($exp->getType() != \library\ml\analysis\Lexer::TT_LAM)	
				$argType = $exp->interpret($symbolsTable, $register);
		}
		
		// Retour d'argument si le dernier est une lambda
		if($this->exprList[$index]->getType() == \library\ml\analysis\Lexer::TT_LAM)
		{
			$register->pushExpr($this->exprList[$index]);
			$argType = \library\ml\symbols\Register::T_EXPR;
		}
		
		$symbolsTable->backToPreviousScope();
		
		return $argType;
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		$args = array();
		$exprList = array();
		$parser->nextToken();
		
		if($parser->getCurrentToken()->getType() != \library\ml\analysis\Lexer::TT_LEFT_PARENTHESIS)
			trigger_error('Lambda::parse: Unexpected token "'.$parser->getCurrentToken()->getValue().'", left parenthesis waited', E_USER_ERROR);
		
		$parser->nextToken();
		while($parser->getCurrentToken()->getType() == \library\ml\analysis\Lexer::TT_WORD)
		{
			$args[] = $parser->getCurrentToken()->getValue();
			$parser->nextToken();
		}
		
		if($parser->getCurrentToken()->getType() != \library\ml\analysis\Lexer::TT_RIGHT_PARENTHESIS)
			trigger_error('Lambda::parse: Unexpected token "'.$parser->getCurrentToken()->getValue().'", right parenthesis waited', E_USER_ERROR);
		
		$exp = $parser->parseExpr();
		while($exp != null)
		{
			$exprList[] = $exp;
			$exp = $parser->parseExpr();
		}
		
		if($parser->getCurrentToken()->getType() != \library\ml\analysis\Lexer::TT_RIGHT_PARENTHESIS)
			trigger_error('Lambda::parse: Unexpected token "'.$parser->getCurrentToken()->getValue().'", expression waited', E_USER_ERROR);
		
		return new Lambda($args, $exprList);
	}
}

?>