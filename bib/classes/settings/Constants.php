<?php

class Constants {

    public function __construct() {
        $this->defineDefaultConstants();

        $this->defineMessageConstants();

        $this->definePathConstants();

        $this->defineUrlConstants();
    }

    private function defineDefaultConstants() {
        define("POR_PAGINA", 10);
        define("ULTIMOS_REGISTROS", 10);
        define("MAXIMUM_MEMORY_REL", "64M");
        define("CONFIG_DRIVER", 'pdo_mysql');

        define("NOAUTH_MSG", "Sem permissão de acesso!"); // global para usuário autenticado
        define("NO_SELECTED_MSG", "Nenhum registro selecionado!"); // global para valores não selecionados
        define("FIRST_ACESS_MSG", "Não é o primeiro acesso do sistema!"); // retorno caso não seja o primeiro acesso


        define("RECAPTCHA_PUBLIC_KEY", "6LeaOngUAAAAALxkL4GIxcUejVre7ax0LiKsa1Bh"); // pro captcha
        define("RECAPTCHA_PRIVATE_KEY", "6LeaOngUAAAAAH4eauVz2EgQlJVTnppQJCGhNaxe"); // pro challenge
    }

    private function defineMessageConstants() {
        #CODIGOS REFERENTES A MENSAGEM
        define("MESSAGE_TYPE_1", "green"); # COR VERDE (CONFIRMAÇÃO)
        define("MESSAGE_TYPE_2", "yellow"); # COR AMARELA (COM ALERTA)
        define("MESSAGE_TYPE_3", "red"); # COR VERMELHA (ERRO)
        define("MESSAGE_TYPE_4", "blue"); # COR AZUL (INFO)
        # CODIGOS DE TEXTOS - AINDA REFERENTE A MENSAGENS
        define("MESSAGE_CODE_NP", "<i class='icon-warning'></i> Você não tem permissão para acessar esta página.");
        define("MESSAGE_CODE_1", "<i class='icon-ok'></i> Cadastro realizado com sucesso!");
        define("MESSAGE_CODE_2", "<i class='icon-ok'></i> Cadastro editado com sucesso!");
        define("MESSAGE_CODE_3", "<i class='icon-trash'></i> Registro excluído!");
        define("MESSAGE_CODE_4", "<i class='icon-trash'></i> Registro(s) excluído(s)!");
        define("MESSAGE_CODE_5", "<i class='icon-ok'></i> Cadastro confirmado com sucesso!");
    }

    private function definePathConstants() {
        define("DOCTRINE_PROXY_DIR", IGENIAL_ROOT_DIR . "/upload/temp/doctrine"); #path to doctrine temporary files

        define("IGENIAL_DIR_UPLOAD", IGENIAL_ROOT_DIR . "/upload"); #path para upload de arquivos
        define("IGENIAL_DIR_FRAMEWORK", IGENIAL_ROOT_DIR . "/framework"); #path para FRAMEWORK
        define("IGENIAL_DIR_VIEW", IGENIAL_DIR_FRAMEWORK . "/view"); #path para VIEW
        define("IGENIAL_DIR_MODEL", IGENIAL_DIR_FRAMEWORK . "/model"); #path para MODEL

        define("IGENIAL_DIR_BIBFRAMEWORK", IGENIAL_ROOT_DIR . "/bib/eFramework"); #path para FRAMEWORK
        define("IGENIAL_DIR_BIBVIEW", IGENIAL_DIR_BIBFRAMEWORK . "/view"); #path para VIEW
        define("IGENIAL_DIR_BIBMODEL", IGENIAL_DIR_BIBFRAMEWORK . "/model"); #path para MODEL
    }

    private function defineUrlConstants() {
        # Aqui ficam as constantes relativas a camada de Visão
        define("URL_SITE_EQ", "http://www.equilibriumweb.com");

        define("URL_BIB_VIEW", "../../bib/eFramework/view/");
        define("DEFAULT_VIEW", URL_BIB_VIEW . "app/Undefined.php");
        define("IS_SITE", FALSE); # se for site, mude para a 404 dentro do site e defina true aqui
        define("DEFAULT_404_VIEW", URL_BIB_VIEW . "404.php");
        #define("DEFAULT_404_VIEW", "site/404.php"); #exemplo de visao 404 do site

        define("URL_APP", URL); # caso se extenda para outros módulos
        define("URL_WEBROOT", URL_APP . "bib/webroot/");
        define("URL_WEBROOT_IMG", URL_APP . "bib/webroot/img/");
        define("URL_UPLOAD", URL_APP . "upload/");

        define("URL_HOME", URL_APP . "Usuario/home");
        define("URL_LOGIN", URL_APP . "admin");
        define("URL_RECUPERAR_SENHA", URL_APP . "admin/recuperarSenha/");
        define("URL_LOGOUT", URL_APP . "admin/logout");
        define("URL_SISTEMA", URL_APP . "framework/view/app/"); # URL da aplicação

        define("URL_SEGURANCA_USUARIO_TROCAR_SENHA", URL_APP . "usuario/trocarSenha/");
        define("URL_SEGURANCA_USUARIO_DADOS_PESSOAIS", URL_APP . "usuario/dadosPessoais/");
        define("URL_SEGURANCA_MEU_PERFIL", URL_APP . "usuario/meuPerfil/");

        define("NAO_DEFINIDO", "N/D");
        define("CAMPO_OBRIGATORIO", "<span style='color:red'>*</span>");
        define("MOSTRA_NUMERO_MENU_REQUISITO", true);

        # url's dos modulos # respeitar padrão da View.php e dos menus - modulo_menu (tabela nova e muito cuidado COM ELA! e nao esquecer .htacess)
        define("MODULO_CONFIGURACAO_ATIVO", false); # para aparecer a configuracao no menu de Seguranca
        define("MODULO_MENU_ATIVO", false); # para aparecer o modulo menu no menu de Seguranca
        $aModuloMenu = UtilAuth::recuperaModulosMenus();
        if ($aModuloMenu) {
            foreach ($aModuloMenu as $oModuloMenu) {
                define("URL_MODULO_" . strtoupper($oModuloMenu->getNome()), URL_APP . $oModuloMenu->getNome() . "/");
            }
        }

        define("URL_PORTAL", URL . "framework/view/portal/");
        define("URL_CRIAR_CONTA_CONFIRMA", URL_APP . "/criarContaConfirma/");
        define("EMAIL_MODERADOR", 'simonehashiguti@gmail.com');
        define("NOME_MODERADOR", 'Moderador');
        define("EMAIL_UFU", 'e-mail@ufu.br');
    }

}

?>