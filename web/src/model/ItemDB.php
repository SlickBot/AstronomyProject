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

    public static function getAllWithUrls() {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT a.SIFRA_ARTIKLA,
                                          a.ID_SKUPINE,
                                          a.NAZIV_ARTIKLA,
                                          a.CENA,
                                          a.PROIZVAJALEC,
                                          a.ENOTA_MER,
                                          a.OPIS,
                                          s.ID_SLIKE,
                                          s.IME_SLIKE,
                                          s.POT_SLIKE
                                    FROM  ARTIKEL a, SLIKA s
                                    WHERE a.SIFRA_ARTIKLA = s.SIFRA_ARTIKLA");
        $statement->execute();

        return $statement->fetchAll();
    }
    
    public static function authenticateCustomer($username, $hash) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT IME
                                   FROM  UPORABNIK u
                                   WHERE u.ELEKTRONSKI_NASLOV = :user
                                   AND   u.GESLO = :hash
                                   AND   u.TIP = 3");
        $statement->bindParam(":user", $username);
        $statement->bindParam(":hash", $hash);
        $statement->execute();
        
        $data = $statement->fetch();
        return isset($data["IME"]);
    }
    
    public static function getUser($username, $hash) {
        if (!ItemDB::authenticateCustomer($username, $hash)) {
            return FALSE;
        }
        
        $db = DBInit::getInstance();        
        
        $statement = $db->prepare("SELECT u.ID_UPORABNIK,
                                          u.TIP,
                                          u.IME,
                                          u.PRIIMEK,
                                          u.ELEKTRONSKI_NASLOV,
                                          u.TELEFONSKA_STEVILKA,
                                          u.NASLOV
                                    FROM  UPORABNIK u
                                    WHERE u.ELEKTRONSKI_NASLOV = :user");
        $statement->bindParam(":user", $username);
        $statement->execute();
        
        return $statement->fetch();
    }
    
    public static function setUser($username,
                                   $hash,
                                   $id,
                                   $name,
                                   $surname,
                                   $email,
                                   $phone,
                                   $address) {
        if (!ItemDB::authenticateCustomer($username, $hash)) {
            return NULL;
        } else {
            $db = DBInit::getInstance();

            $statement = $db->prepare(" UPDATE  UPORABNIK
                                        SET     IME = :name,
                                                PRIIMEK = :surname,
                                                ELEKTRONSKI_NASLOV = :email,
                                                TELEFONSKA_STEVILKA = :phone,
                                                NASLOV = :address
                                        WHERE   ID_UPORABNIK = :id
                                        AND     GESLO = :hash");
            $statement->bindParam(":name", $name);
            $statement->bindParam(":surname", $surname);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":phone", $phone);
            $statement->bindParam(":address", $address);
            $statement->bindParam(":id", $id);
            $statement->bindParam(":hash", $hash);
            
            $statement->execute();
            
            return $statement->rowCount() > 0;
        }        
    }
    
    public static function getPurchases($username, $hash) {
        if (!ItemDB::authenticateCustomer($username, $hash)) {
            return FALSE;
        }
        
        $purchasesIdWithQuantity = ItemDB::getPurchasesQuantity($username);
        $purchases = [];
        
        foreach ($purchasesIdWithQuantity as $item) {
            $db = DBInit::getInstance();
            
            $zap_st = $item["ZAPOREDNA_STEVILKA"];
            $data = ItemDB::getPurchasesDateAndID($zap_st);
            
            $purchases[] = ["ZAP_ST" => $zap_st, 
                            "DATUM_NAROCILA" => $data["DATUM_NAROCILA"],
                            "ID_UPORABNIK" => $data["ID_UPORABNIK"],
                            "TOTAL" => $item["TOTAL"]];
        }
        
        return $purchases;
    }
    
    private static function getPurchasesQuantity($username) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare(" SELECT  n.ZAPOREDNA_STEVILKA,
                                            SUM(n.KOLICINA_ARTIKLA) as TOTAL
                                    FROM    NAROCILO n,
                                            VSEBUJE v,
                                            ARTIKEL a,
                                            UPORABNIK u
                                    WHERE   n.ID_NAROCILA = v.ID_NAROCILA
                                      AND   a.SIFRA_ARTIKLA = v.SIFRA_ARTIKLA
                                      AND   n.ID_UPORABNIK = u.ID_UPORABNIK
                                      AND   u.ELEKTRONSKI_NASLOV = :user
                                    GROUP BY n.ZAPOREDNA_STEVILKA");
        $statement->bindParam(":user", $username);
        $statement->execute();
        
        return $statement->fetchAll();
    }
    
    private static function getPurchasesDateAndID($zap_st) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare(" SELECT  n.ID_UPORABNIK,
                                            n.DATUM_NAROCILA
                                    FROM    NAROCILO n
                                    WHERE   n.ZAPOREDNA_STEVILKA = :zap_st");
        $statement->bindParam(":zap_st", $zap_st);
        $statement->execute();
        
        return $statement->fetch();
    }
    
    public static function getPurchase($username, $hash, $zap_st) {
        if (!ItemDB::authenticateCustomer($username, $hash)) {
            return FALSE;
        }
        
        $db = DBInit::getInstance();
        
        $statement = $db->prepare(" SELECT  n.ZAPOREDNA_STEVILKA,
                                            n.KOLICINA_ARTIKLA,
                                            a.*,
                                            s.*
                                    FROM    NAROCILO n,
                                            ARTIKEL a,
                                            VSEBUJE v,
                                            SLIKA s,
                                            UPORABNIK u
                                    WHERE   a.SIFRA_ARTIKLA = v.SIFRA_ARTIKLA
                                    AND     v.ID_NAROCILA = n.ID_NAROCILA
                                    AND     a.SIFRA_ARTIKLA = s.SIFRA_ARTIKLA
                                    AND     n.ID_UPORABNIK = u.ID_UPORABNIK
                                    AND     u.ELEKTRONSKI_NASLOV = :user
                                    AND     n.ZAPOREDNA_STEVILKA = :zap_st");
        $statement->bindParam(":user", $username);
        $statement->bindParam(":zap_st", $zap_st);
        $statement->execute();
        
        return $statement->fetchAll();
    }
    
    public static function buy($username,
                               $hash,
                               $list) {
        $user = ItemDB::getUser($username, $hash);
        
        if (!$user) {
            return NULL;
        }
        
        $db = DBInit::getInstance();
        
        $stat1 = $db->prepare("SELECT MAX(ZAPOREDNA_STEVILKA) FROM NAROCILO");
        $stat1->execute();
        $zap_st_last = $stat1->fetch()["MAX(ZAPOREDNA_STEVILKA)"];
        
        if ($zap_st_last === NULL) {
            return FALSE;
        }
        
        foreach ($list as $item) {
            $db = DBInit::getInstance();
            
            $data = explode("|", $item);
        
            $stat0 = $db->prepare("SELECT MAX(ID_NAROCILA) FROM NAROCILO");
            $stat0->execute();
            $id_narocila_last = $stat0->fetch()["MAX(ID_NAROCILA)"];

            if ($id_narocila_last === NULL) {
                return FALSE;
            }
            
            $id_narocila = intval($id_narocila_last) + 1;
            $zap_st = intval($zap_st_last) + 1;
            $date = date('Y-m-d H:i:s');
            $status = 10;
            
            $statement = $db->prepare(" INSERT INTO NAROCILO
                                       (ID_NAROCILA,
                                        ID_UPORABNIK,
                                        DATUM_NAROCILA,
                                        STATUS_NAROCILA,
                                        ZAPOREDNA_STEVILKA,
                                        KOLICINA_ARTIKLA)
                                        VALUES (:id_narocila, :id_up, :date, :status, :zap_st, :num)");
            $statement->bindParam(":id_narocila", $id_narocila);
            $statement->bindParam(":id_up", $user["ID_UPORABNIK"]);
            $statement->bindParam(":date", $date);
            $statement->bindParam(":status", $status);
            $statement->bindParam(":zap_st", $zap_st);
            $statement->bindParam(":num", $data[1]);
            $statement->execute();
            
            if ($statement->rowCount() < 1) {
                return FALSE;
            }
            
            $db = DBInit::getInstance();
            
            $statement = $db->prepare(" INSERT INTO VSEBUJE
                                       (ID_NAROCILA,
                                        SIFRA_ARTIKLA)
                                        VALUES (:id_narocila, :id_artikla)");
            $statement->bindParam(":id_narocila", $id_narocila);
            $statement->bindParam(":id_artikla", $data[0]);
            $statement->execute();
            
            if ($statement->rowCount() < 1) {
                return FALSE;
            }
        }

        return TRUE;
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

        $statement1 = $db->prepare("INSERT INTO SLIKA VALUES (:id, :sifra,'AAAAA', :url)");
        $statement1->bindParam(":id", $sifra);
        $statement1->bindParam(":sifra", $sifra);
        $statement1->bindParam(":url", $url);
        $statement1->execute();
    }

    public static function update($sifra, $idskupine, $naziv, $cena, $proizvajalec, $enota, $opis) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE ARTIKEL SET ID_SKUPINE = :idskupine,
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
}
