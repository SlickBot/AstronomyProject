package com.slicky.ep.astronomy.model;

import java.util.ArrayList;

/**
 * Created by SlickyPC on 16.1.2017
 */
public class Cart extends ArrayList<CartItem> {

    public void add(StoreItem item, int value) {
        CartItem inCart = find(item);
        if (inCart != null) {
            inCart.quantity += value;
        } else {
            add(new CartItem(item, value));
        }
    }

    private CartItem find(StoreItem item) {
        for (CartItem inCart : this) {
            if (inCart.item.SIFRA_ARTIKLA == item.SIFRA_ARTIKLA)
                return inCart;
        }
        return null;
    }
}
