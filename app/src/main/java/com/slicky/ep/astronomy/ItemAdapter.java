package com.slicky.ep.astronomy;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import com.slicky.ep.astronomy.model.StoreItem;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.Locale;

/**
 * Created by SlickyPC on 14.1.2017
 */
public class ItemAdapter extends ArrayAdapter<StoreItem> {
    private Context context;
    private LayoutInflater inflater;

    public ItemAdapter(Context context) {
        super(context, R.id.items, new ArrayList<StoreItem>());

        this.context = context;
        inflater = LayoutInflater.from(context);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        final StoreItem item = getItem(position);

        if (null == convertView) {
            convertView = inflater.inflate(R.layout.item_element, parent, false);
        }

        ImageView imageView = (ImageView) convertView.findViewById(R.id.item_image);
        TextView title = (TextView) convertView.findViewById(R.id.item_title);
        TextView price = (TextView) convertView.findViewById(R.id.item_price);

        // fill image
        Picasso.with(context)
                .load(item.POT_SLIKE)
                .fit()
                .into(imageView);

        // fill text
        title.setText(item.NAZIV_ARTIKLA);
        price.setText(String.format(Locale.getDefault(), "%.3f€", item.CENA));

        return convertView;
    }
}