<?php

class InterfaceHTMLParent {

    public static function select($id, $tabindex, $fkclass, $fkattr, $fkdesc, $valueSelect = NULL, $order = NULL, $event = "", $paramBusca = NULL) {
        $valueSelect = trim($valueSelect);
        eval("\$action= new {$fkclass}Action();");
        $object = $action->collection(null, $paramBusca, $order <> NULL ? $order : NULL);
        $ret = "<select class='form-control' id='" . $id . "' name='" . $id . "' tabindex='" . $tabindex . "' " . $event . ">";
        if (!$object) {
            $ret .= "<option value=''> --- " . Language::getText("Nenhum registro encontrado") . " --- </option>";
        } else {
            $ret .= "<option value=''> - " . Language::getText("Selecione") . " - </option>";
            if ($object)
                foreach ($object as $o) {
                    eval("\$value=htmlspecialchars(\$o->get" . ucfirst($fkattr) . "() );");
                    eval("\$descricao=htmlspecialchars(\$o->get" . ucfirst($fkdesc) . "() );");

                    if (trim($value) == trim($valueSelect))
                        $selected = "selected=\"selected\"";
                    else
                        $selected = "";
                    $ret .= "<option value='" . $value . "' " . $selected . ">" . $descricao . "</option>";
                }
        }

        $ret .= "</select>";
        return $ret;
    }

    public static function selectMultiple($id, $tabindex, $fkclass, $fkattr, $fkdesc, $aValueSelected = NULL, $paramBusca = NULL, $order = NULL, $size = 8) {
        eval("\$action= new {$fkclass}Action();");
        $object = $action->collection(null, $paramBusca, $order <> NULL ? $order : NULL);
        $valores_esquerda = null;
        if ($object) {
            foreach ($object as $o) {
                eval("\$value=htmlspecialchars(\$o->get" . ucfirst($fkattr) . "() );");
                eval("\$descricao=htmlspecialchars(\$o->get" . ucfirst($fkdesc) . "() );");
                $passarObjeto = false;
                if ($aValueSelected) {
                    foreach ($aValueSelected as $oSelected) {
                        eval("\$valueSelected = htmlspecialchars(\$oSelected->get" . ucfirst($fkattr) . "() );");
                        if (trim($value) == trim($valueSelected))
                            $passarObjeto = true;
                    }
                }
                if ($passarObjeto)
                    continue;
                $valores_esquerda .= "<option value='{$value}' >{$descricao}</option>";
            }
        }
        $esquerda = <<<EOT
                <select class="custom-scroll" id='left{$id}' multiple='multiple' size='$size' tabindex='{$tabindex}' >{$valores_esquerda}</select>
EOT;
        $botoes = <<<EOT
                <input class="btn btn-primary btn-sm btn-block" name="left{$id}TOright{$id}" value="&raquo;" type="button" tabindex="{$tabindex}"/>
                <input class="btn btn-danger btn-sm btn-block" name="right{$id}TOleft{$id}" value="&laquo" type="button" tabindex="{$tabindex}"/>
EOT;
        // Valores selecionados
        $valores_direita = null;
        if ($aValueSelected) {
            foreach ($aValueSelected as $o) {
                eval("\$value=htmlspecialchars(\$o->get" . ucfirst($fkattr) . "() );");
                eval("\$descricao=htmlspecialchars(\$o->get" . ucfirst($fkdesc) . "() );");
                $valores_direita .= "<option value='{$value}' >{$descricao}</option>";
            }
        }
        $direita = <<<EOT
                <select class="custom-scroll" id='right{$id}' size='$size' multiple='multiple' uType='multiple' name='{$id}[]' tabindex='{$tabindex}' >{$valores_direita}</select>
EOT;
        $saida = <<<EOT
<div class="row">
    <section class="col col-4">
        <label class="label">Disponível</label>
        <label class="select select select-multiple">
            {$esquerda}
        </label>
    </section>
    <section class="col col-4">
        <label class="label text-center">&nbsp;</label>
        <div class="col-lg-12 low">
            {$botoes}
        </div>
    </section>
    <section class="col col-4">
        <label class="label">Selecionado</label>
        <label class="select select select-multiple">
            {$direita}
        </label>
    </section>
</div>
EOT;
        return $saida;
    }

    public static function selectMultipleName($id, $name, $tabindex, $fkclass, $fkattr, $fkdesc, $aValueSelected = NULL, $paramBusca = NULL, $order = NULL, $size = 8) {
        eval("\$action= new {$fkclass}Action();");
        $object = $action->collection(null, $paramBusca, $order <> NULL ? $order : NULL);
        $valores_esquerda = null;
        if ($object) {
            foreach ($object as $o) {
                eval("\$value=htmlspecialchars(\$o->get" . ucfirst($fkattr) . "() );");
                eval("\$descricao=htmlspecialchars(\$o->get" . ucfirst($fkdesc) . "() );");
                $passarObjeto = false;
                if ($aValueSelected) {
                    foreach ($aValueSelected as $oSelected) {
                        eval("\$valueSelected = htmlspecialchars(\$oSelected->get" . ucfirst($fkattr) . "() );");
                        if (trim($value) == trim($valueSelected))
                            $passarObjeto = true;
                    }
                }
                if ($passarObjeto)
                    continue;
                $valores_esquerda .= "<option value='{$value}' >{$descricao}</option>";
            }
        }
        $esquerda = <<<EOT
                <select class="custom-scroll" id='left{$id}' multiple='multiple' size='$size' tabindex='{$tabindex}' >{$valores_esquerda}</select>
EOT;
        $botoes = <<<EOT
                <input class="btn btn-primary btn-sm btn-block" name="left{$id}TOright{$id}" value="&raquo;" type="button" tabindex="{$tabindex}"/>
                <input class="btn btn-danger btn-sm btn-block" name="right{$id}TOleft{$id}" value="&laquo" type="button" tabindex="{$tabindex}"/>
EOT;
        // Valores selecionados
        $valores_direita = null;
        if ($aValueSelected) {
            foreach ($aValueSelected as $o) {
                eval("\$value=htmlspecialchars(\$o->get" . ucfirst($fkattr) . "() );");
                eval("\$descricao=htmlspecialchars(\$o->get" . ucfirst($fkdesc) . "() );");
                $valores_direita .= "<option value='{$value}' >{$descricao}</option>";
            }
        }
        $direita = <<<EOT
                <select class="custom-scroll" id='right{$id}' size='$size' multiple='multiple' uType='multiple' name='{$name}[]' tabindex='{$tabindex}' >{$valores_direita}</select>
EOT;
        $saida = <<<EOT
<div class="row">
    <section class="col col-4">
        <label class="label">Disponível</label>
        <label class="select select select-multiple">
            {$esquerda}
        </label>
    </section>
    <section class="col col-4">
        <label class="label text-center">&nbsp;</label>
        <div class="col-lg-12 low">
            {$botoes}
        </div>
    </section>
    <section class="col col-4">
        <label class="label">Selecionado</label>
        <label class="select select select-multiple">
            {$direita}
        </label>
    </section>
</div>
EOT;
        return $saida;
    }

    public static function getMonthHTMLSelect($id, $tabindex, $selectedValue = null) {
        $html = "<select class='selectmonth' id='$id' name='$id' tabindex='$tabindex'>
            <option value='0'>-" . Language::getText('Selecione') . "-</option>
            <option value='1' " . ($selectedValue == '1' ? 'selected' : '') . ">" . Language::getText("Janeiro") . "</option>
            <option value='2' " . ($selectedValue == '2' ? 'selected' : '') . ">" . Language::getText("Fevereiro") . "</option>
            <option value='3' " . ($selectedValue == '3' ? 'selected' : '') . ">" . Language::getText("Março") . "</option>
            <option value='4' " . ($selectedValue == '4' ? 'selected' : '') . ">" . Language::getText("Abril") . "</option>
            <option value='5' " . ($selectedValue == '5' ? 'selected' : '') . ">" . Language::getText("Maio") . "</option>
            <option value='6' " . ($selectedValue == '6' ? 'selected' : '') . ">" . Language::getText("Junho") . "</option>
            <option value='7' " . ($selectedValue == '7' ? 'selected' : '') . ">" . Language::getText("Julho") . "</option>
            <option value='8' " . ($selectedValue == '8' ? 'selected' : '') . ">" . Language::getText("Agosto") . "</option>
            <option value='9' " . ($selectedValue == '9' ? 'selected' : '') . ">" . Language::getText("Setembro") . "</option>
            <option value='10' " . ($selectedValue == '10' ? 'selected' : '') . ">" . Language::getText("Outubro") . "</option>
            <option value='11' " . ($selectedValue == '11' ? 'selected' : '') . ">" . Language::getText("Novembro") . "</option>
            <option value='12' " . ($selectedValue == '12' ? 'selected' : '') . ">" . Language::getText("Dezembro") . "</option>
            </select>";
        return $html;
    }

    /**
     * Gera a função para controle de mensagens na index (os alertas dinamicos)<br/>
     * Para mais referências consulte a classe de constantes, lá você pode definir 
     * sua mensagem para exibição dinâmica após um reload
     * @param int $MESSAGE_TYPE o inteiro correspondente ao tipo de mensagem
     * @param int $MESSAGE_CODE o inteiro correspondente ao código da mensagem
     * @return string Uma string com a função em JS para exibir o alerta
     */
    public function generateMessageFunction($MESSAGE_TYPE, $MESSAGE_CODE) {
        if ($MESSAGE_TYPE && $MESSAGE_CODE) {
            # tem que estar no eval para recuperar o valor da CONSTANTE
            eval("\$MESSAGE_TYPE = MESSAGE_TYPE_{$MESSAGE_TYPE};");
            eval("\$MESSAGE_CODE = MESSAGE_CODE_{$MESSAGE_CODE};");
            return "uMessage({$MESSAGE_TYPE}, '{$MESSAGE_CODE}');\n";
        }
    }

    /*
      sugestões para implementações de elementos que possam ser reutilizados
     */

    /*
      select sem dependencia das actions e modelos, puramente html e estilos padronizados para o sistema...
      $selected='value2' ;
      ou caso seja type=multi
      $selected=array('value1','value2');

      $options=array(
      'value1'=>'text1',
      'value2'=>'text2',
      'value3'=>'text3',
      );
      //quem sabe parametrizar as classes e outros atributos,
     */

    public function selectSimples($options, $selected, $empty = "Selecione...") {
        
    }

    /*
      a mesma ideia p radios...
     */

    public function radio($options, $selected, $orientation = "V|H") {
        
    }

    /**
     * 
     * @param string $id o atributo ID do suggest
     * @param string $name o atributo NAME do suggest. Se for NULL ele usa o $id
     * @param int $tabindex o indice de tab
     * @param string $fkclass a classe alvo do suggest
     * @param int $pkVal o valor da chave primária
     * @param string $pkDesc o valor descritivo do campo (caso seja nulo, e o $pkVal exista, ele busca no servidor o valor. Se houver $pkVal, e tiver o objeto, utilize o método suggestDesc ou suggestDescHtml, dependendo da necessidade)
     * @param string $onSelect nome da função para ser executada após a seleção (ex: funcao(id,value) )
     * @return string o campo com a formatação do suggest
     */
    public static function suggest($id, $name, $tabindex, $fkclass, $pkVal = NULL, $pkDesc = NULL, $onSelect = NULL) {
        if ($name === NULL OR $name = '') {
            $name = $id;
        }
        if ($onSelect !== NULL) {
            $onSelect = "onselect='{$onSelect}'";
        }
        return "<suggest id='{$id}' name='{$name}' entity='{$fkclass}' hasComboBox='true' tabindex='{$tabindex}' value='{$pkVal}' descValue='{$pkDesc}' />";
    }

    public function suggestMultiplo() {
        
    }

    //input padrao para 
    public function image() {
        
    }

    public function imageMultiplo() {
        
    }

    public static function imageCrop($name, $class, $tabindex, $ratio = "4/3", $minWidth = "75", $minHeight = "75", $imageName = NULL) {
        $fields = array();
        $inputStyle = "";
        if ($imageName != NULL) {
            $src = MediaUtil::getLinkForFileNameById($class, $imageName);
            $fields[] = "<img src='{$src}'  alt='' class='img-thumbnail' width='75' height='75'>";
            $inputStyle = "display:none;";
            $fields[] = "<button title='Alterar imagem' onclick='$(\"#div_{$name}\").slideToggle();' class='btn btn-default btn-sm btn-circle'><i class='fa fa-pencil'></i></button>";
        }
        $fields[] = "<div id='div_{$name}' class='input input-file col-2' style='{$inputStyle}'><span class='button'>"
                . "<input class='inptext' type='file' id='{$name}' name='{$name}' tabindex='{$tabindex}' size='20' onchange='CropImgSendHandler(this, {$ratio}, {$minWidth}, {$minHeight}); $(this).closest(\"span.button\").next(\"input\").val(this.value);'/>"
                . 'Selecionar</span><input type="text" placeholder="Selecione um arquivo" readonly=""></div>';
        $aHidden = array(
            "<input type='hidden' name='x{$name}' id='x{$name}' value=''/>",
            "<input type='hidden' name='y{$name}' id='y{$name}' value=''/>",
            "<input type='hidden' name='w{$name}' id='w{$name}' value=''/>",
            "<input type='hidden' name='h{$name}' id='h{$name}' value=''/>"
        );
        $fields[] = join("", $aHidden);
        return join("", $fields);
    }

}

?>
