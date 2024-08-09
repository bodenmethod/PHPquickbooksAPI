<?php 

require_once(__DIR__ . '/vendor/autoload.php');
use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Utility\Configuration\ConfigurationManager;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Purchase;
use QuickBooksOnline\API\Data\IPPPurchase;
use QuickBooksOnline\API\QueryFilter\QueryMessage;
use QuickBooksOnline\API\ReportService\ReportService;
use QuickBooksOnline\API\ReportService\ReportName;

session_start();

function makeAPICallCusBal()
{

    // Create SDK instance
    $config = include('config.php');
    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => $config['client_id'],
        'ClientSecret' =>  $config['client_secret'],
        'RedirectURI' => $config['oauth_redirect_uri'],
        'scope' => $config['oauth_scope'],
        'baseUrl' => "development"
    ));

    /*
     * Retrieve the accessToken value from session variable
     */
    $accessToken = $_SESSION['sessionAccessToken'];

    /*
     * Update the OAuth2Token of the dataService object
     */
    $dataService->updateOAuth2Token($accessToken);

$dataService->setLogLocation("/Users/suppo/Desktop/newFolderForLogQB");
$serviceContext = $dataService->getServiceContext();

############## CUSTOMER BALANCE REPORT ##############
// Prep Data Services   
$reportService = new ReportService($serviceContext);
if (!$reportService) {
    exit("Problem while initializing ReportService.\n");
}

//Query a report for CustomerBalance using parameters from the CustomerBalance object
$reportService->setCustomer(1);
$reportService->setArpaid("Unpaid");
$reportService->setSummarizeColumnBy("Total");

$customerBalance = $reportService->executeReport(ReportName::CUSTOMERBALANCE);

if (!$customerBalance) {
    exit("Customer Balance Is Null. If this is incorrect please check parameters.\n");
} else {
    $reportName = strtolower($customerBalance->Header->ReportName);
    echo("ReportName: " . $reportName . "\n");
    echo("Customer Balance Report Execution Successful!" . "\n");
    echo '<br>';

    $customerBalanceAmount = strtolower($customerBalance->Rows->Row[0]->ColData[1]->value);
    echo("Customer Balance: " . $customerBalanceAmount . "\n" );

    if ($customerBalanceAmount >0){
        //alert that customer balance is due
        // echo '<script>alert("Customer Balance is Due")</script>';
        //show customer balance with flashing red text **FIND HTML THAT THIS IS CONTAINED IN
        echo '<script src= "https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>		
        setInterval(function(){
            $(".animate").animate({color: "red"}, "slow");
            $(".animate").animate({color: "#000"}, "slow");
        },500);
        </script>
        <h3 class="animate" style="font-weight: bold;font-family:Arial, Helvetica, sans-serif;text-align:center;background-color:yellow;">CUSTOMER BALANCE IS DUE!</h3>';
    }
    
    // echo '<pre>';
    // print_r($customerBalance);
    // echo '</pre>';
}
}

$result = makeAPICallCusBal();
