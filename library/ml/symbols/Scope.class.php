<?php

namespace library\ml\symbols;

/**
 * Représente un scope
 * @author hakurou
 * @version 1.0.0
 */
class Scope
{
	/**
	 * Liste des symboles du scope
	 * @var Array
	 */
    protected $symbols;
	
	/**
	 * Scope parent
	 * @var Scope
	 */
    protected $parentScope;

	/**
	 * Constructeur
	 * @param Scope $parentScope			Instance du scope parent
	 */    
    public function __construct($parentScope = null)
    {
        $this->symbols = array();
        $this->parentScope = $parentScope;
    }
	
	/**
	 * Définit un nouveau symbole dans la table
	 * @param String $key				Clé du symbole
	 * @param Exp $value				Expression à pusher
	 */
    public function set($key, $value)
    {
        $this->symbols[$key] = $value;
    }
    
	/**
	 * Demande la récupération d'un symbole dans le scope courant
	 * @param String $key				Clé du symbole
	 * @return Exp						Retourne l'expression correspondante
	 */
    public function get($key)
    {
        if(isset($this->symbols[$key]))
            return $this->symbols[$key];
        else if($this->parentScope != null)
            return $this->parentScope->get($key);
        else
            return null;
    }
    
	/**
	 * Véfirie l'existance d'un symbole
	 * @param String $key				Clé du symbole
	 * @return Boolean					True si le symbole existe, sinon false
	 */
    public function isExists($key)
    {
        return isset($this->symbols[$key]);
    }
    
	/**
	 * Retourne l'instance du scope précédent
	 * return Scope						Instance du scope précédent
	 */
    public function getParentScope()
    {
        return $this->parentScope;
    }
}

?>