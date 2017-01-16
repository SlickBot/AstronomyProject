package com.slicky.ep.astronomy;

import com.slicky.ep.astronomy.model.StoreItem;
import com.slicky.ep.astronomy.model.StoreLogin;
import com.slicky.ep.astronomy.model.StorePurchase;
import com.slicky.ep.astronomy.model.StoreUser;
import retrofit2.Call;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;

import java.util.List;

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

    public interface RestApi {
        String URL = "http://10.0.2.2:80/netbeans/AstronomyProject/index.php/api/";

        @GET("items")
        Call<List<StoreItem>> getItems();

        @FormUrlEncoded
        @POST("authenticate")
        Call<StoreLogin> authenticate(@Field("username") String username,
                                      @Field("hash") String hash);

        @FormUrlEncoded
        @POST("user")
        Call<StoreUser> getUser(@Field("username") String username,
                                @Field("hash") String hash);

        @FormUrlEncoded
        @POST("purchases")
        Call<List<StorePurchase>> getPurchases(@Field("username") String username,
                                               @Field("hash") String hash);

//        @GET("books/{id}")
//        Call<StoreItem> get(@Path("id") int id);
//
//        @FormUrlEncoded
//        @POST("books")
//        Call<Void> insert(@Field("author") String author,
//                          @Field("title") String title,
//                          @Field("price") double price,
//                          @Field("year") int year,
//                          @Field("description") String description);
//
//        @FormUrlEncoded
//        @PUT("books/{id}")
//        Call<Void> update(@Path("id") int id,
//                          @Field("author") String author,
//                          @Field("title") String title,
//                          @Field("price") double price,
//                          @Field("year") int year,
//                          @Field("description") String description);
    }
}
