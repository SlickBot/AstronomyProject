/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     13.1.2017 15:01:59                           */
/*==============================================================*/


drop table if exists ARTIKEL;

drop table if exists DNEVNIK_PRIJAV;

drop table if exists KOMERCIALNA_SKUPINA;

drop table if exists NAROCILO;

drop table if exists SLIKA;

drop table if exists UPORABNIK;

drop table if exists VSEBUJE;

/*==============================================================*/
/* Table: ARTIKEL                                               */
/*==============================================================*/
create table artikel
(
   SIFRA_ARTIKLA        int not null,
   ID_SKUPINE           int not null,
   NAZIV_ARTIKLA        varchar(50) not null,
   CENA                 numeric(10,0) not null,
   PROIZVAJALEC         varchar(25),
   ENOTA_MER            char(5) not null,
   OPIS                 longtext not null,
   primary key (SIFRA_ARTIKLA)
);

/*==============================================================*/
/* Table: DNEVNIK_PRIJAV                                        */
/*==============================================================*/
create table dnevnik_prijav
(
   ID_PRIJAVE           int not null,
   IP                   varchar(20),
   CAS_PRIJAVE          timestamp not null,
   CAS_ODJAVE           timestamp not null,
   USPESNOST            smallint not null,
   primary key (ID_PRIJAVE)
);


/*==============================================================*/
/* Table: KOMERCIALNA_SKUPINA                                   */
/*==============================================================*/
create table komercialna_skupina
(
   ID_SKUPINE           int not null,
   NAZIV_SKUPINE        varchar(25) not null,
   primary key (ID_SKUPINE)
);

/*==============================================================*/
/* Table: NAROCILO                                              */
/*==============================================================*/
create table narocilo
(
   ID_NAROCILA          int not null,
   ID_UPORABNIK         int not null,
   DATUM_NAROCILA       timestamp not null,
   STATUS_NAROCILA      int not null,
   ZAPOREDNA_STEVILKA   int not null,
   KOLICIN_ARTIKLA      int not null,
   primary key (ID_NAROCILA)
);

/*==============================================================*/
/* Table: SLIKA                                                 */
/*==============================================================*/
create table slika
(
   ID_SLIKE             int not null,
   SIFRA_ARTIKLA        int not null,
   IME_SLIKE            varchar(100) not null,
   POT_SLIKE            varchar(100) not null,
   primary key (ID_SLIKE)
);

/*==============================================================*/
/* Table: UPORABNIK                                             */
/*==============================================================*/
create table uporabnik
(
   ID_UPORABNIK         int not null,
   ID_PRIJAVE           int not null,
   TIP                  int not null,
   IME                  varchar(25) not null,
   PRIIMEK              varchar(25) not null,
   ELEKTRONSKI_NASLOV   varchar(30) not null,
   GESLO                varchar(32) not null,
   TELEFONSKA_STEVILKA  varchar(15) not null,
   NASLOV               varchar(50) not null,
   primary key (ID_UPORABNIK)
);

/*==============================================================*/
/* Table: VSEBUJE                                               */
/*==============================================================*/
create table vsebuje
(
   ID_NAROCILA          int not null,
   SIFRA_ARTIKLA        int not null,
   primary key (ID_NAROCILA, SIFRA_ARTIKLA)
);
LOCK TABLES `vsebuje` WRITE;
/*!40000 ALTER TABLE `narocilo` DISABLE KEYS */;
INSERT INTO `vsebuje` VALUES (1,1),(2,1),(1,2),(2,2),(3,3),(2,3),(3,2),(3,1);
/*!40000 ALTER TABLE `narocilo` ENABLE KEYS */;
UNLOCK TABLES;

alter table artikel add constraint FK_SPADA_POD foreign key (ID_SKUPINE)
      references komercialna_skupina (ID_SKUPINE) on delete restrict on update restrict;

alter table narocilo add constraint FK_RELATIONSHIP_3 foreign key (ID_UPORABNIK)
      references uporabnik (ID_UPORABNIK) on delete restrict on update restrict;

alter table slika add constraint FK_RELATIONSHIP_5 foreign key (SIFRA_ARTIKLA)
      references artikel (SIFRA_ARTIKLA) on delete restrict on update restrict;

alter table uporabnik add constraint FK_RELATIONSHIP_4 foreign key (ID_PRIJAVE)
      references dnevnik prijav (ID_PRIJAVE) on delete restrict on update restrict;

alter table vsebuje add constraint FK_RELATIONSHIP_6 foreign key (ID_NAROCILA)
      references narocilo (ID_NAROCILA) on delete restrict on update restrict;

alter table vsebuje add constraint FK_RELATIONSHIP_7 foreign key (SIFRA_ARTIKLA)
      references artikel (SIFRA_ARTIKLA) on delete restrict on update restrict;

LOCK TABLES `komercialna_skupina` WRITE;
/*!40000 ALTER TABLE `komercialna_skupina` DISABLE KEYS */;
INSERT INTO `komercialna_skupina` VALUES (1,'Skupina 1'),(2,'Skupina 2'),(3,'Skupina 3');
/*!40000 ALTER TABLE `komercialna_skupina` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `vsebuje` WRITE;
/*!40000 ALTER TABLE `narocilo` DISABLE KEYS */;
INSERT INTO `vsebuje` VALUES (1,1),(2,1),(1,2),(2,2),(3,3),(2,3),(3,2),(3,1);
/*!40000 ALTER TABLE `narocilo` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `narocilo` WRITE;
/*!40000 ALTER TABLE `narocilo` DISABLE KEYS */;
INSERT INTO `narocilo` VALUES (1,1,'2015-12-12 17:43:15',1,224,2),(2,1,'2015-11-27 18:00:17',1,225,4),(3,3,'2017-01-02 22:17:28',1,226,1);
/*!40000 ALTER TABLE `narocilo` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `artikel` WRITE;
/*!40000 ALTER TABLE `artikel` DISABLE KEYS */;
INSERT INTO `artikel` VALUES (122,1,1,'Teleskop',500.17,'Celsteron','1', 'Opis teleskopa'),(125,1,1,'Optična cev',123.17,'Leo','3', 'Opis cevi'),(127,2,2,'Zaščitna očala',87.21,'Ray','1', 'opis očal');
/*!40000 ALTER TABLE `artikel` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `uporabnik` WRITE;
/*!40000 ALTER TABLE `uporabnik` DISABLE KEYS */;
INSERT INTO `uporabnik` VALUES (1,1,1,'Jernej','Rejc','rejcjernej94@gmail.com','fbe46ae0ca687ab0267be5cca10a248b','041692842','Ljubljanska cesta 1'),(2,2,1,'Matevž','Šubic','matevz.subic@gmail.com','f96e423c863054834065a2ed536c4f50','051682771','Dunajska cesta 23b'),(3,3,2,'Vito','Simič','vito.simic@gmail.com','334c4a4c42fdb79d7ebc3e73b517e6f8','071291888','Šmarješka ulica 22c');
/*!40000 ALTER TABLE `uporabnik` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `slika` WRITE;
/*!40000 ALTER TABLE `slika` DISABLE KEYS */;
INSERT INTO `slika` VALUES (1,122,'teleksop','../slike/teleskop.jpg'),(3,127,'očala za sonce','../slike/varna_ocala.jpg'),(4,125,'optična cev','../slike/cev.jpg');
/*!40000 ALTER TABLE `slika` ENABLE KEYS */;
UNLOCK TABLES;