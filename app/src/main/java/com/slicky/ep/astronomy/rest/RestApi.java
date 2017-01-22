package com.slicky.ep.astronomy.rest;

import com.slicky.ep.astronomy.model.*;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by SlickyPC on 14.1.2017
 */
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
    @POST("edit_user")
    Call<StoreEdited> editUser(@Field("username") String username,
                               @Field("hash") String hash,
                               @Field("id") String id,
                               @Field("name") String name,
                               @Field("surname") String surname,
                               @Field("email") String email,
                               @Field("phone") String telephone,
                               @Field("address") String address);

    @FormUrlEncoded
    @POST("buy")
    Call<StoreBought> buy(@Field("username") String username,
                          @Field("hash") String hash,
                          @Field("list[]") ArrayList<String> list);

    @FormUrlEncoded
    @POST("purchases")
    Call<List<StorePurchase>> getPurchases(@Field("username") String username,
                                           @Field("hash") String hash);

    @FormUrlEncoded
    @POST("purchase")
    Call<List<StorePurchaseElement>> getPurchaseElement(@Field("username") String username,
                                                        @Field("hash") String hash,
                                                        @Field("id") int id);
}