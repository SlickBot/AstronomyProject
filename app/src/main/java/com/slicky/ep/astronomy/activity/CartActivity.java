package com.slicky.ep.astronomy.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.adapter.CartAdapter;
import com.slicky.ep.astronomy.callback.StoreBoughtCallback;
import com.slicky.ep.astronomy.handler.CartHandler;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.CartItem;
import com.slicky.ep.astronomy.rest.RestService;

import java.util.ArrayList;
import java.util.Locale;

public class CartActivity extends AppCompatActivity {

    private TextView totalField;

    private CartAdapter adapter;
    private ListView list;
    private CartHandler cart;

    private StoreBoughtCallback purchaseCallback;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cart);

        setTitle("Cart");

        cart = CartHandler.getInstance();
        purchaseCallback = new StoreBoughtCallback(this);

        totalField = (TextView) findViewById(R.id.tv_cart_total);

        adapter = new CartAdapter(this);
        adapter.addAll(cart.getCart());

        list = (ListView) findViewById(R.id.lv_cart);
        list.setAdapter(adapter);
        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                final CartItem item = adapter.getItem(i);
                if (item != null) {
                    Intent intent = new Intent(
                            CartActivity.this,
                            DetailsActivity.class);
                    intent.putExtra("com.slicky.ep.astronomy.item", item.item);
                    startActivity(intent);
                }
            }
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        refresh();
    }

    public void refresh() {
        totalField.setText(String.format(Locale.getDefault(), "%.2f€", cart.getTotal()));
        adapter.clear();
        adapter.addAll(cart.getCart());
    }

    public void onPurchase(View view) {
        LoginHandler.Credentials credentials = LoginHandler.getInstance().getCredentials();
        ArrayList<String> list = new ArrayList<>();

        for (CartItem item : cart.getCart()) {
            String s = item.item.SIFRA_ARTIKLA + "|" + item.quantity;
            list.add(s);
        }

        RestService.getInstance()
                .buy(credentials.getUsername(), credentials.getHash(), list)
                .enqueue(purchaseCallback);
    }
}
