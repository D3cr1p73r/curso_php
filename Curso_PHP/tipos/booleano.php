<div class="titulo">Tipo Boolean</div>
<?php
    echo TRUE;
    echo '<br>';
    echo FALSE;

    echo '<br>' . var_dump(true);
    echo '<br>' . var_dump(false);
    echo '<br>' . var_dump('false');
    echo '<br>' . is_bool(false);
    echo '<br>' . is_bool('false'); #verificar se é booleano

    #conversões
    echo '<p>Regras</p>';
    echo '<br>';
    echo '<br>'.var_dump((bool)0); //apenas 0 é false
    echo '<br>'.var_dump((bool)20); //apenas 0 é false
    echo '<br>'.var_dump((bool)-1); //apenas 0 é false

?>