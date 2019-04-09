<?php class Lang {
const greeting = 'Hello World!';
const nome = 'Name';
const email = 'Email';
const enviar = 'Submit';
const login = 'Login';
const senha = 'Password';
const confirmarSenha = 'Confirm Password';
const voltar = 'Go Back';
const bemVindo = 'Welcome';
const sair = 'Logout';
const category_somethingother = 'Something other...';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function Lang($string, $args=NULL) {
    $return = constant("Lang::".$string);
    return $args ? vsprintf($return,$args) : $return;
}