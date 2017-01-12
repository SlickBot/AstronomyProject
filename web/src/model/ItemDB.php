<?php

require_once "DBInit.php";

class ItemDB {

    public static function getForIds($ids) {
        $db = DBInit::getInstance();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));

        $statement = $db->prepare("SELECT * FROM artikel
            WHERE SIFRA_ARTIKLA IN (" . $id_placeholders . ")");
        $statement->execute($ids);

        return $statement->fetchAll();
    }

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM artikel");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM artikel 
            WHERE SIFRA_ARTIKLA = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $item = $statement->fetch();

        if ($item != null) {
            return $item;
        } else {
            throw new InvalidArgumentException("Ni artikla z šifro $id");
        }
    }

    public static function insert($sifra, $idskupine, $idnarocila, $naziv, $cena, $proizvajalec, $enota) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO artikel (SIFRA_ARTIKLA, ID_SKUPINE, ID_NAROCILA, NAZIV_ARTIKLA, CENA, PROIZVAJALEC, ENOTA_MER)
            VALUES (:sifra, :idskupine, :idnarocila, :naziv, :cena, :proizvajalec, :enota)");
        $statement->bindParam(":sifra", $sifra);
        $statement->bindParam(":idskupine", $idskupine);
        $statement->bindParam(":idnarocila", $idnarocila);
        $statement->bindParam(":naziv", $naziv);
         $statement->bindParam(":cena", $cena);
        $statement->bindParam(":proizvajalec", $proizvajalec);
        $statement->bindParam(":enota", $enota);
        $statement->execute();
    }

    public static function update($sifra, $idskupine, $idnarocila, $naziv, $cena, $proizvajalec, $enota) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE artikel SET ID_SKUPINE = :idskupine,
            ID_NAROCILA = :idnarocila, NAZIV_ARTIKLA = :naziv, CENA = :cena, PROIZVAJALEC = :proizvajalec, ENOTA_MER = :enota WHERE SIFRA_ARTIKLA = :id");
        $statement->bindParam(":idskupine", $idskupine);
        $statement->bindParam(":idnarocila", $idnarocila);
        $statement->bindParam(":naziv", $naziv);
        $statement->bindParam(":cena", $cena);
        $statement->bindParam(":proizvajalec", $proizvajalec);
        $statement->bindParam(":enota", $enota);
        $statement->bindParam(":id", $sifra, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM artikel WHERE SIFRA_ARTIKLA = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }    

    public static function search($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM artikel 
            WHERE naziv LIKE :query OR proizvajalec LIKE :query");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getPicture($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT slika.POT_SLIKE FROM slika, artikel WHERE slika.SIFRA_ARTIKLA = artikel.SIFRA_ARTIKLA "
                . "and artikel.SIFRA_ARTIKLA = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
         if ($statement != null) {
            return $statement;
         }
    }
}
