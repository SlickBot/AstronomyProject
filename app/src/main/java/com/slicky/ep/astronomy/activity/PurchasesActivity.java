package com.slicky.ep.astronomy.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.adapter.PurchasesAdapter;
import com.slicky.ep.astronomy.callback.StorePurchasesCallback;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StorePurchase;
import com.slicky.ep.astronomy.rest.RestService;

import java.util.List;

public class PurchasesActivity extends AppCompatActivity {

    private PurchasesAdapter adapter;
    private ListView list;
    private StorePurchasesCallback purchasesCallback;
    private SwipeRefreshLayout container;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_purchases);

        setTitle("Purchases");

        purchasesCallback = new StorePurchasesCallback(this);

        setListView();
    }

    private void setListView() {
        adapter = new PurchasesAdapter(this);

        list = (ListView) findViewById(R.id.lv_purchases);
        list.setAdapter(adapter);
        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                final StorePurchase item = adapter.getItem(i);
                if (item != null) {
                    Intent intent = new Intent(
                            PurchasesActivity.this,
                            PurchaseActivity.class);
                    intent.putExtra("com.slicky.ep.astronomy.purchase", item);
                    startActivity(intent);
                }
            }
        });

        SwipeRefreshLayout.OnRefreshListener listener = new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                LoginHandler.Credentials credentials = LoginHandler.getInstance().getCredentials();
                RestService.getInstance()
                        .getPurchases(credentials.getUsername(), credentials.getHash())
                        .enqueue(purchasesCallback);
            }
        };

        container = (SwipeRefreshLayout) findViewById(R.id.purchases_container);
        container.setOnRefreshListener(listener);

        // start first refresh
        container.setRefreshing(true);
        listener.onRefresh();
    }

    public void stopRefreshing() {
        container.setRefreshing(false);
    }

    public void refreshItems(List<StorePurchase> items) {
        adapter.clear();
        adapter.addAll(items);
    }
}
