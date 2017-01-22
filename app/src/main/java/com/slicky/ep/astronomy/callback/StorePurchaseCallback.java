package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.PurchaseActivity;
import com.slicky.ep.astronomy.handler.LoginHandler;
import com.slicky.ep.astronomy.model.StorePurchaseElement;
import retrofit2.Call;
import retrofit2.Response;

import java.util.List;

/**
 * Created by SlickyPC on 21.1.2017
 */
public class StorePurchaseCallback extends StoreCallback<List<StorePurchaseElement>> {

    private PurchaseActivity purchaseActivity;

    public StorePurchaseCallback(PurchaseActivity purchaseActivity) {
        super(purchaseActivity);
        this.purchaseActivity = purchaseActivity;
    }

    @Override
    public void onSuccess(Call<List<StorePurchaseElement>> call, Response<List<StorePurchaseElement>> response) {
        super.onSuccess(call, response);
        List<StorePurchaseElement> items = response.body();
        purchaseActivity.refreshItems(items);
        purchaseActivity.stopRefreshing();
    }

    @Override
    public void onAuthFail(Call<List<StorePurchaseElement>> call, Response<List<StorePurchaseElement>> response) {
        super.onAuthFail(call, response);
        purchaseActivity.stopRefreshing();
        LoginHandler.getInstance().signOut();
    }

    @Override
    public void onFail(Call<List<StorePurchaseElement>> call, Response<List<StorePurchaseElement>> response, String message) {
        super.onFail(call, response, message);
        purchaseActivity.stopRefreshing();
    }
}
