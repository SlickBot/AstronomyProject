package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.ProfileActivity;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StoreUser;
import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreUserCallback
        extends StoreCallback<StoreUser> {

    private ProfileActivity profileActivity;

    public StoreUserCallback(ProfileActivity profileActivity) {
        super(profileActivity);
        this.profileActivity = profileActivity;
    }

    @Override
    public void onSuccess(Call<StoreUser> call, Response<StoreUser> response) {
        StoreUser user = response.body();
        profileActivity.displayUser(user);
    }

    @Override
    public void onAuthFail(Call<StoreUser> call, Response<StoreUser> response) {
        super.onAuthFail(call, response);
        LoginHandler.getInstance().signOut();
    }
}
