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
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;
import com.slicky.ep.astronomy.ItemAdapter;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.RestService;
import com.slicky.ep.astronomy.model.Login;
import com.slicky.ep.astronomy.model.StoreItem;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.io.IOException;
import java.util.List;

public class BrowseActivity extends AppCompatActivity
        implements Callback<List<StoreItem>>, NavigationView.OnNavigationItemSelectedListener {
    private static final String TAG = BrowseActivity.class.getCanonicalName();
    private static final int SIGN_IN_CODE = 0xABBA;
    static final int SIGN_IN_EXIT = 0xEFFE;

    private NavigationView navigationView;
    private SwipeRefreshLayout container;
    private ItemAdapter adapter;
    private ListView list;

    private Login login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_browse);

        login = Login.getInstance();

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
            menu.getItem(0).setVisible(false);
            menu.getItem(1).setVisible(true);
            menu.getItem(2).setVisible(true);
            menu.getItem(3).setVisible(true);
            menu.getItem(4).setVisible(true);
        } else {
            menu.getItem(0).setVisible(true);
            menu.getItem(1).setVisible(false);
            menu.getItem(2).setVisible(false);
            menu.getItem(3).setVisible(false);
            menu.getItem(4).setVisible(false);
        }
    }

    private void setActionButton() {
        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showCart();
            }
        });
    }

    private void setListView() {
        adapter = new ItemAdapter(this);

        list = (ListView) findViewById(R.id.items);
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
                        .enqueue(BrowseActivity.this);
            }
        };

        container = (SwipeRefreshLayout) findViewById(R.id.container);
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

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @SuppressWarnings("StatementWithEmptyBody")
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
    public void onResponse(Call<List<StoreItem>> call, Response<List<StoreItem>> response) {
        final List<StoreItem> hits = response.body();

        if (response.isSuccessful()) {
            Log.i(TAG, "Hits: " + hits.size());
            adapter.clear();
            adapter.addAll(hits);
        } else {
            String errorMessage;
            try {
                errorMessage = "An error occurred: " + response.errorBody().string();
            } catch (IOException e) {
                errorMessage = "An error occurred: error while decoding the error message.";
            }
            Toast.makeText(this, errorMessage, Toast.LENGTH_SHORT).show();
            Log.e(TAG, errorMessage);
        }
        container.setRefreshing(false);
    }

    @Override
    public void onFailure(Call<List<StoreItem>> call, Throwable t) {
        Toast.makeText(this, t.getMessage(), Toast.LENGTH_SHORT).show();
        Log.w(TAG, "Error: " + t.getMessage(), t);
        container.setRefreshing(false);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == SIGN_IN_CODE) {
            if (resultCode == SIGN_IN_EXIT) {
                finish();
            }
        }
    }
}
