package com.slicky.ep.astronomy.callback;

import com.slicky.ep.astronomy.activity.BrowseActivity;
import com.slicky.ep.astronomy.model.StoreItem;

import android.util.Log;
import android.widget.Toast;

import retrofit2.Call;
import retrofit2.Response;

import java.util.List;

/**
 * Created by slicky on 19.1.2017
 */
public class StoreItemCallback
        extends StoreCallback<List<StoreItem>> {
    private static final String TAG = StoreEditCallback.class.getCanonicalName();

    private BrowseActivity browseActivity;

    public StoreItemCallback(BrowseActivity browseActivity) {
        this.browseActivity = browseActivity;
    }

    @Override
    public void onSuccess(Call<List<StoreItem>> call, Response<List<StoreItem>> response) {
        List<StoreItem> items = response.body();
        browseActivity.refreshItems(items);
        // todo: maybe stopRefreshing?
    }

    @Override
    public void onAuthFail(Call<List<StoreItem>> call, Response<List<StoreItem>> response) {
        // not happening here
        // todo: maybe stopRefreshing?
    }

    @Override
    public void onFail(Call<List<StoreItem>> call, Response<List<StoreItem>> response, String message) {
        Toast.makeText(browseActivity, "REST failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "REST failed!");
        // todo: maybe stopRefreshing?
    }
}
