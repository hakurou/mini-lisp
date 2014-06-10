<?php

namespace library\ml\expr;

/**
 * Représente une expression de base
 * @author hakurou
 * @version 1.0.0
 */
abstract class Exp
{
	public $type;
	
	/**
	 * Constructeur
	 * @param Const Int $type				Type d'expression
	 */
    public function __construct($type)
    {
        $this->type = $type;
    }
    
	/**
	 * Retourne le type d'expression
	 * @return Const Int 					Type d'expression
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * Demande l'interprétation de l'expression
	 * @param SymbolsTable $symbolsTable	Instance de la table des symboles
	 * @param Register $register			Instance du registre
	 * @param Array $expList				Liste d'expressions additionnelle
	 * @return Int Const/null				Retourne le type de retour ou null si pas de resultat
	 */
    abstract public function interpret($symbolsTable, $register, $expList = array());
	
	/**
	 * Demande le parsing syntaxique d'un type particulier
	 * @param Parser $parser				Instance du parseur syntaxique
	 * @param SymbolsTable $symbolsTable	Instance de la table des symboles
	 * @return Exp							Retourne l'expression correspondante
	 */
	abstract public function parse($parser, $symbolsTable);
}

?>