<?php
// echo print_r($_GET);
if ($_GET['file'] == "telas/pendencias.php")
{
   $color["pendencia"] = "background-color: #ddd;";
}
elseif($_GET['file'] == "telas/solicitarCadastro.php")
{
   $color["solicitar"] = "background-color: #ddd;";
}
elseif($_GET['file'] == "telas/acompanharSolicitacao.php")
{
   $color["acompanhar"] = "background-color: #ddd;";
}
// elseif($_GET['file'] == "telas/gerenciarSolicitacao.php")
// {
//    $color["gerenciar"] = "background-color: #ddd;";
// }


echo "<div class='vertical-menu col-2'>";
echo "   <a href='#' class='active'>Menu</a>";
echo "   <a style='".$color["solicitar"]."' href='index.php?file=telas/solicitarCadastro.php'>Solicitar Cadastro</a>";
echo "   <a style='".$color["acompanhar"]."' href='index.php?file=telas/acompanharSolicitacao.php'>Acompanhar Solicitações</a>";
// echo "   <a style='".$color["gerenciar"]."' href='index.php?file=telas/gerenciarSolicitacao.php'>Gerenciar Solicitaï¿½ï¿½es</a>";
echo "   <a style='".$color["gerenciar"]."' href='index.php?file=telas/gerenciarSolicitacao.php'>Dados Contabeis</a>";
echo "   <a style='".$color["gerenciar"]."' href='index.php?file=telas/gerenciarSolicitacao.php'>Dados Financeiros</a>";
echo "   <a style='".$color["pendencia"]."' href='index.php?file=telas/pendencias.php'>Pendencias</a>";
echo "</div>";