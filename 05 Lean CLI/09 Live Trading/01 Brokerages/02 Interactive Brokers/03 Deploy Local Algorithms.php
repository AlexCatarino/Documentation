<p>If you have an ARM M1, M2, or M3 chip, you can't deploy a local live algorithm with the IB brokerage, see the <a href="/docs/v2/lean-cli/live-trading/brokerages/interactive-brokers#09-Troubleshooting">Troubleshooting</a>.</p>

<?
$brokerageName = "<a rel='nofollow' target='_blank' href='https://qnt.co/interactivebrokers'>Interactive Brokers</a>
";
$dataFeedName = "";
$isBrokerage = true;

ob_start();
$isLocalDeployment = true;
$extraText = "Enter a time on Sunday to receive the notification.";
include(DOCS_RESOURCES."/brokerages/interactive-brokers/weekly-restarts.php");
$weeklyRestartText = ob_get_clean();

$brokerageDetails = "
<li>Set up IB Key Security via IBKR Mobile. For instructions, see <a href='https://ibkrguides.com/securelogin/sls/ibkrmobile.htm' target='_blank' rel='nofollow'>IB Key Security via IBKR Mobile</a> on the IB website.</li>

<li>Go back to the terminal and enter your Interactive Brokers username, account id, and password.
<div class='cli section-example-container'>
<pre>$ lean live \"My Project\"
Username: trader777
Account id: DU1234567
Account password: ****************</pre>
</div>
</li>

<li>Enter a weekly restart time that's convenient for you.
<div class='cli section-example-container'>
<pre>$ lean live \"My Project\"
Weekly restart UTC time (hh:mm:ss) [21:00:00]: </pre>
</div>
{$weeklyRestartText}
</li>
";

$dataFeedDetails = "
<li>Enter whether you want to enable delayed market data.
<div class='cli section-example-container'>
<pre>$ lean live \"My Project\"
Enable delayed market data? [yes/no]: </pre>
</div>
This property configures the behavior when your algorithm attempts to subscribe to market data for which you don't have a market data subscription on Interactive Brokers. When enabled, your algorithm continues running using delayed market data. Delayed market data is on a time lag that is usually 10-20 minutes behind real-time quotes, see <a href='https://ibkrguides.com/kb/delayed-market-data-timing.htm' target='_blank' rel='nofollow'>Delayed Market Data Timing</a> for more information. When disabled, live trading will stop and LEAN will shut down.
</li>
";

$supportsIQFeed = true;
$requiresSubscription = true;
include(DOCS_RESOURCES."/brokerages/cli-deployment/deploy-local-algorithms.php");
?>
