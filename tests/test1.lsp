;; Redefinition of standard procedures
(set! +
      (let ((original+ +))
        (lambda args
          (if (and (not (null? args)) (string? (car args)))
              (apply string-append args)
              (apply original+ args)))))
(+ 1 2 3)
(+ "1" "2" "3")





(define mf 
  (lambda () 
  
    (display "in function")
  
    (lambda ()
      (newline) 
      (display "coucou"))))

(define toto (mf))
(toto)
(newline)
((mf))