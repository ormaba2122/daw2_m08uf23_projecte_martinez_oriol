<?php
require 'vendor/autoload.php';

use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

session_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar Usuari</title>
    </head>

    <body>

 
                        <a  href="http://zend-ormaba/ldap/menu.php"> Tornar a inici </a></br>
 
                        <a  href="http://zend-ormaba/ldap/logout.php"> Tancar Sessió </a></br>

            <?php
            if ($_POST['method'] == "PUT") {
                if ($_POST['uid'] && $_POST['ou'] && $_POST['radioValue'] && $_POST['nouContingut']) {

                    $atribut = $_POST['radioValue'];
                    $nou_contingut = $_POST['nouContingut'];

                    $uid = $_POST['uid'];
                    $ou = $_POST['ou'];
                    $dn = 'uid=' . $uid . ',ou=' . $ou . ',dc=fjeclot,dc=net';

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
                    $entrada = $ldap->getEntry($dn);
                    if ($entrada) {
                        Attribute::setAttribute($entrada, $atribut, $nou_contingut);
                        $isModificat = true;
                        $ldap->update($dn, $entrada);
                        echo "Atribut modificat correctament<br />";
                    } else {
                        echo "<b>Aquesta entrada no existeix</b><br />";
                    }
                }
            } else {
            ?>

                        <form action="http://zend-ormaba/ldap/formModificar.php" method="POST" autocomplete="off">
                            <h5>Modificar Usuari</h5>
                            <input type="text" name="method" value="PUT" class="hidden">
                            <input type="text" name="ou" placeholder="Unitat Organitzativa" required />
                            <input type="text" name="uid" placeholder="Usuari" required />
                            <input type="radio" name="radioValue" value="uidNumber" /><span class="formLabel">UID Number</span>
                            <input type="radio" name="radioValue" value="gidNumber" /><span class="formLabel">GID Number</span>
                            <input type="radio" name="radioValue" value="homeDirectory" /><span class="formLabel">Directori Personal</span>
                            <input type="radio" name="radioValue" value="loginShell" /><span class="formLabel">Shell</span>
                            <input type="radio" name="radioValue" value="cn" /><span class="formLabel">CN</span>
                            <input type="radio" name="radioValue" value="sn" /><span class="formLabel">SN</span>
                            <input type="radio" name="radioValue" value="givenName" /><span class="formLabel">Given Name</span>
                            <input type="radio" name="radioValue" value="postalAddress" /><span class="formLabel">Adreça Postal</span>
                            <input type="radio" name="radioValue" value="mobile" /><span class="formLabel">Mòbil</span></div>
                            <input type="radio" name="radioValue" value="telephoneNumber" /><span class="formLabel">Telèfon Fixe</span>
                            <input type="radio" name="radioValue" value="title" /><span class="formLabel">Títol</span>
                            <input type="radio" name="radioValue" value="description" /><span class="formLabel">Descripció</span>
                            <input type="text" name="nouContingut" placeholder="Nou Contingut" required />
                            <input type="submit" class="button" value="Modificar Usuari" />
                            <input type="reset" class="button" value="Neteja Formulari" />
                        </form>
                        <?php
            }
            ?>
                    
    </body>

    </html>

