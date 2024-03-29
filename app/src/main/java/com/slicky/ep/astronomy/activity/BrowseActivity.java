package com.slicky.ep.astronomy.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.adapter.BrowseAdapter;
import com.slicky.ep.astronomy.callback.StoreItemsCallback;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StoreItem;
import com.slicky.ep.astronomy.rest.RestService;

import java.util.List;

public class BrowseActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    private static final int SIGN_IN_CODE = 0xABBA;
    static final int SIGN_IN_EXIT = 0xEFFE;

    private NavigationView navigationView;
    private SwipeRefreshLayout container;
    private BrowseAdapter adapter;
    private ListView list;

    private StoreItemsCallback itemCallback;

    private LoginHandler login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_browse);

        setTitle("Browse Items");

        itemCallback = new StoreItemsCallback(this);

        login = LoginHandler.getInstance();

        setToolbar();
        setNavBar();
        setActionButton();
        setListView();
    }

    private void setToolbar() {
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();
    }

    private void setNavBar() {
        navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        final Menu menu = navigationView.getMenu();

        if (login.isLoggedIn()) {
            menu.getItem(0).setVisible(true);
            menu.getItem(1).setVisible(true);
            menu.getItem(2).setVisible(true);
            menu.getItem(3).setVisible(false);
            menu.getItem(4).setVisible(true);
        } else {
            menu.getItem(0).setVisible(false);
            menu.getItem(1).setVisible(false);
            menu.getItem(2).setVisible(false);
            menu.getItem(3).setVisible(true);
            menu.getItem(4).setVisible(false);
        }
    }

    private void setActionButton() {
        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        if (login.isLoggedIn()) {
            fab.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    showCart();
                }
            });
        } else {
            fab.setVisibility(View.GONE);
        }
    }

    private void setListView() {
        adapter = new BrowseAdapter(this);

        list = (ListView) findViewById(R.id.lv_browse);
        list.setAdapter(adapter);
        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                final StoreItem item = adapter.getItem(i);
                if (item != null) {
                    final Intent intent = new Intent(
                            BrowseActivity.this,
                            DetailsActivity.class);
                    intent.putExtra("com.slicky.ep.astronomy.item", item);
                    startActivity(intent);
                }
            }
        });

        SwipeRefreshLayout.OnRefreshListener listener = new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                RestService.getInstance()
                        .getItems()
                        .enqueue(itemCallback);
            }
        };

        container = (SwipeRefreshLayout) findViewById(R.id.purchases_container);
        container.setOnRefreshListener(listener);

        // start first refresh
        container.setRefreshing(true);
        listener.onRefresh();
    }

    private void signIn() {
        if (!login.isLoggedIn()) {
            Intent intent = new Intent(this, SignInActivity.class);
            startActivityForResult(intent, SIGN_IN_CODE);
        }
    }

    private void signOut() {
        if (login.isLoggedIn()) {
            login.signOut();
            Intent intent = new Intent(this, BrowseActivity.class);
            startActivity(intent);
            finish();
        }
    }

    private void showCart() {
        if (login.isLoggedIn()) {
            Intent intent = new Intent(this, CartActivity.class);
            startActivity(intent);
        }
    }

    private void showPurchases() {
        if (login.isLoggedIn()) {
            Intent intent = new Intent(this, PurchasesActivity.class);
            startActivity(intent);
        }
    }

    private void showProfile() {
        if (login.isLoggedIn()) {
            Intent intent = new Intent(this, ProfileActivity.class);
            startActivity(intent);
        }
    }

    public void refreshItems(List<StoreItem> items) {
        adapter.clear();
        adapter.addAll(items);
    }

    public void stopRefreshing() {
        container.setRefreshing(false);
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()) {
            case R.id.nav_signin:
                signIn();
                break;
            case R.id.nav_profile:
                showProfile();
                break;
            case R.id.nav_cart:
                showCart();
                break;
            case R.id.nav_purchases:
                showPurchases();
                break;
            case R.id.nav_signout:
                signOut();
                break;
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == SIGN_IN_CODE && resultCode == SIGN_IN_EXIT)
            finish();
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START))
            drawer.closeDrawer(GravityCompat.START);
        else
            super.onBackPressed();
    }
}
