package com.slicky.ep.astronomy.rest;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

/**
 * Created by SlickyPC on 14.1.2017
 */
public class RestService {
    private static RestApi instance;

    public static synchronized RestApi getInstance() {
        if (instance == null) {
            Gson gson = new GsonBuilder()
                    .setDateFormat("yyyy-MM-dd HH:mm:ss")
                    .create();

            instance = new Retrofit.Builder()
                    .baseUrl(RestApi.URL)
                    .addConverterFactory(GsonConverterFactory.create(gson))
                    .build()
                    .create(RestApi.class);
        }

        return instance;
    }
}
