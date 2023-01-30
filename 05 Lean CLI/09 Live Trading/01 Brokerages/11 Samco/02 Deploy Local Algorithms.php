<?
$brokerageName = "Samco";
$dataFeedName = "";
$isBrokerage = true;
$brokerageDetails = "
<li>Enter your Samco credentials.
<div class='cli section-example-container'>
<pre>$ lean live \"My Project\"
Client ID:
Client Password:</pre>
</div>
</li>


<li>Enter your year of birth.
<div class='cli section-example-container'>
<pre>$ lean live \"My Project\"
Year of Birth:</pre>
</div>
</li>


<li>Enter the product type.
<div class='cli section-example-container'>
<pre>$ lean live \"My Project\"
Product type (mis, cnc, nrml):</pre>
</div>

<p>The following table describes the product types:</p>
<table class='qc-table table'>
    <thead>
        <tr>
            <th style='width: 25%'>Product Type</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>mis</code></td>
            <td>Intraday products</td>
        </tr>
        <tr>
            <td><code>cnc</code></td>
            <td>Delivery products</td>
        </tr>
        <tr>
            <td><code>nrml</code></td>
            <td>Carry forward products</td>
        </tr>
    </tbody>
</table>
</li>


<li>Enter the trading segment.
<div class='cli section-example-container'>
<pre>$ lean live \"My Project\"
Trading segment (equity, commodity):</pre>
</div>

<p>The following table describes when to use each trading segment:</p>
<table class='qc-table table'>
    <thead>
        <tr>
            <th style='width: 25%'>Trading Segment</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>equity</code></td>
            <td>For trading Equities on the National Stock Exchange of India (NSE) or the Bombay Stock Exchange (BSE)</td>
        </tr>
        <tr>
            <td><code>commodity</code></td>
            <td>For trading commodities on the Multi Commodity Exchange of India (MCX)</td>
        </tr>
    </tbody>
</table>
</li>
";
$dataFeedDetails = "";
$supportsIQFeed = false;
$requiresSubscription = true;
include(DOCS_RESOURCES."/brokerages/cli-deployment/deploy-local-algorithms.php");
?>
