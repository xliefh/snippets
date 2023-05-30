<!doctype html>
<html lang="de">
    <head>
        <title>GOOD FORM!</title>
        <meta charset="utf-8"/>
        <meta name="description" content="A solid web form that is validated and the user is helped via hints if the validation fails."/>
    </head>
    <body>
        <?php
            $Anrede = (isset($_POST["Anrede"]) && is_string($_POST["Anrede"])) ? $_POST["Anrede"] : "";
            $Vorname = (isset($_POST["Vorname"]) && is_string($_POST["Vorname"])) ? $_POST["Vorname"] : "";
            $Nachname = (isset($_POST["Nachname"]) && is_string($_POST["Nachname"])) ? $_POST["Nachname"] : "";
            $Email = (isset($_POST["Email"]) && is_string($_POST["Email"])) ? $_POST["Email"] : "";
            $Anzahl = (isset($_POST["Anzahl"]) && is_string($_POST["Anzahl"])) ? $_POST["Anzahl"] : "";
            $Promo = (isset($_POST["Promo"]) && is_string($_POST["Promo"])) ? $_POST["Promo"] : "";

            $Sektion = (isset($_POST["Sektion"]) && is_array($_POST["Sektion"])) ? $_POST["Sektion"] : array();

            $Kommentare = (isset($_POST["Kommentare"]) && is_string($_POST["Kommentare"])) ? $_POST["Kommentare"] : "";
            $AGB = (isset($_POST["AGB"]) && is_string($_POST["AGB"])) ? $_POST["AGB"] : "";

            $ok = false;
            $fehlerfelder = array();
            if (isset($_POST["Submit"]))
            {
                $ok = true;
                if (!isset($_POST["Anrede"]) || !is_string($_POST["Anrede"]))
                {
                    $ok = false;
                    $fehlerfelder[] = "Anrede";
                }
                if (!isset($_POST["Vorname"]) || !is_string($_POST["Vorname"]) ||
                    trim($_POST["Vorname"] == ""))
                {
                    $ok = false;
                    $fehlerfelder[] = "Vorname";
                }
                if (!isset($_POST["Nachname"]) || !is_string($_POST["Nachname"]) ||
                    trim($_POST["Nachname"] == ""))
                {
                    $ok = false;
                    $fehlerfelder[] = "Nachname";
                }
                if (!isset($_POST["Email"]) || trim($_POST["Email"]) == "" ||
                    !preg_match('/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,6}$/', $_POST["Email"]))
                {
                    $ok = false;
                    $fehlerfelder[] = "Email";
                }
                if (!isset($_POST["Promo"]) || !is_string($_POST["Promo"]) || trim($_POST["Promo"]) == "")
                {
                    $ok = false;
                    $fehlerfelder[] = "Promo";
                }
                if (!isset($_POST["Anzahl"]) || !is_string($_POST["Anzahl"]) || $_POST["Anzahl"] == "0")
                {
                    $ok = false;
                    $fehlerfelder[] = "Anzahl Karten";
                }
                if (!isset($_POST["Sektion"]) || !is_array($_POST["Sektion"]))
                {
                    $ok = false;
                    $fehlerfelder[] = "Sektion";
                }
                if (!isset($_POST["Kommentare"]) || !is_string($_POST["Kommentare"])
                    || trim($_POST["Kommentare"]) == "")
                {
                    $ok = false;
                    $fehlerfelder[] = "Kommentare";
                }
                if (!isset($_POST["AGB"]) || !is_string($_POST["AGB"]))
                {
                    $ok = false;
                    $fehlerfelder[] = "AGB";
                }

                if ($ok)
                {
                ?>
                <h1>Formulardaten</h1>
                <?php
                    $Anrede = htmlspecialchars($Anrede);
                    $Vorname = htmlspecialchars($Vorname);
                    $Nachname = htmlspecialchars($Nachname);
                    $Email = htmlspecialchars($Email);
                    $Anzahl = htmlspecialchars($Anzahl);
                    $Promo = htmlspecialchars($Promo);

                    $Sektion = htmlspecialchars(implode(" ", $Sektion));

                    $Kommentare = nl2br(htmlspecialchars($Kommentare));

                    $AGB = htmlspecialchars($AGB);

                    echo "<b>Anrede:</b> $Anrede<br/>";
                    echo "<b>Vorname:</b> $Vorname<br/>";
                    echo "<b>Nachname:</b> $Nachname<br/>";
                    echo "<b>E-Mail:</b> $Email<br/>";
                    echo "<b>Promo:</b> $Promo<br/>";
                    echo "<b>Anzahl Karten::</b> $Anzahl<br/>";
                    echo "<b>Sektion:</b> $Sektion<br/>";
                    echo "<b>Kommentare:</b> $Kommentare<br/>";
                    echo "<b>AGB:</b> $AGB<br/>";
                } else {
                    echo "<p><b>Formulare unvollst&auml;ndig</b></p>";
                    echo "<ul><li>";
                    echo implode("</li><li>", $fehlerfelder);
                    echo "</li></ul>";
                }
            }
            if (!$ok)
            {
            ?>
            <h1>Ticketservice</h1>
                <form method="post"> <!-- Attribut action="localhost:8080/good-form.php"
                        nicht nötig, browser nutzt automatisch die Adresse, wo das Formular liegt -->
                    <input type="radio" name="Anrede" value="Hr."<?php
                    if ($Anrede == "Hr.")
                    {
                        echo "checked=\"checked\" ";
                    }
                    ?>/>Herr
                    <input type="radio" name="Anrede" value="Fr."<?php
                    if ($Anrede == "Fr.")
                    {
                        echo "checked=\"checked\" ";
                    }
                    ?>/>Frau <br />
                    Vorname <input type="text" name="Vorname" value="<?php
                        echo htmlspecialchars($Vorname);
                    ?>" /><br/>
                    Nachname <input type="text" name="Nachname" value="<?php
                        echo htmlspecialchars($Nachname);
                    ?>" /><br />
                    E-Mail Adresse <input type="text" name="Email" value="<?php
                        echo htmlspecialchars($Email);
                    ?>"/><br />
                    Promo-Code <input type="password" name="Promo" value="<?php
                        echo htmlspecialchars($Promo);
                    ?>"/><br />
                    Anzahl Karten
                    <select name="Anzahl">
                        <option value="0">Bitte w&auml;hlen</option>
                        <option value="1"<?php
                            if ($Anzahl == "1")
                            {
                                echo " selected=\"selected\"";
                            }
                        ?>>1</option>
                        <option value="2"<?php
                            if ($Anzahl == "2")
                            {
                                echo " selected=\"selected\"";
                            }
                        ?>>2</option>
                        <option value="3"<?php
                            if ($Anzahl == "3")
                            {
                                echo " selected=\"selected\"";
                            }
                        ?>>3</option>
                        <option value="4"<?php
                            if ($Anzahl == "4")
                            {
                                echo " selected=\"selected\"";
                            }
                        ?>>4</option>
                    </select><br />
                    Gew&uuml;nschte Sektion im Stadion
                    <select name="Sektion[]" size="4" multiple="multiple">
                        <option value="nord"<?php
                            if (in_array("nord", $Sektion)) {
                                echo " selected=\"selected\"";
                            }
                        ?>>Nordkurve</option>
                        <option value="sued"<?php
                            if (in_array("sued", $Sektion)) {
                                echo " selected=\"selected\"";
                            }
                        ?>>S&uuml;dkurve</option>
                        <option value="haupt"<?php
                            if (in_array("haupt", $Sektion)) {
                                echo " selected=\"selected\"";
                            }
                        ?>>Haupttrib&uuml;ne</option>
                        <option value="gegen"<?php
                            if (in_array("gegen", $Sektion)) {
                                echo " selected=\"selected\"";
                            }
                        ?>>Gegentrib&uuml;ne</option>
                    </select><br />
                    Kommentare/Anmerkungen
                    <textarea cols="70" rows="10" name="Kommentare"><?php
                        echo htmlspecialchars($Kommentare);
                    ?></textarea><br />
                    <input type="checkbox" name="AGB" value="ok" <?php
                        if ($AGB != "")
                        {
                            echo "checked=\"checked\" ";
                        }
                    ?>/>
                    Ich akzeptiere die AGB.<br />
                    <input type="submit" name="Submit" value="Bestellung aufgeben" />
                </form>
                <?php
                }
            ?>
    </body>
</html>