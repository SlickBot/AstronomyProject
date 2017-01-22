package com.slicky.ep.astronomy.handler;

/**
 * Created by SlickyPC on 16.1.2017
 */
public class LoginHandler {
    private static final LoginHandler instance = new LoginHandler();

    private Credentials credentials;
    private boolean loggedIn;

    private LoginHandler() {
        loggedIn = false;
    }

    public static LoginHandler getInstance() {
        return instance;
    }

    public void setCredentials(Credentials credentials) {
        this.credentials = credentials;
    }

    public void signIn() {
        this.loggedIn = true;
    }

    public void signOut() {
        this.loggedIn = false;
        this.credentials = null;
        CartHandler.getInstance().reset();
    }

    public Credentials getCredentials() {
        return credentials;
    }
    public boolean isLoggedIn() {
        return loggedIn;
    }


    public static class Credentials {

        private final String username;
        private final String hash;

        public Credentials(String username, String hash) {
            this.username = username;
            this.hash = hash;
        }

        public String getUsername() {
            return username;
        }
        public String getHash() {
            return hash;
        }
    }
}
