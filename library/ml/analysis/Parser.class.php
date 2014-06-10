<?php

namespace library\ml\analysis;

/**
 * Analyseur syntaxique
 * @author hakurou
 * @version 1.0.0
 */
class Parser
{
	/**
	 * Instance de l'analyseur lexical
	 * @var Lexer
	 */
    protected $lexer;
	
	/**
	 * Token courant
	 * @var Token
	 */
    protected $currentToken;
	
	/**
	 * Instance de la table des symboles
	 * @var SymbolsTable
	 */
    protected $symbolsTable;
	
	/**
	 * Instance du registre
	 * @var Register
	 */
    protected $register;
	
	/**
	 * Constructeur
	 * @param SymbolsTable $symbolsTable		Instance de la table des symboles
	 * @param Register $register				Instance du registre
	 */
    public function __construct($symbolsTable, $register)
    {
        $this->symbolsTable = $symbolsTable;
		$this->register = $register;
    }
    
	/**
	 * Parse un fichier de source
	 * @param String $filename					Fichier a traiter
	 */
    public function parseFile($filename)
    {
        $this->lexer = new Lexer($filename, Lexer::T_FILE, $this->symbolsTable);
		
		// $exprList = array(); 
		while(($expr = $this->parseExpr()) != null)
		{
			// $exprList[] = $expr;
			if($expr->getType() != \library\ml\analysis\Lexer::TT_LAM)	
	        	$expr->interpret($this->symbolsTable, $this->register);
		}

		//echo '<pre>'.print_r($this->symbolsTable, true).'</pre>';
    }
	
	/**
	 * Récupère le token courant
	 * @return Token							Token courant
	 */
	public function getCurrentToken()
	{
		return $this->currentToken;
	}
	
	/**
	 * récupère le token suivant
	 */
	public function nextToken()
    {
        $this->currentToken = $this->lexer->getNextToken();
		//echo '<pre>'.print_r($this->currentToken, true).'</pre>';
    }

	/**
	 * Parse une expression
	 * @return Exp/null							Retourne une expression si trouvée, sinon null
	 */
    public function parseExpr()
    {
    	$this->nextToken();

		if($this->currentToken == null)
			return;
		
        if($this->currentToken->getValue() == "(")
        {
            $this->nextToken();
            return $this->parsePrth();
        }
        else
        {
        	// if($this->currentToken->getType() == Lexer::TT_PRI)
				// \library\ml\MiniLisp::out($this->currentToken);
			
            if($this->currentToken->getType() == Lexer::TT_STRING)
                return new \library\ml\expr\String($this->currentToken->getValue());
			else if($this->currentToken->getType() == Lexer::TT_NUMBER)
                return new \library\ml\expr\Number($this->currentToken->getValue());
			else if($this->currentToken->getType() == Lexer::TT_WORD || $this->currentToken->getType() == Lexer::TT_PRI) // 
				return new \library\ml\expr\Word($this->currentToken->getValue());
        }
    }
    
	/**
	 * Parse une expression parenthèsée
	 * @return Exp/null							Retourne une expression si trouvée, sinon null
	 */
    protected function parsePrth()
    {
        $sym = $this->symbolsTable->get($this->currentToken->getValue());
		
        if($sym == null)
        	return $this->parseFunCall();
		else
		{
		    //\library\ml\MiniLisp::out($this->currentToken);
		    //\library\ml\MiniLisp::out($sym);
		    if($sym->getType() == \library\ml\analysis\Lexer::TT_LAM)
                return $this->parseFunCall();
            else
                return $sym->parse($this, $this->symbolsTable);
		}
    }

	/**
	 * Parse une expression d'appel de fonction
	 * @return Exp/null							Retourne une expression si trouvée, sinon null
	 */
	protected function parseFunCall()
	{
		$args = array();
		
		if($this->currentToken->getType() != \library\ml\analysis\Lexer::TT_LEFT_PARENTHESIS)
			$funcName = new \library\ml\expr\Word($this->currentToken->getValue());
		else
		{
			$this->nextToken();
			$funcName = $this->parsePrth();
		}
		
		$exp = $this->parseExpr();
		while($exp != null)
		{
			$args[] = $exp;
			$exp = $this->parseExpr();
		}
		
		if($this->currentToken->getType() != Lexer::TT_RIGHT_PARENTHESIS)
            trigger_error('parseFunCall: Unexpected token', E_USER_ERROR);

		$a = new \library\ml\expr\FunCall($funcName, $args);
		
		return $a;
	}

}

?>