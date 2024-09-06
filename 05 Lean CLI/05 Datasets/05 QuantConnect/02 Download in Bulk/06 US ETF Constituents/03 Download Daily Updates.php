<p>After you bulk download the US ETF Constituents dataset, new daily updates are available at 7 AM Eastern Time (ET) after each trading day. To unlock local access to the data updates, open the <a href="https://www.quantconnect.com/pricing">Pricing</a> page of your organization and subscribe to the <span class="button-name">US ETF Constituents Updates by QuantConnect</span> data package. You need <a href="https://www.quantconnect.com/docs/v2/cloud-platform/organizations/members#08-Permissions">billing permissions</a> to change the organization's subscriptions.</p>

<p>After you subscribe to dataset updates, to update your local copy of the US ETF Constituents dataset, open a terminal in your <a href="https://www.quantconnect.com/docs/v2/lean-cli/initialization/organization-workspaces">organization workspace</a> and run:</p>

<div class="cli section-example-container">
     <pre>$ lean data download --dataset "US ETF Constituents" --data-type "Bulk" --start "20090601" --end "20500101"</pre> 
</div>

<p>To update your local copy of the US Equity Security Master, run:</p>
<div class="cli section-example-container">
     <pre>$ lean data download --dataset "US Equity Security Master"</pre> 
</div>

<p>Alternatively, instead of directly calling the <code>lean data download</code> command, you can place a Python script in the <span class="public-directory-name">data</span> directory of your organization workspace and run it to update your data files. The following example script updates all of the new data that's missing from your local copy:</p>

<?
$dataset = "US ETF Constituents";
$dirName = "equity/usa/universes/etf/spy";
include(DOCS_RESOURCES."/datasets/download_bulk_data_script_universe.php");
?>

<p>The preceding script checks the date of the most recent SPY data you have. If there is new data available for SPY, it downloads the new data files for all of the ETFs. You may need to adjust this script to fit your needs.</p>
