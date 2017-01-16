package com.slicky.ep.astronomy.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.RestService;
import com.slicky.ep.astronomy.model.Login;
import com.slicky.ep.astronomy.model.StoreUser;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.io.IOException;

public class ProfileActivity extends AppCompatActivity
        implements Callback<StoreUser> {
    private static final String TAG = ProfileActivity.class.getCanonicalName();

    private TextView id;
    private TextView ime;
    private TextView priimek;
    private TextView email;
    private TextView telefon;
    private TextView naslov;

    private Login login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        id = (TextView) findViewById(R.id.tv_id);
        ime = (TextView) findViewById(R.id.tv_ime);
        priimek = (TextView) findViewById(R.id.tv_priimek);
        email = (TextView) findViewById(R.id.tv_email);
        telefon = (TextView) findViewById(R.id.tv_tele);
        naslov = (TextView) findViewById(R.id.tv_naslov);

        login = Login.getInstance();

        RestService.getInstance()
                   .getUser(login.getCredentials().getUsername(), login.getCredentials().getHash())
                   .enqueue(ProfileActivity.this);
    }

    private void displayUser(StoreUser user) {
        id.setText(user.ID_UPORABNIK);
        ime.setText(user.IME);
        priimek.setText(user.PRIIMEK);
        email.setText(user.ELEKTRONSKI_NASLOV);
        telefon.setText(user.TELEFONSKA_STEVILKA);
        naslov.setText(user.NASLOV);
    }

    @Override
    public void onResponse(Call<StoreUser> call, Response<StoreUser> response) {
        final StoreUser user = response.body();

        if (response.isSuccessful()) {
            displayUser(user);
        } else {
            String errorMessage;
            try {
                errorMessage = "An error occurred: " + response.errorBody().string();
            } catch (IOException e) {
                errorMessage = "An error occurred: error while decoding the error message.";
            }
            Toast.makeText(this, errorMessage, Toast.LENGTH_SHORT).show();
            Log.e(TAG, errorMessage);
            finish();
        }
    }

    @Override
    public void onFailure(Call<StoreUser> call, Throwable t) {
        Toast.makeText(this, t.getMessage(), Toast.LENGTH_SHORT).show();
        Log.w(TAG, "Error: " + t.getMessage(), t);
        finish();
    }
}
