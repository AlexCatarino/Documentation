<?
$brokerageDetails = "
<li>In the browser window that automatically opens, click <span class='button-name'>Allow</span>.

<div class='cli section-example-container'>
<pre>$ lean cloud live \"My Project\" --push --open
Please open the following URL in your browser to authorize the LEAN CLI.
https://www.quantconnect.com/api/v2/live/auth0/authorize?brokerage=charlesschwab&projectId=&lt;projectId&gt;
Will sleep 5 seconds and retry fetching authorization...
</pre>
</div>
</li>";
$dataProviderDetails = "";
$brokerageName="Charles Schwab";
$dataProviderName=$brokerageName;
$isSupported=true;
$supportsCashHoldings=false;
$supportsPositionHoldings=false;
include(DOCS_RESOURCES."/brokerages/cli-deployment/deploy-cloud-algorithms.php");
?>
