package com.slicky.ep.astronomy.model;

import android.support.annotation.NonNull;

import java.io.Serializable;

/**
 * Created by SlickyPC on 14.1.2017
 */
public class StoreItem implements Serializable {
    @NonNull public int SIFRA_ARTIKLA;
    public String NAZIV_ARTIKLA;
    public String OPIS;
    public String POT_SLIKE;
    public Double CENA;

    @Override
    public String toString() {
        return "StoreItem{" +
                "SIFRA_ARTIKLA='" + SIFRA_ARTIKLA + '\'' +
                ", NAZIV_ARTIKLA='" + NAZIV_ARTIKLA + '\'' +
                ", OPIS='" + OPIS + '\'' +
                ", POT_SLIKE='" + POT_SLIKE + '\'' +
                ", CENA=" + CENA +
                '}';
    }
}
