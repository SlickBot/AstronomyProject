package com.slicky.ep.astronomy.handler;

import com.slicky.ep.astronomy.model.Cart;
import com.slicky.ep.astronomy.model.CartItem;
import com.slicky.ep.astronomy.model.StoreItem;

/**
 * Created by slicky on 19.1.2017
 */
public class CartHandler {
    private static final CartHandler instance = new CartHandler();

    private Cart cart;

    private CartHandler() {
        cart = new Cart();
    }

    public static CartHandler getInstance() {
        return instance;
    }

    public Cart getCart() {
        return cart;
    }

    public void addToCart(StoreItem item, int value) {
        cart.add(item, value);
    }

    public Double getTotal() {
        Double total = 0.0;
        for (CartItem item : cart) {
            total += item.getTotal();
        }
        return total;
    }

    public void reset() {
        cart = new Cart();
    }

    public void remove(CartItem cartItem) {
        cart.remove(cartItem);
    }
}
