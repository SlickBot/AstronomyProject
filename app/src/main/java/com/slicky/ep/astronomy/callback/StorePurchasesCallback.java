package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.PurchasesActivity;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StorePurchase;
import retrofit2.Call;
import retrofit2.Response;

import java.util.List;

/**
 * Created by SlickyPC on 21.1.2017
 */
public class StorePurchasesCallback
        extends StoreCallback<List<StorePurchase>> {

    private PurchasesActivity purchasesActivity;

    public StorePurchasesCallback(PurchasesActivity purchasesActivity) {
        super(purchasesActivity);
        this.purchasesActivity = purchasesActivity;
    }

    @Override
    public void onSuccess(Call<List<StorePurchase>> call, Response<List<StorePurchase>> response) {
        super.onSuccess(call, response);
        List<StorePurchase> items = response.body();
        purchasesActivity.refreshItems(items);
        purchasesActivity.stopRefreshing();
    }

    @Override
    public void onAuthFail(Call<List<StorePurchase>> call, Response<List<StorePurchase>> response) {
        super.onAuthFail(call, response);
        purchasesActivity.stopRefreshing();
        LoginHandler.getInstance().signOut();
    }

    @Override
    public void onFail(Call<List<StorePurchase>> call, Response<List<StorePurchase>> response, String message) {
        super.onFail(call, response, message);
        purchasesActivity.stopRefreshing();
    }
}
