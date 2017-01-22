package com.slicky.ep.astronomy.adapter;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.activity.CartActivity;
import com.slicky.ep.astronomy.handler.CartHandler;
import com.slicky.ep.astronomy.model.CartItem;
import com.slicky.ep.astronomy.model.StoreItem;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.Locale;

/**
 * Created by slicky on 19.1.2017
 */
public class CartAdapter extends ArrayAdapter<CartItem> {

    private final CartActivity context;
    private final LayoutInflater inflater;

    public CartAdapter(CartActivity context) {
        super(context, R.id.lv_cart, new ArrayList<CartItem>());

        this.context = context;
        inflater = LayoutInflater.from(context);
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        final CartItem item = getItem(position);
        final StoreItem storeItem = item.item;

        if (convertView == null)
            convertView = inflater.inflate(
                    R.layout.cart_item,
                    parent,
                    false);

        ImageView imageView = (ImageView) convertView.findViewById(R.id.cart_item_image);
        TextView title = (TextView) convertView.findViewById(R.id.cart_item_title);
        TextView quantity = (TextView) convertView.findViewById(R.id.cart_item_quantity);
        TextView price = (TextView) convertView.findViewById(R.id.cart_item_price);
        ImageView remove = (ImageView) convertView.findViewById(R.id.cart_item_remove);

        remove.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                CartItem cartItem = getItem(position);
                CartHandler.getInstance().remove(cartItem);
                remove(cartItem);
                notifyDataSetChanged();
                context.refresh();
            }
        });

        // fill image
        Picasso.with(context)
                .load(storeItem.POT_SLIKE)
//                .fit()
                .into(imageView);

        // fill text
        title.setText(storeItem.NAZIV_ARTIKLA);
        quantity.setText(String.format(Locale.getDefault(), "%dx", item.quantity));
        price.setText(String.format(Locale.getDefault(), "%.2f€", storeItem.CENA * item.quantity));

        return convertView;
    }
}
