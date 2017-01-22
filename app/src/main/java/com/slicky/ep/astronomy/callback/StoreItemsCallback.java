package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.BrowseActivity;
import com.slicky.ep.astronomy.model.StoreItem;
import retrofit2.Call;
import retrofit2.Response;

import java.util.List;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreItemsCallback
        extends StoreCallback<List<StoreItem>> {

    private BrowseActivity browseActivity;

    public StoreItemsCallback(BrowseActivity browseActivity) {
        super(browseActivity);
        this.browseActivity = browseActivity;
    }

    @Override
    public void onSuccess(Call<List<StoreItem>> call, Response<List<StoreItem>> response) {
        super.onSuccess(call, response);
        List<StoreItem> items = response.body();
        browseActivity.refreshItems(items);
        browseActivity.stopRefreshing();
    }

    @Override
    public void onAuthFail(Call<List<StoreItem>> call, Response<List<StoreItem>> response) {
        super.onAuthFail(call, response);
        browseActivity.stopRefreshing();
    }

    @Override
    public void onFail(Call<List<StoreItem>> call, Response<List<StoreItem>> response, String message) {
        super.onFail(call, response, message);
        browseActivity.stopRefreshing();
    }
}
