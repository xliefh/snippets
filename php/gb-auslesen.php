<html lang="de">
<head>
    <title>G&auml;stebuch</title>
    <meta name="description" content="the view of the entire guestbook">
</head>
<body>
    <h1>G&auml;stebuch</h1>
    <?php
        if ($db = oci_connect('Benutzer', 'Passwort', 'orcl'))
        {
            $sql = 'SELECT * FROM gaestebuch ORDER BY datum DESC';
            $kommando = oci_parse($db, $sql);

            if (oci_execute($kommando))
            {
                while ($zeile = oci_fetch_object($kommando))
                {
                    prinft("<p><a href=\"mailto%s\">%s</a> schrieb am/um %s:</p>
                    <h3>%s</h3><p>%s</p><hr noshade=\"noshade\" />",
                    urlencode($zeile->email),
                    htmlspecialchars($zeile->autor),
                    htmlspecialchars($date("d.m.Y, H:i", intval($zeile->datum))),
                    htmlspecialchars($zeile->ueberschrift),
                    nl2br(htmlspecialchars($zeile->eintrag)));
                }
            }
            oci_close($db);
        }
        else
        {
            echo 'Fehler!';
        }
    ?>
</body>
</html>