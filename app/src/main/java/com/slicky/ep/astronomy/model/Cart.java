package com.slicky.ep.astronomy.model;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by SlickyPC on 16.1.2017
 */
public class Cart {

    private final List<CartItem> items;

    public Cart() {
        items = new ArrayList<>();
    }

    public static void main(String[] args) {
        Cart cart = new Cart();

        CartItem i1 = new CartItem(1, 3);
        CartItem i2 = new CartItem(2, 5);

        cart.addItem(i1);
        cart.addItem(i2);

        for (CartItem item : cart.items) {
            System.out.println(item);
        }
    }

    public void addItem(CartItem item) {
        CartItem inCart = findItem(item);
        if (inCart != null) {
            inCart.quantity += item.quantity;
        } else {
            items.add(item);
        }
    }

    private CartItem findItem(CartItem item) {
        for (CartItem inCart : items) {
            if (inCart.id == item.id)
                return inCart;
        }
        return null;
    }

    public List<CartItem> getItems() {
        return items;
    }
}
