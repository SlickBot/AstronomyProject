package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.CartActivity;
import com.slicky.ep.astronomy.handler.CartHandler;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StoreBought;
import com.slicky.ep.astronomy.tools.StoreUtils;
import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by SlickyPC on 21.1.2017
 */
public class StoreBoughtCallback extends StoreCallback<StoreBought> {

    private CartActivity cartActivity;

    public StoreBoughtCallback(CartActivity cartActivity) {
        super(cartActivity);
        this.cartActivity = cartActivity;
    }

    @Override
    public void onSuccess(Call<StoreBought> call, Response<StoreBought> response) {
        super.onSuccess(call, response);
        CartHandler.getInstance().reset();
        cartActivity.refresh();
        StoreUtils.showOkNotification(cartActivity, "Success!", "You bought stuff!");
    }

    @Override
    public void onAuthFail(Call<StoreBought> call, Response<StoreBought> response) {
        super.onAuthFail(call, response);
        LoginHandler.getInstance().signOut();
    }

    @Override
    public void onFail(Call<StoreBought> call, Response<StoreBought> response, String message) {
        super.onFail(call, response, message);
    }
}
