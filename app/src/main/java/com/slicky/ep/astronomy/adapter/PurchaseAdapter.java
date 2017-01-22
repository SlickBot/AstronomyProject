package com.slicky.ep.astronomy.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.activity.PurchaseActivity;
import com.slicky.ep.astronomy.model.Cart;
import com.slicky.ep.astronomy.model.StorePurchaseElement;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.Locale;

/**
 * Created by SlickyPC on 21.1.2017
 */
public class PurchaseAdapter extends ArrayAdapter<StorePurchaseElement> {

    private final Context context;
    private final LayoutInflater inflater;

    public PurchaseAdapter(Context context) {
        super(context, R.id.lv_purchase, new ArrayList<StorePurchaseElement>());

        this.context = context;
        inflater = LayoutInflater.from(context);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        final StorePurchaseElement item = getItem(position);

        if (convertView == null)
            convertView = inflater.inflate(
                    R.layout.purchase_item,
                    parent,
                    false);

        ImageView image = (ImageView) convertView.findViewById(R.id.purchase_item_image);
        TextView title = (TextView) convertView.findViewById(R.id.purchase_item_title);
        TextView sum = (TextView) convertView.findViewById(R.id.purchase_item_sum);
        TextView quantity = (TextView) convertView.findViewById(R.id.purchase_item_quantity);

        Picasso.with(context)
                .load(item.POT_SLIKE)
//                .fit()
                .into(image);

        title.setText(item.NAZIV_ARTIKLA);
        sum.setText(String.format(Locale.getDefault(), "%.2f€", item.KOLICINA_ARTIKLA * item.CENA));
        quantity.setText(String.format(Locale.getDefault(), "%d x %.2f€", item.KOLICINA_ARTIKLA, item.CENA));

        return convertView;
    }
}
