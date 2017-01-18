# Astronomy Project
**Elektronsko poslovanje**

## TODO

***ASAP***
- naredi GitHub stran ✓

## NAVODILA

Spletna prodajalna naj ima naslednje uporabnike, pri katerih hranite spodaj navedene atribute.

    Administrator: Ime, Priimek, Elektronski naslov in geslo. ✓
    Prodajalec: Ime, Priimek, Elektronski naslov in geslo. ✓
    Stranka: Ime, Priimek, Elektronski naslov, Naslov, Telefonska številka, geslo. ✓
    Anonimni odjemalec, pri katerem ne hranite atributov. ✓

**Osnovne storitve**

Osnovne storitve prodajalne naj podpirajo naslednje operacije pri vsaki vlogi.

**Spletni vmesnik vloge Administrator**

Vmesnik naj omogoča:

    - Prijavo in odjavo. ✓ Dostop je dovoljen le odjemalcem, ki se overijo s pomočjo certifikatov X.509; x
    - Posodobitev lastnega gesla in ostalih atributov; ✓
    - Ustvarjanje, aktiviranje in deaktiviranje uporabniškega računa Prodajalec ter posodobitev njegovih atributov. ✓

V vlogi administratorja imate lahko zgolj enega uporabnika, ki ga lahko kreirate ročno, denimo z uporabo določene skripte, vmesnika phpmyadmin in podobno.

**Spletni vmesnik vloge Prodajalec**

Vmesnik naj omogoča:

    - Prijavo in odjavo. ✓ Dostop je dovoljen le odjemalcem, ki se overijo s pomočjo certifikatov X.509; x
    - Posodobitev lastnega gesla in ostalih atributov; ✓
    - Obdelavo naročil. Slednje obsega:
        - Pregled še neobdelanih naročil in njihovih postavk. Posamezno naročilo se prodajalcu prikaže šele, ko Stranka z nakupom zaključi; ?
        - Potrjevanje ali preklic oddanih naročil; ✓
        - Ogled zgodovine potrjenih naročil in možnost storniranja potrjenih naročil. ✓
    - Ustvarjanje, aktiviranje in deaktiviranje artiklov in posodabljanje njihovih atributov. Pri obravnavi artiklov lahko upravljanje z zalogami izpustite. Z drugimi besedami -- v aplikaciji lahko vedno predpostavite, da je na zalogi dovolj artiklov; ✓
    - Ustvarjanje, aktiviranje in deaktiviranje uporabniških računov tipa Stranka in posodabljanje njegovih atributov. ✓

**Spletni vmesnik vloge Stranka**

Vmesnik naj omogoča:

    - Prijavo in odjavo; ✓
    - Posodobitev lastnega gesla in ostalih atributov; ✓
    - Nakupovanje. To naj bo sestavljeno iz:
        - Pregledovanja artiklov trgovine; ✓
        - Dodajanja in odstranjevanja artiklov v košarico ter spreminjanja količine v košarici; ✓
        - Zaključka nakupa. Tu se naj stranki prikaže povzetek kupljenih izdelkov s predračunom. Ko stranka naročilo potrdi, se to doda v čakalno vrsto neobdelanih naročil, kjer ga lahko v obravnavo prevzame Prodajalec. ✓
    - Dostop do seznama preteklih nakupov. Uporabnik lahko vidi vsa svoja pretekla naročila: oddana, potrjena in stornirana. ✓
    - Uporaba vmesnika Stranka je dovoljena le preko zavarovanega kanala. Odjemalca overite z uporabniškim imenom in geslom, ki naj bosta shranjena v SUPB. x

**Spletni vmesnik anonimnega odjemalca**

Vmesnik naj omogoča:

    - Pregledovanje artiklov preko spletnega vmesnika; ✓
    - Registracijo preko spletnega vmesnika; ✓
    - Uporaba vmesnika anonimnega odjemalca je dovoljena preko javnega in zavarovanega kanala, pri registraciji pa nujno preklopite na zavarovan kanal. V splošnem poskrbite za ustrezno preklapljanje med omenjenima kanaloma. x

**Vmesnik mobilne aplikacije (platforma Android)**

Izdelajte Android aplikacijo, ki bo omogočala preprosto pregledovanje artiklov v vaši trgovini.

    - Implementirajte vmesnik spletne storitve, preko katerega bo mobilna aplikacija komunicirala z vašo prodajalno; ✓
    - Implementirajte funkcionalnost brskanja po artiklih. Implementirajte vsaj dva zaslona:
        - Prvi zaslon naj prikaže seznam vseh artiklov v trgovini; ✓
        - Če uporabnik izbere artikel s zgornjega seznama, naj aplikacija prikaže drug zaslon, kjer se izpišejo podrobnosti artikla. ✓

**Ostale zahteve**

Vaša rešitev naj zadosti še omenjenim zahtevam:

    - Vzpostavite lastno certifikatno agencijo in z njo izdelajte strežniško digitalno potrdilo. Digitalno potrdilo namestite v strežnik Apache. ✓
    - Osebne certifikate izdelajte ročno z namenskim programom in z uporabo iste certifikatne agencije, kot ste jo uporabili za izdelavo strežniškega certifikata. Uporabite smiselna polja certifikata ter na ustrezen način povežite identiteto uporabnika v bazi z identiteto zapisano v certifikatu. ✓
    - Pri realizaciji vseh delov prodajalne skrbno preverjajte vnose s strani odjemalca, pri čemer bodite posebej pozorni na napade injekcije kode SQL ter napade XSS. ?
    - Metode protokola HTTP realizirajte v skladu s priporočili standarda HTTP, kjer uporabite zahtevke z metodo GET za lahke operacije, za zahtevnejše pa zahtevke z metodo POST. ✓
    - Poskrbite za ustrezno hrambo gesel. ✓
    - Izdelan model podatkovne baze naj bo normaliziran do tretje normalne oblike. Vse denormalizacije morajo biti utemeljene. ✓

Uspešna realizacija vseh navedenih zahtev prinese 50% ocene, preostalih 50% pridobite z realizacijo izbranih razširjenih storitev.

**Razširjene storitve**

Z implementacijo razširjenih storitev lahko zvišate oceno. Pri vsaki storitvi je navedeno, kolikšen delež ocene prinaša. Pri tem je pomembno, da lahko za razširjene storitve dobite največ 50%. Slednje pomeni, da v kolikor izgubite točke pri Osnovnih storitvah, jih z razširjenimi storitvami ne morete kompenzirati.

**Varnost**

    - (5%) Vodenje dnevnika uporabnikov Administrator in Prodajalec. ✓
    - (5%) Registracija strank z uporabo filtriranja CAPTCHA. ✓
    - (5%) Registracija strank z uporabo potrditvenega e-maila. x

**Uporabniški vmesnik**

    - (do 10%) Smiselna organizacija in izvedba uporabniškega vmesnika s pomočjo tehnologij kot so sta CSS in JavaScript. Za polno oceno je nujna tudi uporaba tehnologije AJAX. x
    - (5%) Implementacija ocenjevanja artiklov prijavljenega uporabnika ter predstavitev njihove povprečne ocene pri njihovem ogledu. ?
    - (5%) Implementacija iskanja po artiklih. Iskalnik naj podpira binarno iskanje, tj. poizvedbe pri katerih lahko s posebnimi operatorji določene iskalne pojme izključimo. x
    - (10%) Predstavitev artiklov s slikami. Slike lahko shranite v SUPB ali na datotečni sistem. Za polno oceno mora implementacija podpirati dodajanje in spreminjanje slik na enak način kot se spreminjajo ostali atributi artiklov ter možnost, da za vsak artikel dodamo več slik. ?

**Napredne funkcije mobilne aplikacije**

Mobilno aplikacijo razširite, tako da bo podpirala naslednje funkcije vloge Stranka:

    - (5%) Prijava in odjava. ✓
    - (5%) Pregled profilnih podatkov (ime, priimek, email, geslo, naslov ipd.) ✓ ter možnost njihovega spreminjanja. x
    - (10%) Izvajanje nakupa. Implementirajte zaslon, kjer boste prikazali vsebino nakupovalne košarice skupaj z ustreznimi kontrolami za manipulacijo artiklov v košarici ter dialogom, kjer bo uporabnik lahko nakup tudi zaključil. ?
        - (dodatnih 5%) Implementacija nakupovalne košarice naj bo sinhronizirana z računom prijavljenega uporabnika. Na primer, če je uporabnik prijavljen v mobilno in v spletno aplikacijo hkrati, naj bo vsebina nakupovalne košarice v obeh vmesnikih ista. Pri tem vam ni treba skrbeti, da se vsebina samodejno osvežuje, temveč lahko od uporabnika zahtevate, da vsebino košarice ročno osveži. x
    - (5%) Pregled preteklih nakupov. Implementacija naj obsega tako pregled seznama vseh nakupov kot tudi ogled podrobnosti posameznega nakupa kot so seznam artiklov, končni znesek ipd. ?

**Pravila udeležencev**

    - Delo poteka v skupini z največ tremi udeleženci.
    - Od vsakega člana ekipe se zahteva enakomerni doprinos k delu.
    - Če delate seminarsko nalogo sami, vam implementacija osnovnih storitev prinese 75% in ne 50%. Preostalih 25% pridobite z implementacijo razširjenih storitev.

**Končno poročilo**

Končno poročilo boste izdelali po predlogi, ki je objavljena v spletni učilnici. V poročilu boste na kratko in jedrnato podali:

    - Seznam implementiranih osnovnih in razširjenih storitev;
    - Opis podatkovnega modela, kjer boste pojasnili neočitne in ne-trivialne atribute;
    - Opis implementiranih varnostnih mehanizmov;
    - Avtorstvo delov naloge glede na člane skupine;
    
**Oddaja dela in zagovor**

Končno poročilo, shemo podatkovne baze s podatki in vso programsko kodo oddajte preko spletne učilnice.

Skrajni rok oddaje, je sreda, 18. 1. 2017, ob 7:55.

Zagovori bodo potekali med 18. in 23. 1. v prostorih Laboratorija za e-medije (R3.50). Konkreten termin si izberite sami, tako da se vpišete na wiki.

Na zagovoru boste s pomočjo asistenta vašo rešitev namestili na vnaprej pripravljen računalnik in jo tudi demonstrirali.
Avtor implementacije posamezne storitve naj ima v predstavitvi glavno besedo, tj. kdor naredi, ta predstavi.
Nato sledi čas za vprašanja asistenta ter za varnostni pregled rešitve. Zagovor tipično traja 60 minut.
Zadnja sprememba: petek, 28. oktober 2016, 15:43.
