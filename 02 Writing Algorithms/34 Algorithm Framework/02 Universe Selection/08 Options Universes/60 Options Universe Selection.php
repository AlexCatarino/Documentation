<p>The <code>OptionUniverseSelectionModel</code> selects all the available contracts for the Equity Options, Index Options, and Future Options you specify. To use this model, provide a <code>refreshInterval</code> and a selector function. The <code>refreshInterval</code><code></code> defines how frequently LEAN calls the selector function. The selector function receives a <code class="csharp">DateTime</code><code class="python">datetime</code> object that represents the current Coordinated Universal Time (UTC) and returns a list of <code>Symbol</code> objects. The <code>Symbol</code> objects you return from the selector function are the Options of the universe.</p>

<div class="section-example-container">
	<pre class="csharp">AddUniverseSelection(new OptionUniverseSelectionModel(refreshInterval, optionChainSymbolSelector));</pre>
	<pre class="python">from Selection.OptionUniverseSelectionModel import OptionUniverseSelectionModel 

self.AddUniverseSelection(OptionUniverseSelectionModel(refreshInterval, optionChainSymbolSelector))</pre>
</div>

<p>The following table describes the arguments the model accepts:</p>

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
            <td><code>refreshInterval</code></td>
	    <td><code class="csharp">TimeSpan</code><code class="python">timedelta</code></td>
            <td>Time interval between universe refreshes</td>
            <td></td>
        </tr>
        <tr>
            <td><code>optionChainSymbolSelector</code></td>
	    <td><code class="csharp">Func&lt;DateTime, IEnumerable&lt;Symbol&gt;&gt;</code><code class="python">Callable[datetime, List[Symbol]]</code></td>
            <td>A function that selects the Option symbols<br></td>
            <td></td>
        </tr>
        <tr>
            <td><code>universeSettings</code></td>
	    <td><code>UniverseSettings</code></td>
            <td>Universe settings define attributes of created subscriptions, such as their resolution and the minimum time in universe before they can be removed</td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
    </tbody>
</table>

<p>If you don't provide a <code>universeSettings</code> argument, the <code>algorithm.UniverseSettings</code> is used by default.</p>

<div class="section-example-container">
	<pre class="csharp">public override void Initialize()
{
    AddUniverseSelection(
        new OptionUniverseSelectionModel(TimeSpan.FromDays(1), SelectOptionChainSymbols)
    );
}

private IEnumerable&lt;Symbol&gt; SelectOptionChainSymbols(DateTime utcTime)
{
    // Equity Options example:
    //var tickers = new[] {"SPY", "QQQ", "TLT"};
    //return tickers.Select(ticker =&gt; QuantConnect.Symbol.Create(ticker, SecurityType.Option, Market.USA));

    // Index Options example:
    //var tickers = new[] {"VIX", "SPX"};
    //return tickers.Select(ticker =&gt; QuantConnect.Symbol.Create(ticker, SecurityType.IndexOption, Market.USA));

    // Future Options example:
    var futureSymbol = QuantConnect.Symbol.Create(Futures.Indices.SP500EMini, SecurityType.Future, Market.CME);
    var futureContractSymbols = FutureChainProvider.GetFutureContractList(futureSymbol, Time);
    foreach (var symbol in futureContractSymbols)
    {
        yield return QuantConnect.Symbol.CreateCanonicalOption(symbol);
    }
}</pre>
	<pre class="python">from Selection.OptionUniverseSelectionModel import OptionUniverseSelectionModel 

def Initialize(self) -&gt; None:
    universe = OptionUniverseSelectionModel(timedelta(days=1), self.option_chain_symbol_selector)
    self.SetUniverseSelection(universe)

def option_chain_symbol_selector(self, utc_time: datetime) -&gt; List[Symbol]:
    # Equity Options example:
    #tickers = ["SPY", "QQQ", "TLT"]
    #return [Symbol.Create(ticker, SecurityType.Option, Market.USA) for ticker in tickers]

    # Index Options example:
    #tickers = ["VIX", "SPX"]
    #return [Symbol.Create(ticker, SecurityType.IndexOption, Market.USA) for ticker in tickers]

    # Future Options example:
    future_symbol = Symbol.Create(Futures.Indices.SP500EMini, SecurityType.Future, Market.CME)
    future_contract_symbols = self.FutureChainProvider.GetFutureContractList(future_symbol, self.Time)
    return [Symbol.CreateCanonicalOption(symbol) for symbol in future_contract_symbols]</pre>
</div>

<p>To view the implementation of this model, see the <span class="csharp"><a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Framework/Selection/OptionUniverseSelectionModel.cs">LEAN GitHub repository</a></span><span class="python"><a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Framework/Selection/OptionUniverseSelectionModel.py">LEAN GitHub repository</a></span>.</p>


<p>This model uses the default Option filter, which selects the Option contracts with the following characteristics at every time step:</p>

<?php echo file_get_contents(DOCS_RESOURCES."/universes/option/default-filter.html");?>

<p>To use a different filter for the contracts, subclass the <code>OptionUniverseSelectionModel</code> and define a <code>Filter</code> method. The <code>Filter</code> method accepts and returns an <code>OptionFilterUniverse</code> object to select the Option contracts. The following table describes the methods of the <code>OptionFilterUniverse</code> class:</p>

<?php echo file_get_contents(DOCS_RESOURCES."/universes/option/option-filter-universe.html"); ?>
	
<p>Depending on how you define the contract filter, LEAN may call it once a day or at every time step. For a full example of a <code>OptionUniverseSelectionModel</code> subclass, see the <span class="python"><a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Python/BasicTemplateOptionsFrameworkAlgorithm.py">BasicTemplateOptionsFrameworkAlgorithm</a></span><span class="csharp"><a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.CSharp/BasicTemplateOptionsFrameworkAlgorithm.cs">BasicTemplateOptionsFrameworkAlgorithm</a></span>.</p> 
