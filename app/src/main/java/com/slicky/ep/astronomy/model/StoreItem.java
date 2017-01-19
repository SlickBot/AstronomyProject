package com.slicky.ep.astronomy.model;

import android.support.annotation.NonNull;

import java.io.Serializable;

/**
 * Created by SlickyPC on 14.1.2017
 */
public class StoreItem implements Serializable {
    @NonNull public String ID_ARTIKLA;
    public String NAZIV_ARTIKLA;
    public String OPIS;
    public String POT_SLIKE;
    public Double CENA;

    public int quantity = 0;

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;

        StoreItem storeItem = (StoreItem) o;
        return ID_ARTIKLA.equals(storeItem.ID_ARTIKLA);
    }

    @Override
    public int hashCode() {
        return ID_ARTIKLA.hashCode();
    }

    @Override
    public String toString() {
        return "StoreItem{" +
                "ID_ARTIKLA='" + ID_ARTIKLA + '\'' +
                ", NAZIV_ARTIKLA='" + NAZIV_ARTIKLA + '\'' +
                ", OPIS='" + OPIS + '\'' +
                ", POT_SLIKE='" + POT_SLIKE + '\'' +
                ", CENA=" + CENA +
                ", quantity=" + quantity +
                '}';
    }
}
