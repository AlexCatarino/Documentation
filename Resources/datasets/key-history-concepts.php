<?php
$getKeyHistoryConceptsText = function($isWritingAlgorithms)
{
    $universeText = $isWritingAlgorithms ? "the entire universe" : "all of the assets you created subscriptions for in the notebook" ;
    $timeZoneLink = $isWritingAlgorithms ? "/docs/v2/writing-algorithms/initialization#12-Set-Time-Zone" : "/docs/v2/research-environment/initialization#04-Set-Time-Zone" ;
    $timeZoneName = $isWritingAlgorithms ? "algorithm" : "notebook" ;
    
    echo "
    
<p>The historical data API has many different options to give you the greatest flexibility in how to apply it to your algorithm.</p>


<h4>Time Period Options</h4>
<p>You can request historical data based on a trailing number of bars, a trailing period of time, or a defined period of time. If you request data in a defined period of time, the <code class='csharp'>DateTime</code><code class='python'>datetime</code> objects you provide are based in the <a href='{$timeZoneLink}'>{$timeZoneName} time zone</a>.</p>

<h4>Return Formats</h4>
<p>Each asset class supports slightly different data formats. When you make a history request, consider what data returns. Depending on how you request the data, history requests return a specific data type. For example, if you don't provide <code>Symbol</code> objects, you get <code>Slice</code> objects that contain {$universeText}.</p>

<p class='python'>The most popular return type is a <code>DataFrame</code>. If you request a <code>DataFrame</code>, LEAN unpacks the data from <code>Slice</code> objects to populate the <code>DataFrame</code>. If you intend to use the data in the <code>DataFrame</code> to create <code>TradeBar</code> or <code>QuoteBar</code> objects, request that the history request returns the data type you need. Otherwise, LEAN will waste computational resources populating the <code>DataFrame</code>.</p>


<h4>Time Index</h4>

<p><span class='python'>When your history request returns a <code>DataFrame</code>, the timestamps in the <code>DataFrame</code> are based on the <a href='/docs/v2/writing-algorithms/key-concepts/time-modeling/time-zones#05-Data-Time-Zone'>data time zone</a>.</span> When your history request returns a <code>TradeBars</code>, <code>QuoteBars</code>, <code>Ticks</code>, or <code>Slice</code> object, the <code>Time</code> properties of these objects are based on the {$timeZoneName} time zone, but the <code>EndTime</code> properties of the individual <code>TradeBar</code>, <code>QuoteBar</code>, and <code>Tick</code> objects are based on the data time zone. The <code>EndTime</code> is the end of the sampling period and when the data is actually available. For daily US Equity data, this results in data points appearing on Saturday and skipping Monday.</p>
    
    
";
}

?>
