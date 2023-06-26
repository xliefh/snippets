<html lang="de">
<head>
    <title>G&auml;stebuch</title>
</head>
<body>
    <h1>G&auml;stebuch</h1>
    <?php
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $sql = 'DELETE FROM gaestebuch WHERE id=:id';
            $kommando = oci_parse($db, $sql);
            oci_bind_by_name($kommando, ':id', intval($_GET['id']));

            if (oci_execute($kommando))
            {
                echo '<p>Eintrag gel&ouml;scht.</p>
                    	<p><a href=\"gb-admin.php\">Zur&uuml;ck zur &Uuml;bersicht</a></p>';
            }
            else
            {
                echo 'Fehler!';
            }
            oci_close($db);
        }
        else
        {
            asdf
        }
</body>
</html>