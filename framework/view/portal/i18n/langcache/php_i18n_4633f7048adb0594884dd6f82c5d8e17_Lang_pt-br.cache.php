<?php class Lang {
const greeting = 'Hallo Welt!';
const nome = 'Nome';
const email = 'Email';
const enviar = 'Enviar';
const login = 'Login';
const senha = 'Senha';
const confirmarSenha = 'Cofirmar Senha';
const voltar = 'Voltar';
const bemVindo = 'Bem Vindo(a)';
const sair = 'Sair';
const dataNascimento = 'Data de Nascimento';
const sexo = 'Sexo';
const cpf = 'CPF';
const cidade = 'Cidade';
const estado = 'Estado';
const nacionalidade = 'Nacionalidade';
const instituicaoEnsino = 'Insitituição de Ensino';
const curso = 'Curso';
const loginFacial = 'Login com reconhecimento facial?';
const category_somethingother = 'Etwas anderes...';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function Lang($string, $args=NULL) {
    $return = constant("Lang::".$string);
    return $args ? vsprintf($return,$args) : $return;
}