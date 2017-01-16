<?php

require_once "DBInit.php";

class ItemDB {

    public static function getForIds($ids) {
        $db = DBInit::getInstance();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));

        $statement = $db->prepare("SELECT * FROM ARTIKEL
            WHERE SIFRA_ARTIKLA IN (" . $id_placeholders . ")");
        $statement->execute($ids);

        return $statement->fetchAll();
    }

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM ARTIKEL");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM ARTIKEL 
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

    public static function insert($sifra, $idskupine, $naziv, $cena, $proizvajalec, $enota, $opis, $url) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO ARTIKEL (SIFRA_ARTIKLA, ID_SKUPINE,  NAZIV_ARTIKLA, CENA, PROIZVAJALEC, ENOTA_MER, OPIS)
            VALUES (:sifra, :idskupine, :naziv, :cena, :proizvajalec, :enota, :opis)");
        $statement->bindParam(":sifra", $sifra);
        $statement->bindParam(":idskupine", $idskupine);
        $statement->bindParam(":naziv", $naziv);
        $statement->bindParam(":cena", $cena);
        $statement->bindParam(":proizvajalec", $proizvajalec);
        $statement->bindParam(":enota", $enota);
        $statement->bindParam(":opis", $opis);
        $statement->execute();

        $db = DBInit::getInstance();

        $statement1 = $db->prepare("INSERT INTO SLIKA VALUES (:id, :sifra, 'AAAAA', :url)");
        $statement1->bindParam(":id", $sifra);
        $statement1->bindParam(":sifra", $sifra);
        $statement1->bindParam(":url", $url);
        $statement1->execute();
    }

    public static function update($sifra, $idskupine, $naziv, $cena, $proizvajalec, $enota, $opis) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE ARTIKEL
        SET
          ID_SKUPINE = :idskupine,
          NAZIV_ARTIKLA = :naziv,
          CENA = :cena,
          PROIZVAJALEC = :proizvajalec,
          ENOTA_MER = :enota,
          OPIS = :opis
        WHERE SIFRA_ARTIKLA = :id");
        $statement->bindParam(":idskupine", $idskupine);
        $statement->bindParam(":naziv", $naziv);
        $statement->bindParam(":cena", $cena);
        $statement->bindParam(":proizvajalec", $proizvajalec);
        $statement->bindParam(":enota", $enota);
        $statement->bindParam(":opis", $opis);
        $statement->bindParam(":id", $sifra, PDO::PARAM_INT);
        $statement->execute();

    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement1 = $db->prepare("DELETE FROM SLIKA WHERE SIFRA_ARTIKLA = :id");
        $statement1->bindParam(":id", $id, PDO::PARAM_INT);
        $statement1->execute();

        $statement = $db->prepare("DELETE FROM ARTIKEL WHERE SIFRA_ARTIKLA = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function search($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM ARTIKEL 
            WHERE naziv LIKE :query OR proizvajalec LIKE :query");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();

        return $statement->fetchAll();
    }
    /*   public static function getPiture($id){
           $db = DBInit::getInstance();

           $statement = $db->prepare("SELECT * FROM slika WHERE SIFRA_ARTIKLA = :id");
           $statement->bindParam(":id", $id, PDO::PARAM_INT);
           $statement->execute();
            if ($statement != null) {
               return $statement->fetch();
            }
            else{
                return "No ";
            }
       }*/
}