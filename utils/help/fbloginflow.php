<?php
/**
 * Created by PhpStorm.
 * User: nrohler
 * Date: 4/6/19
 */
/*
Notes regarding FB login integration flow:

In users table, create additional columns:
    oauth_provider = null|facebook|google etc
    oauth_token = the oauth access token will be stored here... use varchar(255)
    oauth_uid = the user id will go here... use varchar(255)
Have signup/signin with FB option for the login page
Follow the examples for the pages to have the redirect etc.
On the redirect, have logic like this:

if (user is logged into valid account) {
    // associate this fb account with an existing account
    //store the oauth_token and oauth_uid in the user database row associated with the current user
} else {
    // this user isn't logged in, so see if this fb id is already associated with a user...
    let uid = uid from facebook
    if (select * from user where oauth_provider=facebook and oauth_uid=uid => has result) {
        // existing user row found; create a session for that user; also, update the access token for future use
    } else {
        // this is a new user; get name, etc from graph API and insert a new row into the users table (be sure to store the oauth_uid and oauth_token for future access)
    }
}