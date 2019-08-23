<?php
$aId = array_keys($kIdioma);
?>

<input type="hidden" id="coluna" value="<?php echo $response->get("aColunaCount") ? $response->get("aColunaCount") : 0 ?>"/>

<div id="Atividade-coluna-model" style="display: none;">
    <?php include("Atividade.REL.model.php"); ?>
</div>

<div id="div-relaciona" class="remover_div" style="<?php echo $o && $o->getTipo() == 'REL' ? '' : 'display: none' ?>">
    <header style="display: flex; justify-content: space-between; align-items: center">
        Colunas
        <button onclick="AtividadeAdicionarColuna('<?php echo implode("_", $aId) ?>')" type="button" class="btn btn-primary btn-sm pull-right" title="Clique para adicionar mais colunas"><i class="fa fa-plus"></i></button>
    </header>
    <fieldset>
        <div class="padding-10" >
            <?php
            if ($aIdioma) {
                #exclusão de array para o idioma inglês Tarefa #2880 - Apenas no cadastro
                $url = $_SERVER['REQUEST_URI'];
                if (strrpos($url, 'Atividade/form')) {
                    ?>
                    <input type="hidden" name="idiomaIngles" value="<?php echo $aIdioma['1']->getId(); ?>"/>
                    <?
                    unset($aIdioma['1']);
                }
                ?>
                <ul id="myTab2" class="nav nav-tabs bordered">
                    <?php
                    foreach ($aIdioma as $k => $oIdioma) {
                        $active = ($k == 0) ? 'active' : '';
                        $id_idioma = $oIdioma->getId();
                        ?>
                        <li class="<?php echo $active ?>">
                            <a style="color: #000!important" href="#aba-idioma-coluna-<?php echo $oIdioma->getId() ?>" data-toggle="tab">
                                <?php echo $oIdioma->getSigla() ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <div id="myTabContent2" class="tab-content padding-10">
                    <?php
                    $titulo = $descricao = "";
                    foreach ($aIdioma as $k => $oIdioma) {
                        $active = ($k == 0) ? 'active' : '';
                        $id_idioma = $oIdioma->getId();
                        ?>
                        <div class="tab-pane fade in <?php echo $active ?>" id="aba-idioma-coluna-<?php echo $oIdioma->getId() ?>">
                            <div class="atividade-coluna">
                                <div class="Atividade-coluna-append">
                                    <?php
                                    $aColuna = $response->get("aColuna");
                                    if ($aColuna) {
                                        $nCount = 0;
                                        foreach ($aColuna[$id_idioma] as $id_coluna => $oColuna) {
                                            $nCount++;
                                            include("Atividade.REL.model.php");
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            ?>
        </div>
    </fieldset>
</div>
<br/>