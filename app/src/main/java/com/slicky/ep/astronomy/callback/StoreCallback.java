package com.slicky.ep.astronomy.callback;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.io.IOException;

/**
 * Created by slicky on 19.1.2017
 */
abstract class StoreCallback<T> implements Callback<T> {

    @Override
    public void onResponse(Call<T> call, Response<T> response) {
        if (response.isSuccessful() && response.body() != null) {
            onSuccess(call, response);
        } else if (response.code() == 400) {
            onAuthFail(call, response);
        } else {
            String errorMessage;
            try {
                errorMessage = "An error occurred: " + response.errorBody().string();
            } catch (IOException e) {
                errorMessage = "An error occurred: error while decoding the error message.";
            }
            onFail(call, response, errorMessage);
        }
    }

    @Override
    public void onFailure(Call<T> call, Throwable t) {
        onFail(call, null, t.getLocalizedMessage());
    }

    abstract public void onSuccess(Call<T> call, Response<T> response);
    abstract public void onAuthFail(Call<T> call, Response<T> response);
    abstract public void onFail(Call<T> call, Response<T> response, String message);
}
