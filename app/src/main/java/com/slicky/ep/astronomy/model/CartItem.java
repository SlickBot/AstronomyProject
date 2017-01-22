package com.slicky.ep.astronomy.model;

/**
 * Created by slicky on 19.1.2017
 */
public class CartItem {

    public final StoreItem item;
    public int quantity;

    public CartItem(StoreItem item, int quantity) {
        this.item = item;
        this.quantity = quantity;
    }

    public Double getTotal() {
        return item.CENA * quantity;
    }

    @Override
    public String toString() {
        return "CartItem{" +
                "item=" + item +
                ", quantity=" + quantity +
                '}';
    }
}
