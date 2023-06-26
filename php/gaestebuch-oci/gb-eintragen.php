<html>
<head>
    <title>G&auml;stebuch</title>
</head>
<body>
    <h1>G&auml;stebuch</h1>
    <?php
        if (isset($_POST['Name']) &&
            isset($_POST['Email']) &&
            isset($_POST['Ueberschrift']) &&
            isset($_POST['Kommentar'])) {
                if ($db = oci_connect('Benutzer', 'Passwort', 'orcl')) {
                    $sql = 'INSERT INTO gaestebuch
                        (ueberschrift,
                         eintrag,
                         autor,
                         email,
                         datum)
                        VALUES (:Ueberschrift, :Kommentar, :Name, :Email, :Datum)';
                    $kommando = oci_parse($db, $sql);
                    oci_bind_by_name($kommando, ':Ueberschrift', $_POST['Ueberschrift']);
                    oci_bind_by_name($kommando, ':Kommentar', $_POST['Kommentar']);
                    oci_bind_by_name($kommando, ':Name', $_POST['Name']);
                    oci_bind_by_name($kommando, ':Email', $_POST['Email']);
                    oci_bind_by_name($kommando, ':Datum', $_POST['Datum']);
                    if (oci_execute($kommando, OCI_DEFAULT)) {
                        $sql_id = 'SELECT gaestebuch_id.CURRVAL AS id FROM DUAL';
                        $kommando_id = oci_parse($db, $sql_id);
                        if (oci_execute($kommando_id, OCI_DEFAULT)) {
                            oci_fetch($kommando_id);
                            $id = oci_result($kommando_id, 'id');
                        }
                        else {
                            $id = '';
                            echo 'Fehler!';
                        }
                        echo 'Eintrag hinzugef&uuml;gt.<a href=\"gb-admin=id=\">Bearbeiten</a>';
                    }
                    else {
                        echo 'Fehler!';
                    }
                    oci_commit($db);
                    oci_close($db);
                }
                else {
                    echo 'Fehler!';
                }
            }
            ?>
    <form method="post">
        Name <input type="text" name="Name" /><br />
        E-Mail-Adresse <input type="text" name="Email" /><br />
        &Uuml;berschrift <input type="text" name="Ueberschrift" /><br />
        Kommentar
        <textarea cols="70" rows="10" name="Kommentar"></textarea><br />
        <input type="submit" name="Submit" value="Eintragen" />
    </form>
</body>
</html>