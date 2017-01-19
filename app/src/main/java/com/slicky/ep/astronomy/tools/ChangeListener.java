package com.slicky.ep.astronomy.tools;

import android.text.Editable;
import android.text.TextWatcher;

/**
 * Created by slicky on 19.1.2017
 */
public abstract class ChangeListener implements TextWatcher {

    @Override
    public void beforeTextChanged(CharSequence s, int start, int count, int after) {}

    @Override
    public void onTextChanged(CharSequence s, int start, int before, int count) {}

    @Override
    public void afterTextChanged(Editable s) {}
}
