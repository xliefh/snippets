<?php
if ($db = oci_connect('Benutzer', 'Password', 'orcl'))
{
    $sql = 
    'CREATE TABLE gaestebuch (
        id NUMBER(10) PRIMARY KEY,
        ueberschrift VARCHAR2(1000),
        eintrag VARCHAR2(5000),
        autor VARCHAR2(50),
        email VARCHAR2(100),
        datum NUMBER(20) PRIMARY KEY);
        CREATE SEQUENCE gaestebuch_id;
        CREATE TRIGGER gaestebuch_autoincrement
            BEFORE INSERT ON gaestebuch
            REFERENCING NEW AS NEW OLD AS OLD FOR EACH ROW
            BEGIN
                SELECT gaestebuch_id.NEXTVAL INTO :NEW.id FROM DUAL;
            END';
    $kommando = oci_parse($db, $sql);
    if (oci_execute($kommando)) {
        echo 'Tabelle angelet.<br />';
    }
    else {
        echo 'Fehler!';
    }
    oci_close($db);
}
else {
    echo 'Fehler!';
}
?>