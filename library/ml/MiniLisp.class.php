<?php

namespace library\ml;

/**
 * Amorce du parseur
 * @author hakurou
 * @version 1.0.0
 * grammaire complète: http://www.scheme.com/tspl2d/grammar.html
 * grammaire simplifiée: http://fr.wikibooks.org/wiki/Programmation_Scheme/Grammaire_de_base
 */
class MiniLisp
{
	/**
	 * Instance de la table des symboles
	 * @var SymbolsTable
	 */
    protected $symbolsTable;
	
	/**
	 * Instance des registres
	 * @var Register
	 */
    protected $register;
	
	/**
	 * Constructeur
	 */
    public function __construct()
    {
        $this->symbolsTable = new symbols\SymbolsTable();
        $this->register = new symbols\Register();
		
        $this->reservedWord();
    }
    
	/**
	 * Parsing d'un fichier de script
	 * @param String $filename				Chemin du fichier a parser
	 */
    public function parseFile($filename)
    {
        $parser = new analysis\Parser($this->symbolsTable, $this->register);
        $parser->parseFile($filename);
    }
	
	/**
	 * Méthode d'affichage d'information pour le débug
	 * @param Mixed $out					Données a afficher
	 */
	public static function out($out)
	{
		echo '<pre>'.print_r($out, true).'</pre>';
	}
    
	/**
	 * Définition des mots réservés du langage
	 */
    protected function reservedWord()
    {
        $this->symbolsTable->set('display', 	new expr\Display());
        $this->symbolsTable->set('define', 		new expr\Def());
        $this->symbolsTable->set('+', 			new expr\ArythmeticOp());
        $this->symbolsTable->set('-', 			new expr\ArythmeticOp());
        $this->symbolsTable->set('/', 			new expr\ArythmeticOp());
        $this->symbolsTable->set('*', 			new expr\ArythmeticOp());
		$this->symbolsTable->set('newline', 	new expr\NewLine());
		$this->symbolsTable->set('lambda',  	new expr\Lambda());
		// set!
		// if
    }
}

?>