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
const dataNascimento = 'Date of birth';
const sexo = 'Sexo';
const cpf = 'CPF';
const cidade = 'City';
const estado = 'State';
const nacionalidade = 'Nationality';
const instituicaoEnsino = 'Educational Institution';
const curso = 'Course';
const loginFacial = 'Login with facial recognition?';
const category_somethingother = 'Something other...';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function Lang($string, $args=NULL) {
    $return = constant("Lang::".$string);
    return $args ? vsprintf($return,$args) : $return;
}