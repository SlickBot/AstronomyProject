package com.slicky.ep.astronomy.handler;

import com.slicky.ep.astronomy.model.Cart;

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

    public void reset() {
        cart = new Cart();
    }
}
