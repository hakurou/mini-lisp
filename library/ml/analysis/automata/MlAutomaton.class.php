<?php

namespace library\ml\analysis\automata;

/**
 * Automate propre au langage de mini lisp
 * @author hakurou
 * @version 1.0.0
 */
class MlAutomaton extends Automaton
{
	/**
	 * Constructeur
	 */
    public function __construct()
    {
        parent::__construct();
        
        $this->initAutomaton();
    }
    
	/**
	 * Initialise l'automate en remplissant les étapes pour la capture lexicale
	 */
    protected function initAutomaton()
    {
        $this->prepareNumber();
        $this->prepareParenthesis();
        $this->prepareString();
        $this->prepareWord();
        $this->prepareBlank();
        $this->prepareComment();
    }
    
	/**
	 * Ajoute les étapes pour traiter les commentaires
	 */
    protected function prepareComment()
    {
        $s10 = new State();
        $s11 = new State();
        
        $this->startState->addTransition(array(';'), $s10);
        $s10->addTransition(null, $s10);
        $s10->addTransition(array("\n"), $s11);
        
        $s11->setFinal();
        $s11->setCapture(false);
    }
    
	/**
	 * Ajoute les étapes pour traiter les nombres
	 */
    protected function prepareNumber()
    {
        $s1 = new State();
        $s2 = new State();
        
        $this->startState->addTransition(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $s1);
        $s1->addTransition(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $s1);
        $s1->addTransition(null, $s2);
        
        $s2->setFinal();
        $s2->setBack();
        $s2->setTokenType(\library\ml\analysis\Lexer::TT_NUMBER);
    }
    
	/**
	 * Ajoute les étapes pour traiter les parentheses
	 */
    protected function prepareParenthesis()
    {
        $s7 = new State();
        $s8 = new State();
        
        $this->startState->addTransition(array('('), $s7);
        $this->startState->addTransition(array(')'), $s8);
        
        $s7->setFinal();
        $s7->setTokenType(\library\ml\analysis\Lexer::TT_LEFT_PARENTHESIS);
        
        $s8->setFinal();
        $s8->setTokenType(\library\ml\analysis\Lexer::TT_RIGHT_PARENTHESIS);
    }
    
	/**
	 * Ajoute les étapes pour traiter les chaines de caracteres
	 */
    protected function prepareString()
    {
        $s3 = new State();
        $s4 = new State();
        $s12 = new State();
        
        $this->startState->addTransition(array('"'), $s3);
        
        $s3->setCapture(false);
        $s3->addTransition(null, $s12);
        $s3->addTransition(array('"'), $s4);
        $s12->addTransition(null, $s12);
        $s12->addTransition(array('"'), $s4);
        
        $s4->setCapture(false);
        $s4->setFinal();
        $s4->setTokenType(\library\ml\analysis\Lexer::TT_STRING);
    }
    
	/**
	 * Ajoute les étapes pour traiter les mots
	 */
    protected function prepareWord()
    {
        $s5 = new State();
        $s6 = new State();
        
        $this->startState->addTransition(null, $s5);
        $s5->addTransition(array('(', ')', "\r", "\n", ' ', "\t", '"'), $s6);
        $s5->addTransition(null, $s5);
        
        $s6->setFinal();
        $s6->setBack();
        $s6->setTokenType(\library\ml\analysis\Lexer::TT_WORD);
    }
    
	/**
	 * Ajout les étapes pour traiter les espaces blancs
	 */
    protected function prepareBlank()
    {
        $s9 = new State();
        
        $this->startState->addTransition(array("\r", "\n", ' ', "\t"), $s9);
        
        $s9->setFinal();
        $s9->setCapture(false);
        
    }
}

?>