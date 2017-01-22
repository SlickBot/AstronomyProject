package com.slicky.ep.astronomy.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import com.slicky.ep.astronomy.R;
import com.slicky.ep.astronomy.rest.RestService;
import com.slicky.ep.astronomy.tools.StoreUtils;
import com.slicky.ep.astronomy.callback.StoreEditCallback;
import com.slicky.ep.astronomy.callback.StoreUserCallback;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StoreUser;

public class ProfileActivity extends AppCompatActivity {

    private TextView idField;
    private EditText nameField;
    private EditText surnameField;
    private EditText emailField;
    private EditText telephoneField;
    private EditText addressField;
    private Button editButton;

    private StoreUserCallback userCallback;
    private StoreEditCallback editCallback;

    private LoginHandler login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        setTitle("Profile");

        idField = (TextView) findViewById(R.id.tv_id);
        nameField = (EditText) findViewById(R.id.tv_ime);
        surnameField = (EditText) findViewById(R.id.tv_priimek);
        emailField = (EditText) findViewById(R.id.tv_email);
        telephoneField = (EditText) findViewById(R.id.tv_tele);
        addressField = (EditText) findViewById(R.id.tv_naslov);
        editButton = (Button) findViewById(R.id.b_edit);

        userCallback = new StoreUserCallback(this);
        editCallback = new StoreEditCallback(this);

        login = LoginHandler.getInstance();

        RestService.getInstance()
                   .getUser(login.getCredentials().getUsername(), login.getCredentials().getHash())
                   .enqueue(userCallback);
    }

    public void displayUser(StoreUser user) {
        idField.setText(user.ID_UPORABNIK);
        nameField.setText(user.IME);
        surnameField.setText(user.PRIIMEK);
        emailField.setText(user.ELEKTRONSKI_NASLOV);
        telephoneField.setText(user.TELEFONSKA_STEVILKA);
        addressField.setText(user.NASLOV);
    }

    public void onEdit(View view) {
        if (validate()) {
            RestService.getInstance()
                    .editUser(
                            login.getCredentials().getUsername(),
                            login.getCredentials().getHash(),
                            idField.getText().toString(),
                            nameField.getText().toString(),
                            surnameField.getText().toString(),
                            emailField.getText().toString(),
                            telephoneField.getText().toString(),
                            addressField.getText().toString()
                    ).enqueue(editCallback);
        }
    }


    private boolean validate() {
        // reset errors
        nameField.setError(null);
        surnameField.setError(null);
        emailField.setError(null);
        telephoneField.setError(null);
        addressField.setError(null);

        boolean success = true;
        View focusView = null;

        // validate password length
        CharSequence name = nameField.getText();
        if (name.length() < 4 || name.length() > 50) {
            nameField.setError("Name has wrong length! (4-50)");
            focusView = nameField;
            success = false;
        }

        // validate password length
        CharSequence surname = surnameField.getText();
        if (surname.length() < 4 || surname.length() > 50) {
            surnameField.setError("Surname has wrong length! (4-50)");
            focusView = surnameField;
            success = false;
        }

        // validate password length
        CharSequence email = emailField.getText();
        if (!StoreUtils.isValidEmail(email)) {
            emailField.setError("Entered text is not valid email!");
            focusView = emailField;
            success = false;
        }

        // validate password length
        CharSequence telephone = telephoneField.getText();
        if (telephone.length() < 4 || telephone.length() > 50) {
            telephoneField.setError("Telephone has wrong length! (4-50)");
            focusView = telephoneField;
            success = false;
        }

        // validate password length
        CharSequence address = addressField.getText();
        if (address.length() < 4 || address.length() > 50) {
            addressField.setError("Telephone has wrong length! (4-50)");
            focusView = addressField;
            success = false;
        }

        // focus view with error
        if (!success)
            focusView.requestFocus();

        return success;
    }
}
