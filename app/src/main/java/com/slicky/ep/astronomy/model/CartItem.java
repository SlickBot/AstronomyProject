package com.slicky.ep.astronomy.model;

/**
 * Created by slicky on 19.1.2017
 */
public class CartItem {

    public final int id;
    public int quantity;

    public CartItem(int id, int quantity) {
        this.id = id;
        this.quantity = quantity;
    }

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null) return false;
        if (getClass() != o.getClass()) return false;

        CartItem cartItem = (CartItem) o;
        return id == cartItem.id;
    }

    @Override
    public int hashCode() {
        return id;
    }

    @Override
    public String toString() {
        return "CartItem{" +
                "id=" + id +
                ", quantity=" + quantity +
                '}';
    }
}
