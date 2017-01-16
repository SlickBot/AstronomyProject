package com.slicky.ep.astronomy.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.StoreUtils;
import com.slicky.ep.astronomy.model.StoreItem;
import com.squareup.picasso.Picasso;

import java.util.Locale;

public class DetailsActivity extends AppCompatActivity {

    private ImageView imageView;
    private TextView name;
    private TextView text;
    private TextView price;
    private EditText quantity;

    private StoreItem item;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        Bundle extras = getIntent().getExtras();
        item = (StoreItem) extras.get("com.slicky.ep.astronomy.item");

        imageView = (ImageView) findViewById(R.id.iv_details_image);
        price = (TextView) findViewById(R.id.tv_details_price);
        name = (TextView) findViewById(R.id.tv_details_name);
        text = (TextView) findViewById(R.id.tv_details_text);
        quantity = (EditText) findViewById(R.id.et_quantity);

        name.setText(item.NAZIV_ARTIKLA);
        price.setText(String.format(Locale.getDefault(), "%.3f €", item.CENA));
        text.setText(item.OPIS);

        Picasso.with(this)
                .load(item.POT_SLIKE)
//                .fit()
                .into(imageView);
    }

    public void onAddToCart(View view) {
        StoreUtils.hideInput(this);
    }
}