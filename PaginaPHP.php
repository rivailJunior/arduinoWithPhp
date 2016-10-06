<?php

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Se conecta ao IP e Porta:
socket_connect($sock, "10.0.0.177", 80);

// Executa a ação correspondente ao botão apertado.
if (isset($_POST['bits'])) {
    $msg = $_POST['bits'];
    if (isset($_POST['Fora'])) {
        if ($msg[0] == '1') {
            $msg[0] = '0';
        } else {
            $msg[0] = '1';
        }
    }
    if (isset($_POST['Quarto1'])) {
        if ($msg[1] == '1') {
            $msg[1] = '0';
        } else {
            $msg[1] = '1';
        }
    }
    if (isset($_POST['Quarto2'])) {
        if ($msg[2] == '1') {
            $msg[2] = '0';
        } else {
            $msg[2] = '1';
        }
    }
    if (isset($_POST['Sala'])) {
        if ($msg[3] == '1') {
            $msg[3] = '0';
        } else {
            $msg[3] = '1';
        }
    }
    if (isset($_POST['Pequeno'])) {
        $msg = 'P#';
    }
    if (isset($_POST['Grande'])) {
        $msg = 'G#';
    }
    socket_write($sock, $msg, strlen($msg));
}

socket_write($sock, 'R#', 2); 
//Requisita o status do sistema.

// Espera e lê o status e define a cor dos botões de acordo.
$status = socket_read($sock, 6);

if (($status[4] == 'L') && ($status[5] == '#')) {
    if ($status[0] == '0'){
        $cor1 = "lightcoral";
    } else {
        $cor1 = "lightgreen";
    }
    if ($status[1] == '0'){
        $cor2 = "lightcoral";
    } else {
        $cor2 = "lightgreen";
    }
    if ($status[2] == '0'){
        $cor3 = "lightcoral";
    } else {
        $cor3 = "lightgreen";
    }
    if ($status[3] == '0'){
        $cor4 = "lightcoral";
    } else {
        $cor4 = "lightgreen";
    }
    
    ?>
<html>
<head></head>
<body>
    <form method="post" action="PaginaPHP.php">
        <input type="hidden" name="bits" value="<?php echo $status;?>">
        <br>
        <button type ="submit" name="Fora" style="width:70; background-color: <?php echo $cor1; ?>; font: bold 14px Arial">RELE 1
        </button>
        </br>
        <button type="submit" name="Quarto1" style="width:70; background-color:<?php echo $cor2; ?>; font: bold 14px Arial"> RELE 2
        </button>
        </br>
        <button type="submit" name="Quarto2" style="width:70; background-color: <?php echo $cor3; ?>;font: bold 14px Arial">RELE 3
        </button>
        </br>
    </form>
</body>
</html>

    <?php
}
// Caso ele não receba o status corretamente, avisa erro.
else {
    echo "Falha ao receber status da casa.";
}
socket_close($sock);
?>
 
