package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.ProfileActivity;
import com.slicky.ep.astronomy.model.StoreEdit;

import android.util.Log;
import android.widget.Toast;

import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreEditCallback
        extends StoreCallback<StoreEdit> {
    private static final String TAG = StoreEditCallback.class.getCanonicalName();

    private ProfileActivity profileActivity;

    public StoreEditCallback(ProfileActivity profileActivity) {
        this.profileActivity = profileActivity;
    }

    @Override
    public void onSuccess(Call<StoreEdit> call, Response<StoreEdit> response) {
        if (response.body().edited) {
            // todo: edit user
        }
    }

    @Override
    public void onAuthFail(Call<StoreEdit> call, Response<StoreEdit> response) {
        // todo: log out
        Toast.makeText(profileActivity, "Authentication failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "Authentication failed!");
    }

    @Override
    public void onFail(Call<StoreEdit> call, Response<StoreEdit> response, String message) {
        Toast.makeText(profileActivity, "REST failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "REST failed!");
    }
}
