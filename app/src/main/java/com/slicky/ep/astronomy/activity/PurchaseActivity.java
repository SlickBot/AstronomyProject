package com.slicky.ep.astronomy.activity;

import android.os.Bundle;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.widget.ListView;

import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.adapter.PurchaseAdapter;
import com.slicky.ep.astronomy.callback.StorePurchaseCallback;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StorePurchase;
import com.slicky.ep.astronomy.model.StorePurchaseElement;
import com.slicky.ep.astronomy.rest.RestService;

import java.util.List;
import java.util.Locale;

public class PurchaseActivity extends AppCompatActivity {

    private TextView totalField;

    private StorePurchaseCallback purchaseCallback;
    private PurchaseAdapter adapter;
    private ListView list;
    private SwipeRefreshLayout container;

    private StorePurchase purchase;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_purchase);

        setTitle("Purchase Details");

        totalField = (TextView) findViewById(R.id.tv_purchase_total);
        purchaseCallback = new StorePurchaseCallback(this);

        extractExtras();
        setListView();
    }

    private void extractExtras() {
        Bundle extras = getIntent().getExtras();
        purchase = (StorePurchase) extras.get("com.slicky.ep.astronomy.purchase");
    }

    private void setListView() {
        adapter = new PurchaseAdapter(this);

        list = (ListView) findViewById(R.id.lv_purchase);
        list.setAdapter(adapter);

        SwipeRefreshLayout.OnRefreshListener listener = new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                LoginHandler.Credentials credentials = LoginHandler.getInstance().getCredentials();
                RestService.getInstance()
                        .getPurchaseElement(
                                credentials.getUsername(),
                                credentials.getHash(),
                                purchase.ZAP_ST)
                        .enqueue(purchaseCallback);
            }
        };

        container = (SwipeRefreshLayout) findViewById(R.id.purchase_container);
        container.setOnRefreshListener(listener);

        // start first refresh
        container.setRefreshing(true);
        listener.onRefresh();
    }

    public void stopRefreshing() {
        container.setRefreshing(false);
    }

    public void refreshItems(List<StorePurchaseElement> items) {
        adapter.clear();
        adapter.addAll(items);
        totalField.setText(String.format(Locale.getDefault(), "Total: %.2f€", sumCosts(items)));
    }

    private Double sumCosts(List<StorePurchaseElement> items) {
        Double val = .0;
        for (StorePurchaseElement item : items)
            val += (item.CENA * item.KOLICINA_ARTIKLA);
        return val;
    }
}
