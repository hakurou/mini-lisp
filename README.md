mini-lisp
=========

Parseur de langage de type Lisp / Scheme simplifié

Utilisation
------------

Pour utiliser le parseur ou pour jouer avec, il suffit d'inclure le fichier library/ml/MiniLisp et de l'intancier:

`````php
$ml = new \library\ml\MiniLisp();
$ml->parseFile('CheminDuFichierDeScriptAParser.lsp');
`````

Ensuite on peut tester le parseur avec quelques instructions basiques telle que:
`````scheme
(display "hello,world!")
(newline)
(display "how are u bro ?")
`````

Voir le fichier de test tests/test2.lsp afin d'avoir une idée sur ce qui est faisable.