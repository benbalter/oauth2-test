<?php

//bootstrap
require_once dirname( __FILE__ ) . '/config.php';
require_once dirname( __FILE__ ) . '/php-oauth2/Client.php';
require_once dirname( __FILE__ ) . '/php-oauth2/GrantType/IGrantType.php';
require_once dirname( __FILE__ ) . '/php-oauth2/GrantType/AuthorizationCode.php';
$client = new Oauth2\Client( CLIENT_ID, CLIENT_SECRET );

//authing
if ( !isset( $_GET['code'] ) ) {
    $auth_url = $client->getAuthenticationUrl( AUTHORIZATION_ENDPOINT, REDIRECT_URI );
    header( 'Location: ' . $auth_url );
    exit();
}

//build signature
$params = array( 'code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI );
$response = $client->getAccessToken( TOKEN_ENDPOINT, 'authorization_code', $params );
parse_str( $response['result'], $info );
$client->setAccessToken( $info['access_token'] );

//grab a dummy response and dump to browser
$response = $client->fetch( 'https://graph.facebook.com/me' );
var_dump( $response, $response['result'] );