package com.slicky.ep.astronomy.model;

import java.util.ArrayList;

/**
 * Created by SlickyPC on 16.1.2017
 */
public class Cart extends ArrayList<CartItem> {

    public static void main(String[] args) {
        Cart cart = new Cart();

        StoreItem item1 = new StoreItem();
        StoreItem item2 = new StoreItem();

        item1.ID_ARTIKLA = "1";
        item1.NAZIV_ARTIKLA = "qwe";

        item2.ID_ARTIKLA = "1";
        item2.NAZIV_ARTIKLA = "qwe";

        cart.add(item1, 2);
        cart.add(item2, 4);

        for (CartItem item : cart)
            System.out.println(item);
    }

    public void add(StoreItem item, int value) {
        CartItem inCart = find(item);
        if (inCart != null) {
            inCart.quantity += value;
        } else {
            add(new CartItem(item, value));
        }
    }

    private CartItem find(StoreItem item) {
        for (CartItem inCart : this)
            if (inCart.item.ID_ARTIKLA.equals(item.ID_ARTIKLA))
                return inCart;
        return null;
    }
}
