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
          <title>Esborrar Usuari</title>
    </head>

    <body>

                        <a href="http://zend-ormaba/ldap/menu.php"> Tornar a inici </a></br>

                        <a href="http://zend-ormaba/ldap/logout.php">Tancar Sessió </a></br>
 

            <?php
            if ($_POST['method'] == "DELETE") {
                if ($_POST['usr'] && $_POST['ou']) {

                    $uid = $_POST['usr'];
                    $unorg = $_POST['ou'];
                    $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';

                    $opcions = [
                        'host' => 'zend-ormaba',
                        'username' => 'cn=admin,dc=fjeclot,dc=net',
                        'password' => 'fjeclot',
                        'bindRequiresDn' => true,
                        'accountDomainName' => 'fjeclot.net',
                        'baseDn' => 'dc=fjeclot,dc=net',
                    ];

                    $ldap = new Ldap($opcions);
                    $ldap->bind();
                    $isEsborrat = false;
                    try {
                        if ($ldap->delete($dn)) echo "<b>Entrada esborrada</b><br>";
                    } catch (Exception $e) {
                        echo "<b>Error, Aquesta entrada no existeix</b><br>";
                    }
                }
            } else {
            ?>

                        <form action="http://zend-ormaba/ldap/formEsborrar.php" method="POST" autocomplete="off">
                            <h5>Esborrar Usuari</h5>
                            <input type="text" name="method" value="DELETE" class="hidden">
                            <input type="text" name="ou" placeholder="Unitat Organitzativa" required />
                            <input type="text" name="usr" placeholder="Usuari" required />
                            <input type="submit" class="button" value="Esborrar Usuari" />
                            <input type="reset" class="button" value="Neteja Formulari" />
                        </form>
                        <?php
            }
            ?>
    </body>
    </html>
