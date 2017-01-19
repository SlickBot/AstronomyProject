package com.slicky.ep.astronomy.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.tools.RestService;
import com.slicky.ep.astronomy.tools.StoreUtils;
import com.slicky.ep.astronomy.callback.StoreLoginCallback;
import com.slicky.ep.astronomy.model.Login;
import com.slicky.ep.astronomy.model.Login.Credentials;

public class SignInActivity extends AppCompatActivity {
    private static final String TAG = SignInActivity.class.getCanonicalName();

    private TextView usernameField;
    private TextView passwordField;

    private StoreLoginCallback loginCallback;
    private Login login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_in);

        usernameField = (TextView) findViewById(R.id.et_username);
        passwordField = (TextView) findViewById(R.id.et_password);

        loginCallback = new StoreLoginCallback(this);

        login = Login.getInstance();
    }

    public void onSignInClick(View view) {
        if (validate()) {
            String user = usernameField.getText().toString();
            String hash = StoreUtils.MD5(passwordField.getText().toString());
            login.setCredentials(new Credentials(user, hash));
            RestService.getInstance()
                    .authenticate(user, hash)
                    .enqueue(loginCallback);
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
        if (!StoreUtils.isValidEmail(username)) {
            usernameField.setError("Username is not valid email!");
            focusView = usernameField;
            success = false;
        }

        // focus view with error
        if (!success)
            focusView.requestFocus();

        return success;
    }

    public void signIn() {
        login.signIn();
        Intent intent = new Intent(SignInActivity.this, BrowseActivity.class);
        startActivity(intent);
        setResult(BrowseActivity.SIGN_IN_EXIT);
        finish();
    }
}
