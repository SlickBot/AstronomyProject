package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.ProfileActivity;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StoreEdited;
import com.slicky.ep.astronomy.tools.StoreUtils;
import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreEditCallback
        extends StoreCallback<StoreEdited> {

    private ProfileActivity profileActivity;

    public StoreEditCallback(ProfileActivity profileActivity) {
        super(profileActivity);
        this.profileActivity = profileActivity;
    }

    @Override
    public void onSuccess(Call<StoreEdited> call, Response<StoreEdited> response) {
        if (response.body().edited) {
            StoreUtils.showOkNotification(profileActivity, "Success!", "You have successfully edited your profile!");
        } else {
            StoreUtils.showErrorNotification(profileActivity, "Did not edit", "Could not edit your profile.");
        }
    }

    @Override
    public void onAuthFail(Call<StoreEdited> call, Response<StoreEdited> response) {
        super.onAuthFail(call, response);
        LoginHandler.getInstance().signOut();
    }
}
