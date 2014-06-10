<?php

namespace library\ml\analysis;

/**
 * Analyseur lexical
 * @author hakurou
 * @version 1.0.0
 */
class Lexer
{
	// Constantes du type de source a traiter
    const T_FILE = 1;
    const T_STRING = 2;
    
	// Constantes de type token
    const TT_WORD = 3;
    const TT_LEFT_PARENTHESIS = 4;
    const TT_RIGHT_PARENTHESIS = 5;
    const TT_NUMBER = 6;
    const TT_STRING = 7;
    const TT_ADD = 8;
    const TT_SUB = 9;
    const TT_MUL = 10;
    const TT_DIV = 11;
    const TT_IF = 12;
    const TT_DEF = 13;
    const TT_LAM = 14;
    const TT_SET = 15;
    const TT_DISPLAY = 16;
	const TT_PRI = 17;
	const TT_FUNC_CALL = 18;
    
    protected $source;
    protected $states;
    protected $automaton;
    protected $cursor;
	
	/**
	 * Instance de la table des symboles
	 * @var SymbolsTable
	 */
    protected $symbolsTable;
    
	/**
	 * Constructeur
	 * @param String $str					Soit la source, soit le chemin de la source
	 * @param Int Const $contentType		Type de source a parser
	 * @param SymbolsTable $symbolsTable	Instance de la table des symboles
	 */
    public function __construct($str, $contentType, $symbolsTable)
    {
        $this->cursor = 0;
        $this->symbolsTable = $symbolsTable;
        
        if($contentType == self::T_FILE)
            $this->source = file_get_contents($str);
        else if($contentType == self::T_STRING)
            $this->source = $str;
        
        $this->automaton = new automata\MlAutomaton();
    }
    
	/**
	 * Récupère le prochain token
	 * @return Token						Retourne un token quand il est trouvé, sinon null
	 */
    public function getNextToken()
    {
        $tokens = null;
        while(isset($this->source[$this->cursor]))
        {
            $result = $this->automaton->test($this->source[$this->cursor]);
         
            if($result == automata\MlAutomaton::R_SUCCESS || 
                $result == automata\MlAutomaton::R_SUCCESS_BACK ||
                $result == automata\MlAutomaton::R_SUCCESS_IGNORE)
            {
                $t = $this->automaton->getToken();
                if($t['tokenType'] != null)
                {
                    $token = new tokens\Token();
                    $token->setValue($t['word']);
                    $token->setType($t['tokenType']);
                    $tokens = $token;
                }
            }
            else if($result == automata\MlAutomaton::R_ERROR)
            {
                trigger_error('Lexical error');
                break;
            }
            
            if($result != automata\MlAutomaton::R_SUCCESS_BACK)
                $this->cursor++;
            
            if($result == automata\MlAutomaton::R_SUCCESS || 
                $result == automata\MlAutomaton::R_SUCCESS_BACK)
                break;
        }

        return $tokens;
    }
}

?>