package com.slicky.ep.astronomy.tools;

import android.content.Context;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.util.Patterns;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import com.slicky.ep.astronomy.R;

import java.security.MessageDigest;

/**
 * Created by SlickyPC on 14.1.2017
 */
public class StoreUtils {

    public static String SHA1(String text) {
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-1");
            byte[] textBytes = text.getBytes("iso-8859-1");
            md.update(textBytes, 0, textBytes.length);
            byte[] sha1hash = md.digest();
            return convertToHex(sha1hash);
        } catch (Exception e) {
            return null;
        }
    }

    public static String MD5(String text) {
        try {
            MessageDigest md = MessageDigest.getInstance("MD5");
            byte[] textBytes = text.getBytes("iso-8859-1");
            md.update(textBytes, 0, textBytes.length);
            byte[] sha1hash = md.digest();
            return convertToHex(sha1hash);
        } catch (Exception e) {
            return null;
        }
    }

    private static String convertToHex(byte[] data) {
        StringBuilder buf = new StringBuilder();
        for (byte b : data) {
            int halveByte = (b >>> 4) & 0x0F;
            int twoHalves = 0;
            do {
                buf.append((0 <= halveByte) && (halveByte <= 9)
                        ? (char) ('0' + halveByte)
                        : (char) ('a' + (halveByte - 10)));
                halveByte = b & 0x0F;
            } while (twoHalves++ < 1);
        }
        return buf.toString();
    }

    public static void hideInput(AppCompatActivity activity) {
        InputMethodManager inputManager = (InputMethodManager) activity
                        .getBaseContext()
                        .getSystemService(Context.INPUT_METHOD_SERVICE);
        View focused = activity.getCurrentFocus();
        if (focused != null) {
            inputManager.hideSoftInputFromWindow(
                    focused.getWindowToken(),
                    InputMethodManager.HIDE_NOT_ALWAYS);
        }
    }

    public static boolean isValidEmail(CharSequence email) {
        return email != null && Patterns.EMAIL_ADDRESS.matcher(email).matches();
    }

    public static void showOkNotification(Context context, String title, String message) {
        new AlertDialog.Builder(context)
                .setTitle(title)
                .setMessage(message)
                .setNeutralButton(android.R.string.ok, null)
                .setIcon(R.drawable.ic_done)
                .show();
    }

    public static void showErrorNotification(Context context, String title, String message) {
        new AlertDialog.Builder(context)
                .setTitle(title)
                .setMessage(message)
                .setNeutralButton(android.R.string.ok, null)
                .setIcon(android.R.drawable.ic_delete)
                .show();
    }
}
