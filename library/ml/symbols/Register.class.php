<?php

namespace library\ml\symbols;

/**
 * Registre de stockage des valeurs réelle du langage
 * @author hakurou
 * @version 1.0.0
 */
class Register
{
	/**
	 * Constantes d'identification des registres
	 */
	const T_STRING = 1;
	const T_NUMBER = 2;
	const T_EXPR = 3;
	
	/**
	 * Pile pour les chaines de caracteres
	 * @var SplStack
	 */
	protected $stringStack;
	
	/**
	 * Pile pour les nombres
	 * @var SplStack
	 */
	protected $numberStack;
	
	/**
	 * Pile pour les expressions
	 * @var SplStack
	 */
	protected $exprStack;
	
	/**
	 * Constructeur
	 */
    public function __construct()
    {
       $this->exprStack = new \SplStack();
       $this->numberStack = new \SplStack();
       $this->stringStack = new \SplStack();
    }
    
	/**
	 * Ajoute une nouvelle valeur dans l'un des registres
	 * @param Int Const $type				Identifiant du registre
	 * @param Mixed $value					Valeur a enregistrer
	 */
    public function push($type, $value)
    {
        if($type == self::T_STRING)
			$this->stringStack->push($value);
		else if($type == self::T_NUMBER)
			$this->numberStack->push($value);
		else if($type == self::T_EXPR)
			$this->exprStack->push($value);
    }
    
	/**
	 * Dépile la valeur de l'un des registres
	 * @param Int Const $type				Identifiant du registre
	 * @return								Valeur dépilée
	 */
    public function pop($type)
    {
        if($type == self::T_STRING)
			return $this->stringStack->pop();
		else if($type == self::T_NUMBER)
			return $this->numberStack->pop();
		else if($type == self::T_EXPR)
			return $this->exprStack->pop();
    }
	
	/**
	 * Raccourci pour ajouter une valeur dans le registrer STRING
	 * @param String $value					Valeur string 
	 */
	public function pushString($value)
	{
		$this->stringStack->push($value);
	}
	
	/**
	 * Raccourci pour ajouter une valeur dans le registre NUMBER
	 * @param Float $value					Valeur NUMBER
	 */
	public function pushNumber($value)
	{
		$this->numberStack->push($value);
	}
	
	/**
	 * Raccourci pour ajouter une valeur dans le registre EXPR
	 * @param Exp $value					Valeur EXPR
	 */
	public function pushExpr($value)
	{
		$this->exprStack->push($value);
	}
	
	/**
	 * Raccourci pour dépiler le registre STRING
	 * @return 								Valeur dépilée
	 */
	public function popString()
	{
		return $this->stringStack->pop();
	}
	
	/**
	 * Raccourci pour dépiler le registre NUMBER
	 * @return 								Valeur dépilée
	 */
	public function popNumber()
	{
		return $this->numberStack->pop();
	}
	
	/**
	 * Raccourci pour dépiler le registre EXPR
	 * @return 								Valeur dépilée
	 */
	public function popExpr()
	{
		return $this->exprStack->pop();
	}
}

?>