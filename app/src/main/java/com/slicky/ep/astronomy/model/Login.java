package com.slicky.ep.astronomy.model;

/**
 * Created by SlickyPC on 16.1.2017
 */
public class Login {
    private static final Login instance = new Login();

    private Credentials credentials;
    private boolean loggedIn;

    private Login() {
        loggedIn = false;
    }

    public static Login getInstance() {
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
