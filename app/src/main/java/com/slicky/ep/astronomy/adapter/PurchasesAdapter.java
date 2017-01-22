package com.slicky.ep.astronomy.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.model.StorePurchase;

import java.util.ArrayList;

/**
 * Created by slicky on 19.1.2017
 */
public class PurchasesAdapter extends ArrayAdapter<StorePurchase> {

    private final Context context;
    private final LayoutInflater inflater;

    public PurchasesAdapter(Context context) {
        super(context, R.id.lv_purchases, new ArrayList<StorePurchase>());

        this.context = context;
        inflater = LayoutInflater.from(context);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        final StorePurchase item = getItem(position);

        if (convertView == null)
            convertView = inflater.inflate(
                    R.layout.purchases_item,
                    parent,
                    false);

        TextView id = (TextView) convertView.findViewById(R.id.purchases_item_id);
        TextView date = (TextView) convertView.findViewById(R.id.purchases_item_date);
        // todo: add quantity

        id.setText(String.valueOf(item.ZAP_ST));
        date.setText(item.DATUM_NAROCILA.toString());

        return convertView;
    }
}
