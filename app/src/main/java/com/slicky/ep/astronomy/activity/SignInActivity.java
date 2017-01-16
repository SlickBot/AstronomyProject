package com.slicky.ep.astronomy.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.util.Log;
import android.util.Patterns;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.RestService;
import com.slicky.ep.astronomy.StoreUtils;
import com.slicky.ep.astronomy.model.Login;
import com.slicky.ep.astronomy.model.Login.Credentials;
import com.slicky.ep.astronomy.model.StoreLogin;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.io.IOException;

public class SignInActivity extends AppCompatActivity implements Callback<StoreLogin> {
    private static final String TAG = SignInActivity.class.getCanonicalName();

    private TextView usernameField;
    private TextView passwordField;

    private Login login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_in);

        usernameField = (TextView) findViewById(R.id.et_username);
        passwordField = (TextView) findViewById(R.id.et_password);

        login = Login.getInstance();
    }

    public void onSignInClick(View view) {
        if (validate()) {
            String user = usernameField.getText().toString();
            String hash = StoreUtils.MD5(passwordField.getText().toString());
            login.setCredentials(new Credentials(user, hash));
            RestService.getInstance()
                    .authenticate(user, hash)
                    .enqueue(SignInActivity.this);
        }
    }

    private boolean validate() {
        // reset errors
        usernameField.setError(null);
        passwordField.setError(null);

        boolean success = true;
        View focusView = null;

        // validate password length
        CharSequence password = passwordField.getText();
        if (password.length() < 4) {
            passwordField.setError("Password is too short!");
            focusView = passwordField;
            success = false;
        }

        // validate username
        CharSequence username = usernameField.getText();
        if (TextUtils.isEmpty(username) || !Patterns.EMAIL_ADDRESS.matcher(username).matches()) {
            usernameField.setError("Username is not valid email!");
            focusView = usernameField;
            success = false;
        }

        // focus view with error
        if (!success)
            focusView.requestFocus();

        return success;
    }

    @Override
    public void onResponse(Call<StoreLogin> call, Response<StoreLogin> response) {
        if (response.isSuccessful() && response.body().signed_in) {
            signIn();
        } else {
            login.signOut();
            if (response.code() == 400) {
                Toast.makeText(this, "Incorrect username or password!", Toast.LENGTH_SHORT).show();
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
        }
    }

    private void signIn() {
        login.signIn();
        Intent intent = new Intent(SignInActivity.this, BrowseActivity.class);
        startActivity(intent);
        setResult(BrowseActivity.SIGN_IN_EXIT);
        finish();
    }

    @Override
    public void onFailure(Call<StoreLogin> call, Throwable t) {
        login.signOut();
        Toast.makeText(this, t.getMessage(), Toast.LENGTH_SHORT).show();
        Log.w(TAG, "Error: " + t.getMessage(), t);
    }
}
