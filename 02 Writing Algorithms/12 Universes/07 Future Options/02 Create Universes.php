<p>To add a universe of Future Option contracts, in the <code>Initialize</code> method, <a href="/docs/v2/writing-algorithms/universes/futures#11-Create-Universes">define a Future universe</a> and then pass the canonical <code>Symbol</code> to the <code>AddFutureOption</code> method.<br></p>

<div class="section-example-container">
    <pre class="csharp">var future = AddFuture(Futures.Metals.Gold);
future.SetFilter(0, 90);
AddFutureOption(future.Symbol);</pre>
    <pre class="python">future = self.AddFuture(Futures.Metals.Gold)
future.SetFilter(0, 90)
self.AddFutureOption(future.Symbol)</pre>
</div>


<p>The following table describes the <code>AddFutureOption</code> method arguments:</p>

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
            <td><code>symbol</code></td>
	        <td><code>Symbol</code></td>
            <td>The Future canonical symbol</td>
            <td></td>
        </tr>
        <tr>
            <td><code>optionFilter</code></td>
	        <td><code class="csharp">Func&lt;OptionFilterUniverse, OptionFilterUniverse&gt;</code><code class="python">Callable[[OptionFilterUniverse], OptionFilterUniverse]</code></td>
            <td>A function that selects Future Option contracts</td>
            <td><code class='csharp'>null</code><code class='python'>None</code></td>
        </tr>
    </tbody>
</table>


<p>To set the <a href='/docs/v2/writing-algorithms/reality-modeling/options-models/pricing'>price model</a> of the Options, set their <code>PriceModel</code> property in a <a href='/docs/v2/writing-algorithms/universes/settings#03-Configure-Universe-Securities'>security initializer</a>.</p>

<div class="section-example-container">
<pre class="csharp">//In Initialize
SetSecurityInitializer(CustomSecurityInitializer);

private void CustomSecurityInitializer(Security security)
{
    if (security.Type == SecurityType.FutureOption)
    {
        security.PriceModel = OptionPriceModels.CrankNicolsonFD();
    }
}
</pre>
<pre class="python">#In Initialize
self.SetSecurityInitializer(self.CustomSecurityInitializer)

def CustomSecurityInitializer(self, security: Security) -&gt; None:
    if security.Type == SecurityType.FutureOption:
        security.PriceModel = OptionPriceModels.CrankNicolsonFD()
</pre>
</div>
