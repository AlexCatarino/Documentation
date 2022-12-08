<p>To add a universe of Index Option contracts, in the <code>Initialize</code> method, call the <code>AddIndexOption</code> method. This method returns an <code>Option</code> object, which contains the canonical <code>Symbol</code>. You can't trade with the canonical Option <code>Symbol</code>, but save a reference to it so you can easily access the Option contracts in the <a href='/docs/v2/writing-algorithms/securities/asset-classes/index-options/handling-data#02-Option-Chains'>OptionChain</a> that LEAN passes to the <code>OnData</code> method.</p>


<div class="section-example-container">
    <pre class="csharp">var option = AddIndexOption("VIX");
_symbol = option.Symbol;</pre>
    <pre class="python">option = self.AddIndexOption("VIX")
self.symbol = option.Symbol</pre>
</div>

<p>The following table describes the <code>AddIndexOption</code> method arguments:</p>
<table class="qc-table table">
    <thead>
        <tr>
            <th>Argument</th>
            <th>Data Type</th>
            <th>Description</th>
            <th>Default Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>ticker</code></td>
	        <td><code class="csharp">string</code><code class="python">str</code></td>
            <td>The underlying Index ticker. To view the available indices, see <a href='/datasets/tickdata-us-cash-indices'>US Cash Indices dataset listing</a>.</td>
            <td></td>
        </tr>
        <tr>
            <td><code>resolution</code></td>
	        <td><code class="csharp">Resolution?</code><code class="python">Resolution/NoneType</code></td>
            <td>The resolution of the market data. To view the supported resolutions, see <a href='/docs/v2/writing-algorithms/securities/asset-classes/index-options/requesting-data#03-Resolutions'>Resolutions</a>.</td>
            <td><code class="python">None</code><code class="csharp">null</code></td>
        </tr>
        <tr>
            <td><code>market</code></td>
	        <td><code class="csharp">string</code><code class="python">str</code></td>
            <td>The Index Option market.</td>
            <td><code>Market.USA</code></td>
        </tr>
        <tr>
            <td><code>fillDataForward</code></td>
	        <td><code>bool</code></td>
            <td>If true, the current slice contains the last available data even if there is no data at the current time.</td>
            <td><code class="python">True</code><code class="csharp">true</code></td>
        </tr>
    </tbody>
</table>


<p>If you add an Option universe for an underlying Index that you don't have a subscription for, LEAN automatically subscribes to the underlying Index.</p>


<p>To set the <a href='/docs/v2/writing-algorithms/reality-modeling/options-models/pricing'>price model</a> of the Option, set its <code>PriceModel</code> property.</p>

<div class="section-example-container">
    <pre class="csharp">option.PriceModel = OptionPriceModels.CrankNicolsonFD();</pre>
    <pre class="python">option.PriceModel = OptionPriceModels.CrankNicolsonFD()</pre>
</div>
