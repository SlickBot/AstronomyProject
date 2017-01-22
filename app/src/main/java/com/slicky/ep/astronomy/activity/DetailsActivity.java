package com.slicky.ep.astronomy.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.handler.CartHandler;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StoreItem;
import com.slicky.ep.astronomy.tools.StoreUtils;
import com.squareup.picasso.Picasso;

import java.util.Locale;

public class DetailsActivity extends AppCompatActivity {

    private ImageView imageView;
    private TextView nameField;
    private TextView textField;
    private TextView priceField;
    private EditText quantityField;

    private StoreItem item;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        setTitle("Item Details");

        Bundle extras = getIntent().getExtras();
        item = (StoreItem) extras.get("com.slicky.ep.astronomy.item");

        imageView = (ImageView) findViewById(R.id.iv_details_image);
        priceField = (TextView) findViewById(R.id.tv_details_price);
        nameField = (TextView) findViewById(R.id.tv_details_name);
        textField = (TextView) findViewById(R.id.tv_details_text);
        quantityField = (EditText) findViewById(R.id.et_quantity);

        nameField.setText(item.NAZIV_ARTIKLA);
        priceField.setText(String.format(Locale.getDefault(), "%.2f €", item.CENA));
        textField.setText(item.OPIS);

        Picasso.with(this)
                .load(item.POT_SLIKE)
//                .fit()
                .into(imageView);
    }

    public void onAddToCart(View view) {
        StoreUtils.hideInput(this);

        try {
            int quantity = Integer.parseInt(quantityField.getText().toString());
            if (quantity < 1) {
                showTooLow();
            } else if (!LoginHandler.getInstance().isLoggedIn()) {
                showNotLoggedIn();
            } else {
                CartHandler cart = CartHandler.getInstance();
                cart.addToCart(item, quantity);
            }
        } catch (NumberFormatException ignored) {}
    }

    private void showTooLow() {
        StoreUtils.showErrorNotification(this, "Too low!", "There must be at least 1 item in cart!");
    }

    private void showNotLoggedIn() {
        StoreUtils.showErrorNotification(this, "Not signed in!", "You have to be signed in to add to cart!");
    }
}