package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.SignInActivity;
import com.slicky.ep.astronomy.model.StoreLogin;
import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreLoginCallback
        extends StoreCallback<StoreLogin> {

    private SignInActivity signInActivity;

    public StoreLoginCallback(SignInActivity signInActivity) {
        super(signInActivity);
        this.signInActivity = signInActivity;
    }

    @Override
    public void onSuccess(Call<StoreLogin> call, Response<StoreLogin> response) {
        super.onSuccess(call, response);
        if (response.body().login) {
            signInActivity.signIn();
        }
    }
}
