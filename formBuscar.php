<?php
require 'vendor/autoload.php';

use Laminas\Ldap\Ldap;

session_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cerca d'Usuaris</title>
    </head>

    <body>

                        <a class="nav-link" href="http://zend-ormaba/ldap/menu.php">Tornar a inici </a></br>

                        <a class="nav-link" href="http://zend-ormaba/ldap/logout.php"> Tancar Sessió </a></br>

            <?php
            if ($_GET['usr'] && $_GET['ou']) {
                $domini = 'dc=fjeclot,dc=net';
                $opcions = [
                    'host' => 'zend-ormaba',
                    'username' => "cn=admin,$domini",
                    'password' => 'fjeclot',
                    'bindRequiresDn' => true,
                    'accountDomainName' => 'fjeclot.net',
                    'baseDn' => 'dc=fjeclot,dc=net',
                ];
                $ldap = new Ldap($opcions);
                $ldap->bind();
                $entrada = 'uid=' . $_GET['usr'] . ',ou=' . $_GET['ou'] . ',dc=fjeclot,dc=net';
                $usuari = $ldap->getEntry($entrada);

                echo '<table>
            <thead>
                <tr>
                    <th>' . $usuari["dn"] . '</th>
                </tr>
                <tr>
                    <th>Atribut</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>';
            try{
                foreach ($usuari as $atribut => $dada) {
                    if ($atribut != "dn") {
                        //echo $atribut . ": " . $dada[0] . '<br>';
                        echo '<tr>
                    <th scope="row">' . $atribut . '</th>
                    <td>' . $dada[0] . '</td>
                </tr>';
                    }
                }}
                catch (Exception $e) {
                        echo "<b>Error, Aquesta entrada no existeix</b><br>";
                    }
                echo "</tbody>
        </table>";
            } else {
            ?>
                        <form action="http://zend-ormaba/ldap/formBuscar.php" method="GET" autocomplete="off">
                            <h5>Cercar Usuari</h5>
                            <input type="text" name="ou" placeholder="Unitat Organitzativa" required />
                            <input type="text" name="usr" placeholder="Usuari" required />
                            <input type="submit" class="button" value="Cercar Usuari" />
                            <input type="reset" class="button" value="Neteja Formulari" />
                        </form>
            <?php
            }
            ?>
    </body>

    </html>

