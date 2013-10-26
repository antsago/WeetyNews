<?php

require_once(__DIR__."/../Libraries/AccessTokenAuthentication.php");
require_once(__DIR__."/../Libraries/HTTPTranslator.php");


/**
 * Class used to provide translation services via the Microsoft Translatin API
 */
class TranslationService
{

  public $translatorObj;

  public $authHeader;

  public function __construct()
  {
    //We are hiding the access keys from the git repo, if you need them
    //contact a contributor. If you need to change this file do:
    //   git update-index --no-assume-unchanged translation_service.php
    // delete the clientID and the clientSecret
    // commit the changes
    //   git update-index --assume-unchanged translation_service.php
    // and now you can safely add back the keys and use git commit -a
    //

    //Client ID of the application.
    $clientID       = 
    //Client Secret key of the application.
    $clientSecret = 
    //OAuth Url.
    $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
    //Application Scope Url
    $scopeUrl     = "http://api.microsofttranslator.com";
    //Application grant type
    $grantType    = "client_credentials";

    //Create the AccessTokenAuthentication object.
    $authObj      = new AccessTokenAuthentication();
    //Get the Access token.
    $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
    //Create the authorization Header string.
    $this->authHeader = "Authorization: Bearer ". $accessToken;
    
    //Create the Translator Object.
    $this->translatorObj = new HTTPTranslator();
  }

  /**
   * Function to translate a text
   * Parameters: text to translate, original language, language to translate to
   * Return: tranlated text
   */
  public function translate($text, $from, $to)
  {
    $translateMethodUrl = "http://api.microsofttranslator.com/V2/Http.svc/Translate?text=";
    $translateMethodUrl .= urlencode($text) . "&from=$from&to=$to";

    //Call the curlRequest
    $strResponse = $this->translatorObj->curlRequest($translateMethodUrl, $this->authHeader);
    return $strResponse;
  }

  //TODO:Check this works and write the return description
  public function getAvailableLanguages()
  {
    $requestUrl = "http://api.microsofttranslator.com/V2/Ajax.svc/GetLanguagesForTranslate";
    
    //Call the curlRequest.
    $listOfLanguages = $this->translatorObj->curlRequest($requestUrl, $this->authHeader);
    return $listOfLanguages;
  }
}
?>
