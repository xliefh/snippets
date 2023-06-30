<?php
/** THIS IS A SAMPLE CODE FILE, NO WORKING CODE */
/** Assuming you have established a database connection */
/**
 *  CREATE TABLE EXAMPLE_USERS (
 *    UID NUMBER,
 *    UID_SUPP NUMBER,
 *    CREATION TIMESTAMP,
 *    LASTCHANGE TIMESTAMP,
 *    STATUS NUMBER,
 *    CONSTRAINT PK_EXAMPLE_USERS PRIMARY KEY (UID, UID_SUPP)
 *  );
 */
//switch for oracle merge
$useMerge = true;

$uid = 123; 
$uidSupp = 456;
$creation = date('Y-m-d H:i:s');
$lastChange = $creation;
$status = 1;

$sql = "SELECT COUNT(*) AS count FROM EXAMPLE_USERS WHERE UID = :uid AND UID_SUPP = :uidSupp AND STATUS = 9999";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $uid);
$stmt->bindParam(':uidSupp', $uidSupp);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $row['count'];

if( $count > 0 ) {
    $sql = "UPDATE EXAMPLE_USERS eu SET eu.CREATION = :creation, eu.LASTCHANGE = :lastChange, eu.STATUS = :status WHERE eu.UID = :uid AND eu.UID_SUPP = :uidSupp";
} else {
    $sql = "INSERT INTO EXAMPLE_USERS (UID, UID_SUPP, CREATION, LASTCHANGE, STATUS) VALUES (:uid, :uidSupp, :creation, :lastChange, :status)";
}
//combined in oracle:
if( $useMerge )
{
    $sql = "MERGE INTO EXAMPLE_USERS eu USING
                (SELECT :uid AS uid, :uidSupp AS uidSupp FROM dual) src
                    ON (eu.UID = src.uid AND eu.UID_SUPP = src.uidSupp)
                    WHEN MATCHED THEN
                        UPDATE SET eu.CREATION = :creation, eu.LASTCHANGE = :lastChange, eu.STATUS = :status
                    WHEN NOT MATCHED THEN
                        INSERT (UID, UID_SUPP, CREATION, LASTCHANGE, STATUS)
                            VALUES (:uid, :uidSupp, :creation, :lastChange, :status)";
}

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $uid);
$stmt->bindParam(':uidSupp', $uidSupp);
$stmt->bindParam(':creation', $creation);
$stmt->bindParam(':lastChange', $lastChange);
$stmt->bindParam(':status', $status);
$stmt->execute();

if( $stmt->rowCount() > 0 )
{
    echo "Row inserted or updated successfully.";
}
else
{
    echo "Failed to insert or update the row.";
}