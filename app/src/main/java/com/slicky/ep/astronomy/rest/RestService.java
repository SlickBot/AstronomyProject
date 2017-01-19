package com.slicky.ep.astronomy.rest;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

/**
 * Created by SlickyPC on 14.1.2017
 */
public class RestService {
    private static RestApi instance;

    public static synchronized RestApi getInstance() {
        if (instance == null) {
            instance = new Retrofit.Builder()
                    .baseUrl(RestApi.URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build()
                    .create(RestApi.class);
        }
        return instance;
    }
}
