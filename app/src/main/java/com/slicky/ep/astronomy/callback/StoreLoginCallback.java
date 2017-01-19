package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.SignInActivity;
import com.slicky.ep.astronomy.model.StoreLogin;

import android.util.Log;
import android.widget.Toast;

import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreLoginCallback
        extends StoreCallback<StoreLogin> {
    private static final String TAG = StoreLoginCallback.class.getCanonicalName();

    private SignInActivity signInActivity;

    public StoreLoginCallback(SignInActivity signInActivity) {
        this.signInActivity = signInActivity;
    }

    @Override
    public void onSuccess(Call<StoreLogin> call, Response<StoreLogin> response) {
        if (response.body().signed_in) {
            signInActivity.signIn();
        }
    }

    @Override
    public void onAuthFail(Call<StoreLogin> call, Response<StoreLogin> response) {
        // todo: do nothing
        Toast.makeText(signInActivity, "Authentication failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "Authentication failed!");
    }

    @Override
    public void onFail(Call<StoreLogin> call, Response<StoreLogin> response, String message) {
        Toast.makeText(signInActivity, "REST failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "REST failed!");
    }
}
