//package com.slicky.ep.astronomy.adapter;
//
//import android.content.Context;
//import android.view.LayoutInflater;
//import android.view.View;
//import android.view.ViewGroup;
//import android.widget.ArrayAdapter;
//import com.slicky.ep.astronomy.R;
//import com.slicky.ep.astronomy.model.CartItem;
//import com.slicky.ep.astronomy.model.StoreItem;
//
//import java.util.ArrayList;
//
///**
// * Created by slicky on 19.1.2017
// */
//public class CartAdapter extends ArrayAdapter<CartItem> {
//
//    private final Context context;
//    private final LayoutInflater inflater;
//
//    public CartAdapter(Context context) {
//        super(context, R.id.cart_item, new ArrayList<StoreItem>());
//
//        this.context = context;
//        inflater = LayoutInflater.from(context);
//    }
//
//    @Override
//    public View getView(int position, View convertView, ViewGroup parent) {
//        final CartItem item = getItem(position);
//
//        if (convertView == null)
//            convertView = inflater.inflate(
//                    R.layout.cart_item,
//                    parent,
//                    false);
//
//    }
//}
