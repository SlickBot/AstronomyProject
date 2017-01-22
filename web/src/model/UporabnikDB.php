<?php

require_once "DBInit.php";

class UporabnikDB {

    public static function update($sifra, $idskupine, $naziv, $cena, $proizvajalec, $enota, $opis) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE UPORABNIK SET ID_SKUPINE = :idskupine,
             NAZIV_ARTIKLA = :naziv, CENA = :cena, PROIZVAJALEC = :proizvajalec, ENOTA_MER = :enota,
            OPIS = :opis WHERE SIFRA_ARTIKLA = :id");
        $statement->bindParam(":idskupine", $idskupine);
        $statement->bindParam(":naziv", $naziv);
        $statement->bindParam(":cena", $cena);
        $statement->bindParam(":proizvajalec", $proizvajalec);
        $statement->bindParam(":enota", $enota);
        $statement->bindParam(":opis", $opis);
        $statement->bindParam(":id", $sifra, PDO::PARAM_INT);
        $statement->execute();
    }

}
