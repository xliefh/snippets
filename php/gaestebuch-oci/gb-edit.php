<html lang="de">
<head>
    <title>G&auml;stebuch</title>
</head>
<body>
    <h1>G&auml;stebuch</h1>
    <?php
        $Name = '';
        $Email = '';
        $Ueberschrift = '';
        $Kommentar = '';
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            if ($db = oci_connect('Benutzer', 'Passwort', 'orcl'))
            {
                if (isset($_POST['Name']) &&
                    isset($_POST['Email']) &&
                    isset($_POST['Ueberschrift']) &&
                    isset($_POST['Kommentar']))
                    {
                        $sql = 'UPDATE gaestebuch SET ueberschrift=:Ueberschrift, eintrag=:Kommentar, autor=:Name, email=:Email WHERE id=:id';
                        $kommando = oci_parse($db, $sql);
                        oci_bind_by_name($kommando, ':Ueberschrift', $_POST['Ueberschrift']);
                        oci_bind_by_name($kommando, ':Kommentar', $_POST['Kommentar']);
                        oci_bind_by_name($kommando, ':Name', $_POST['Name']);
                        oci_bind_by_name($kommando, ':Email', $_POST['Email']);
                        oci_bind_by_name($kommando, ':id', $_POST['id']);
                        if (oci_execute($kommando))
                        {
                            echo '<p>Eintrag ge&auml;ndert.</p><p><a href=\"gb-admin.php\">Zur&uuml;ck zur &Uuml;bersicht</a></p>';
                        }
                        else
                        {
                            echo 'Fehler!';
                        }
                    }
                    $sql = 'SELECT * FROM gaestebuch WHERE id=:id';
                    $kommando = oci_parse($db, $sql);
            }
        }
</body>
</html>