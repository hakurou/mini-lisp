<?php

namespace library\ml\symbols;

/**
 * Représentation de la table des symboles
 * @author hakurou
 * @version 1.0.0
 */
class SymbolsTable
{
	/**
	 * Scope courant
	 * @var Scope
	 */
    protected $currentScope;
    
	/**
	 * Constructeur
	 */
    public function __construct()
    {
        $this->currentScope = new Scope();
    }
    
	/**
	 * Définit un nouveau scope courant
	 */
    public function defineNewScope()
    {
        $this->currentScope = new Scope($this->currentScope);
    }
    
	/**
	 * Restaure le scope précédant
	 */
    public function backToPreviousScope()
    {
        $this->currentScope = $this->currentScope->getParentScope(); 
    }
    
	/**
	 * Demande la récupération d'un symbole dans le scope courant
	 * @param String $key				Clé du symbole
	 * @return Exp						Retourne l'expression correspondante
	 */
    public function get($key)
    {
        return $this->currentScope->get($key);
    }
    
	/**
	 * Définit un nouveau symbole dans la table
	 * @param String $key				Clé du symbole
	 * @param Exp $value				Expression à pusher
	 */
    public function set($key, $value)
    {
        $this->currentScope->set($key, $value);
    }
    
	/**
	 * Véfirie l'existance d'un symbole
	 * @param String $key				Clé du symbole
	 * @return Boolean					True si le symbole existe, sinon false
	 */
    public function isExists($key)
    {
        return $this->currentScope->isExists($key);
    }
}

?>