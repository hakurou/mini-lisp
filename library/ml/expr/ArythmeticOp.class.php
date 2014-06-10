<?php

namespace library\ml\expr;

/**
 * Expression d'opérateur arythmétique
 * @author hakurou
 * @version 1.0.0
 */
class ArythmeticOp extends Exp
{
	protected $operator;
	protected $values;	
	
	/**
	 * Constructeur
	 * @param Char $op						Operateur (+, -, /, *)
	 * @param Array $values					Valeurs avec lequels calculer
	 */
    public function __construct($op = null, array $values = array())
    {
    	parent::__construct(\library\ml\analysis\Lexer::TT_PRI);
        $this->op = $op;
        $this->values = $values;
    }
    
	/**
	 * @see Exp::interpret
	 */
    public function interpret($symbolsTable, $register, $expList = array())
    {
    	if(count($this->values) <= 1)
			trigger_error('ArythmeticOp: Error, more than one operand', E_USER_ERROR);
		
		$result = 0;
        if($this->op == '+')
			$result = $this->opAdd($symbolsTable, $register);
        if($this->op == '-')
			$result = $this->opSub($symbolsTable, $register);
        if($this->op == '*')
			$result = $this->opMul($symbolsTable, $register);
        if($this->op == '/')
			$result = $this->opDiv($symbolsTable, $register);
		
		$register->pushNumber($result);
		
		return \library\ml\symbols\Register::T_NUMBER;
    }
	
	/**
	 * @see Exp::parse
	 */
	public function parse($parser, $symbolsTable)
	{
		$op = $parser->getCurrentToken()->getValue();
		$args = array();
		$exp = $parser->parseExpr();
		
		while($exp != null)
		{
			$args[] = $exp;
			$exp = $parser->parseExpr();
		}
		
		if($parser->getCurrentToken()->getType() != \library\ml\analysis\Lexer::TT_RIGHT_PARENTHESIS)
            trigger_error('parseAdd: Unexpected token', E_USER_ERROR);

		$a = new \library\ml\expr\ArythmeticOp($op, $args);
		
		return $a;
	}
	
	/**
	 * Récupère une valeur réel sous forme de nombre
	 * @return Float							Valeur réelle
	 */
	protected function getNumber($v, $symbolsTable, $register)
	{
		$argType = $v->interpret($symbolsTable, $register);
		while($argType != null && $argType == \library\ml\symbols\Register::T_EXPR)
		{
			$exp = $register->popExpr();
			$argType = $exp->interpret($symbolsTable, $register);
		}
		
		if($argType != \library\ml\symbols\Register::T_NUMBER)
			trigger_error('ArythmeticOp::getNumber: Error, NaN', E_USER_ERROR);
		
		return $register->popNumber();
	}
	
	/**
	 * Calcule une addition
	 * @param SymbolsTable $symbolsTable		Instance de la table des symboles
	 * @param Register $register				Instance du registre
	 * @return Float							Retourne le résultat
	 */
	protected function opAdd($symbolsTable, $register)
	{
		$total = null;
		foreach($this->values as $v)
		{
			$r = $this->getNumber($v, $symbolsTable, $register);
			if($total == null)
				$total = $r;
			else
				$total += $r;	
		}
		
		return $total;
	}
	
	/**
	 * Calcule une soustraction
	 * @param SymbolsTable $symbolsTable		Instance de la table des symboles
	 * @param Register $register				Instance du registre
	 * @return Float							Retourne le résultat
	 */
	protected function opSub($symbolsTable, $register)
	{
		$total = null;
		foreach($this->values as $v)
		{
			$r = $this->getNumber($v, $symbolsTable, $register);
			if($total == null)
				$total = $r;
			else
				$total -= $r;	
		}
		
		return $total;
	}
	
	/**
	 * Calcule une multiplication
	 * @param SymbolsTable $symbolsTable		Instance de la table des symboles
	 * @param Register $register				Instance du registre
	 * @return Float							Retourne le résultat
	 */
	protected function opMul($symbolsTable, $register)
	{
		$total = null;
		foreach($this->values as $v)
		{
			$r = $this->getNumber($v, $symbolsTable, $register);
			if($total == null)
				$total = $r;
			else
				$total *= $r;	
		}
		
		return $total;
	}
	
	/**
	 * Calcule une division
	 * @param SymbolsTable $symbolsTable		Instance de la table des symboles
	 * @param Register $register				Instance du registre
	 * @return Float							Retourne le résultat
	 */
	protected function opDiv($symbolsTable, $register)
	{
		$total = null;
		foreach($this->values as $v)
		{
			$r = $this->getNumber($v, $symbolsTable, $register);
			if($total == null)
				$total = $r;
			else if($r != 0)
				$total /= $r;
			else	
				trigger_error('ArythmeticOp::opDiv: Division by zero', E_USER_ERROR);
		}
		
		return $total;
	}
}

?>