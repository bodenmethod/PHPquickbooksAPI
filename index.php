<?php 

require 'vendor/autoload.php';

use QuickBooksOnline\API\DataService\DataService;

$config = include('config.php');

session_start();

// Prep Data Services
$dataService = DataService::Configure(array(
  'auth_mode' => 'oauth2',
  'ClientID' => $config['client_id'],
  'ClientSecret' =>  $config['client_secret'],
  'RedirectURI' => $config['oauth_redirect_uri'],
  'scope' => $config['oauth_scope'],
  'baseUrl' => "development"
));

$dataService->setLogLocation("/Users/suppo/Desktop/newFolderForLogQB");

$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
// Get the Authorization URL from the SDK
$authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

// Store the url in PHP Session Object;
$_SESSION['authUrl'] = $authUrl;
    
//set the access token using the auth object
if (isset($_SESSION['sessionAccessToken'])) {

    // Retrieve the accessToken value from session variable
    $accessToken = $_SESSION['sessionAccessToken'];
    $accessTokenJson = array('token_type' => 'bearer',
        'access_token' => $accessToken->getAccessToken(),
        'refresh_token' => $accessToken->getRefreshToken(),
        'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
        'expires_in' => $accessToken->getAccessTokenExpiresAt()
    );
    // Update the OAuth2Token of the dataService object
    $dataService->updateOAuth2Token($accessToken);
    $oauthLoginHelper = $dataService -> getOAuth2LoginHelper();
    $CompanyInfo = $dataService->getCompanyInfo();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon icon shortcut" type="image/png" href="https://plugin.intuitcdn.net/sbg-web-shell-ui/6.3.0/shell/harmony/images/QBOlogo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <!-- <link rel="stylesheet" href="views/common.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script>

var url = '<?php echo $authUrl; ?>';

var OAuthCode = function(url) {

    this.loginPopup = function (parameter) {
        this.loginPopupUri(parameter);
    }

    this.loginPopupUri = function (parameter) {

        // Launch Popup
        var parameters = "location=1,width=800,height=650";
        parameters += ",left=" + (screen.width - 800) / 2 + ",top=" + (screen.height - 650) / 2;

        var win = window.open(url, 'connectPopup', parameters);
        var pollOAuth = window.setInterval(function () {
            try {

                if (win.document.URL.indexOf("code") != -1) {
                    window.clearInterval(pollOAuth);
                    win.close();
                    location.reload();
                }
            } catch (e) {
                console.log(e)
            }
        }, 100);
    }
}

var apiCall = function() {
            this.getCompanyInfo = function() {
                /*
                AJAX Request to retrieve getCompanyInfo
                 */
                $.ajax({
                    type: "GET",
                    url: "apiCall.php",
                }).done(function( msg ) {
                    $( '#apiCall' ).html( msg );
                });
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }

var apiCallCusBal = function() {
            this.getServiceContext = function() {
                /*
                AJAX Request to retieve Customer Balance
                 */
                $.ajax({
                    type: "GET",
                    url: "apiCallCusBal.php",
                }).done(function( msg ) {
                    $( '#apiCallCusBal' ).html( msg );
                });
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }

var apiCallProRatedSalesReceiptMonthOne = function() {
            this.getServiceContext = function() {
                /*
                AJAX Request to Create Month One Pro-Rated Sales Receipt
                 */
                $.ajax({
                    type: "GET",
                    url: "apiCallProRatedSalesReceiptMonthOne.php",
                }).done(function( msg ) {
                    $( '#apiCallProRatedSalesReceiptMonthOne' ).html( msg );
                });
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }

var apiCallRecurringSalesReceiptCreate = function() {
            this.getServiceContext = function() {
                /*
                AJAX Request to Create Recurring Transaction
                 */
                $.ajax({
                    type: "GET",
                    url: "apiCallRecurringSalesReceiptCreate.php",
                }).done(function( msg ) {
                    $( '#apiCallRecurringSalesReceiptCreate' ).html( msg );
                });
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }

var apiCallCreateCus = function() {
            this.getServiceContext = function() {
                /*
                AJAX Request to Create Customer
                 */
                $.ajax({
                    type: "GET",
                    url: "apiCallCreateCus.php",
                }).done(function( msg ) {
                    $( '#apiCallCreateCus' ).html( msg );
                });
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }

var apiCallCusSales = function() {
            this.getServiceContext = function() {
                /*
                AJAX Request to retrieve CustomerSales
                 */
                $.ajax({
                    type: "GET",
                    url: "apiCallCusSales.php",
                }).done(function( msg ) {
                    $( '#apiCallCusSales' ).html( msg );
                });
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }

var oauth = new OAuthCode(url);
        var apiCall = new apiCall();
        var apiCallCusBal = new apiCallCusBal();
        var apiCallProRatedSalesReceiptMonthOne = new apiCallProRatedSalesReceiptMonthOne();
        var apiCallRecurringSalesReceiptCreate = new apiCallRecurringSalesReceiptCreate();
        var apiCallCreateCus = new apiCallCreateCus();
        var apiCallCusSales = new apiCallCusSales();
       
    </script>
</head>
<body>

<div class="container">

<hr>

<div class="well text-center">

<h1>QuickBooks App</h1>
        <h2>Connect to QuickBooks flow and API Requests</h2>

        <br>

    </div>

    <p>If there is no access token or the access token is invalid, click the <b>Connect to QuickBooks</b> button below.</p>
    <pre id="accessToken">
        <style="background-color:#efefef;overflow-x:scroll"><?php
    $displayString = isset($accessTokenJson) ? $accessTokenJson : "No Access Token Generated Yet";
    echo json_encode($displayString, JSON_PRETTY_PRINT); ?>
    </pre>
    <button  type="button" class="btn btn-success" onclick="oauth.loginPopup()">Connect to QB</button>
    <hr />

    <h2>Make Get Company Info API call</h2>
    <p>If there is no access token or the access token is invalid, click either the <b>Connect to QuickBooks</b> button above.</p>
    <pre id="apiCall"></pre>
    <button  type="button" class="btn btn-success" onclick="apiCall.getCompanyInfo()">Get Company Info</button>

    <hr />

    <h2>Make Get Customer Balance API call</h2>
    <p>If there is no access token or the access token is invalid, click either the <b>Connect to QuickBooks</b> button above.</p>
    <pre id="apiCallCusBal"></pre>
    <button  type="button" class="btn btn-success" onclick="apiCallCusBal.getServiceContext()">Get Customer Balance</button>

    <hr />

    <h2>Make Create Customer Pro-Rated Sales Receipt MONTH ONE API call</h2>
    <p>If there is no access token or the access token is invalid, click either the <b>Connect to QuickBooks</b> button above.</p>
    <pre id="apiCallProRatedSalesReceiptMonthOne"></pre>
    <button  type="button" class="btn btn-success" onclick="apiCallProRatedSalesReceiptMonthOne.getServiceContext()">Create Month One Pro-Rated Sales Receipt Transaction</button>

    <hr />

    <h2>Make Create Customer Recurring Sales Receipt API call</h2>
    <p>If there is no access token or the access token is invalid, click either the <b>Connect to QuickBooks</b> button above.</p>
    <pre id="apiCallRecurringSalesReceiptCreate"></pre>
    <button  type="button" class="btn btn-success" onclick="apiCallRecurringSalesReceiptCreate.getServiceContext()">Create Recurring Sales Receipt</button>

    <hr />

    <h2>Make Create Customer API call</h2>
    <p>If there is no access token or the access token is invalid, click either the <b>Connect to QuickBooks</b> button above.</p>
    <pre id="apiCallCreateCus"></pre>
    <button  type="button" class="btn btn-success" onclick="apiCallCreateCus.getServiceContext()">Create Customer</button>

    <hr />

    <h2>Make Get Customer Sales API call</h2>
    <p>If there is no access token or the access token is invalid, click either the <b>Connect to QuickBooks</b> button above.</p>
    <pre id="apiCallCusSales"></pre>
    <button  type="button" class="btn btn-success" onclick="apiCallCusSales.getServiceContext()">Get Customer Sales Info</button>

    <hr />

</div>
</body>
</html>
