package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.ProfileActivity;
import com.slicky.ep.astronomy.model.StoreUser;

import android.util.Log;
import android.widget.Toast;

import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreUserCallback
        extends StoreCallback<StoreUser> {
    private static final String TAG = StoreUserCallback.class.getCanonicalName();

    private ProfileActivity profileActivity;

    public StoreUserCallback(ProfileActivity profileActivity) {
        this.profileActivity = profileActivity;
    }

    @Override
    public void onSuccess(Call<StoreUser> call, Response<StoreUser> response) {
        StoreUser user = response.body();
        profileActivity.displayUser(user);
    }

    @Override
    public void onAuthFail(Call<StoreUser> call, Response<StoreUser> response) {
        // todo: log out
        Toast.makeText(profileActivity, "Authentication failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "Authentication failed!");
    }

    @Override
    public void onFail(Call<StoreUser> call, Response<StoreUser> response, String message) {
        Toast.makeText(profileActivity, "REST failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "REST failed!");
    }
}
