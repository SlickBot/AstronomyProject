package com.slicky.ep.astronomy;

import com.slicky.ep.astronomy.model.Cart;
import com.slicky.ep.astronomy.model.StoreItem;
import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class Tester {

    @Test
    public void cartWorks() throws Exception {
        Cart cart = new Cart();

        StoreItem item1 = new StoreItem();
        StoreItem item2 = new StoreItem();

        item1.SIFRA_ARTIKLA = 1;
        item1.NAZIV_ARTIKLA = "qwe";

        item2.SIFRA_ARTIKLA = 1;
        item2.NAZIV_ARTIKLA = "qwe";

        cart.add(item1, 2);
        cart.add(item2, 4);

        assertEquals("Wrong size", 1, cart.size());
        assertEquals("Wrong quantity", 6, cart.get(0).quantity);
    }
}