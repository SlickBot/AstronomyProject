package com.slicky.ep.astronomy.callback;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;
import okio.Buffer;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.io.IOException;

/**
 * Created by slicky on 19.1.2017
 */
abstract class StoreCallback<T> implements Callback<T> {
    private final String TAG = getClass().getCanonicalName();

    private final Context context;

    StoreCallback(Context context) {
        this.context = context;
    }

    @Override
    public final void onResponse(Call<T> call, Response<T> response) {
        if (response.isSuccessful() && response.body() != null) {
            onSuccess(call, response);
        } else if (response.code() == 401) {
            onAuthFail(call, response);
        } else {
            try {
                String message = response.errorBody().string();
                onFail(call, response, message);
            } catch (IOException e) {
                String message = "Error while decoding the error message.";
                onFail(call, response, message);
            }
        }
    }

    @Override
    public final void onFailure(Call<T> call, Throwable t) {
        onFail(call, null, t.toString());
    }

    public void onSuccess(Call<T> call, Response<T> response) {
        Log.v(TAG, "Response successful");
    }

    public void onAuthFail(Call<T> call, Response<T> response) {
        Toast.makeText(context, "Authentication failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "Authentication failed!");
    }

    public void onFail(Call<T> call, Response<T> response, String message) {
        Toast.makeText(context, "REST failed!", Toast.LENGTH_SHORT).show();
        Log.e(TAG, "REST failed! " + message);
        if (call.request().body() != null) {
            final Buffer buffer = new Buffer();
            try {
                call.request().body().writeTo(buffer);
                Log.v("uizgasd", buffer.readUtf8());
            } catch (IOException e) {}
        }
    }
}
