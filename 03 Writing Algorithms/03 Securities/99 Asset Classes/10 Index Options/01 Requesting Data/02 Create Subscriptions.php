<p>Before you can subscribe to an Index Option contract, you must configure the underlying Index and get the contract <code>Symbol</code>.</p>

<h4>Configure the Underlying Index</h4>
<p>In the <code>Initialize</code> method, <a href='/docs/v2/writing-algorithms/securities/asset-classes/index/requesting-data#02-Create-Subscriptions'>subscribe to the underlying Index</a>.</p>

<div class="section-example-container">
    <pre class="csharp">_symbol = AddIndex("SPX").Symbol;</pre>
    <pre class="python">self.symbol = self.AddIndex("SPX").Symbol</pre>
</div>

<?php echo file_get_contents(DOCS_RESOURCES."/reality-modeling/volatility-model.html"); ?>

<h4>Get Contract Symbols</h4>
<p>To get Index Option contract <code>Symbol</code> objects, call the <code>CreateOption</code> method or use the <code>OptionChainProvider</code>. If you use the <code>CreateOption</code> method, you need to know the specific contract details.</p>

<div class="section-example-container">
    <pre class="csharp">_symbol = QuantConnect.Symbol.Create("SPX", SecurityType.Index, Market.USA);

// Standard contracts
_contractSymbol = QuantConnect.Symbol.CreateOption(_symbol, Market.USA,
    OptionStyle.European, OptionRight.Call, 3650, new DateTime(2022, 6, 17));

// Weekly contracts
_weeklyContractSymbol = QuantConnect.Symbol.CreateOption(_symbol, "SPXW", Market.USA,
    OptionStyle.European, OptionRight.Call, 3650, new DateTime(2022, 6, 17));</pre>
    <pre class="python">self.symbol = Symbol.Create("SPX", SecurityType.Index, Market.USA)

# Standard contracts
self.contract_symbol = Symbol.CreateOption(self.symbol, Market.USA,
    OptionStyle.European, OptionRight.Call, 3650, datetime(2022, 6, 17))

# Weekly contracts
self.weekly_contract_symbol = Symbol.CreateOption(self.symbol, "SPXW", Market.USA,
    OptionStyle.European, OptionRight.Call, 3650, datetime(2022, 6, 17))</pre>
</div>

<p>To view all the available weekly Index Options, see <a href='/docs/v2/writing-algorithms/datasets/algoseek/us-index-options#05-Supported-Assets'>Supported Assets</a>.</p>

<p>Another way to get an Index Option contract <code>Symbol</code> is to use the <code>OptionChainProvider</code>. The <code>GetOptionContractList</code> method of <code>OptionChainProvider </code>returns a list of <code>Symbol</code> objects that reference the available Option contracts for a given underlying Index on a given date. To filter and select contracts, you can use the following properties of each <code>Symbol</code> object:</p>
    <table class="qc-table table">
        <thead>
            <tr>
                <th>Property</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td><code>ID.Date</code></td>
                 <td>The expiration date of the contract.</td>
            </tr>
            <tr>
                 <td><code>ID.StrikePrice</code></td>
                 <td>The strike price of the contract.</td>
            </tr>
            <tr>
                 <td><code>ID.OptionRight</code></td>
                 <td>
                     The contract type. The <code>OptionRight</code> enumeration has the following members:
                     <div data-tree="QuantConnect.OptionRight"></div>
                  </td>
            </tr>
            <tr>
                 <td><code>ID.OptionStyle</code></td>
                 <td>
                     The contract style. The <code>OptionStyle</code> enumeration has the following members:
                     <div data-tree="QuantConnect.OptionStyle"></div>
                  </td>
            </tr>
        </tbody>
    </table>

<div class="section-example-container">
    <pre class="csharp">var contractSymbols = OptionChainProvider.GetOptionContractList(_symbol, Time);
var expiry = contractSymbols.Select(symbol =&gt; symbol.ID.Date).Min();
var filteredSymbols = contractSymbols.Where(symbol =&gt; symbol.ID.Date == expiry &amp;&amp; symbol.ID.OptionRight == OptionRight.Call);
_contractSymbol = filteredSymbols.OrderByDescending(symbol =&gt; symbol.ID.StrikePrice).Last();</pre>
    <pre class="python">contract_symbols = self.OptionChainProvider.GetOptionContractList(self.symbol, self.Time)
expiry = min([symbol.ID.Date for symbol in contract_symbols])
filtered_symbols = [symbol for symbol in contract_symbols if symbol.ID.Date == expiry and symbol.ID.OptionRight == OptionRight.Call]
self.contract_symbol = sorted(filtered_symbols, key=lambda symbol: symbol.ID.StrikePrice)[0]</pre>
</div>

<p>The <code>GetOptionContractList</code> isn't currently fully functional for weekly contracts. To track our progress of updating it, subscribe to <a href='https://github.com/QuantConnect/Lean/issues/6872' rel='nofollow' target='_blank'>GitHub Issue #6872</a>.</p> 

<h4>Subscribe to Contracts</h4>
<p>To create an Index Option contract subscription, pass the contract <code>Symbol</code> to the <code>AddIndexOptionContract</code> method. Save a reference to the contract <code>Symbol</code> so you can easily access the contract in the <a href="/docs/v2/writing-algorithms/securities/asset-classes/index-options/handling-data#02-Option-Chains">OptionChain</a> that LEAN passes to the <code>OnData</code> method. To override the default <a href="/docs/v2/writing-algorithms/reality-modeling/options-models/pricing">pricing model</a> of the Option, <a href='https://www.quantconnect.com/docs/v2/writing-algorithms/reality-modeling/options-models/pricing#04-Set-Models'>set a pricing model</a>.</p>

<div class="section-example-container">
    <pre class="csharp">var option = AddIndexOptionContract(_contractSymbol);
option.PriceModel = OptionPriceModels.BlackScholes();<br></pre>
    <pre class="python">option = self.AddIndexOptionContract(self.contract_symbol)
option.PriceModel = OptionPriceModels.BlackScholes()<br></pre>
</div>

<p>The <code>AddIndexOptionContract</code> method creates a subscription for a single Index Option contract and adds it to your <span class="new-term">user-defined</span> universe. To create a dynamic universe of Index Option contracts, add an <a href="/docs/v2/writing-algorithms/universes/index-options">Index Option universe</a>.</p>

<h4>Warm Up Contract Prices</h4>
<p>If you subscribe to an Index Option contract with <code>AddIndexOptionContract</code>, you'll need to wait until the next <code>Slice</code> to receive data and trade the contract. To trade the contract in the same time step you subscribe to the contract, set the current price of the contract in a <a href='/docs/v2/writing-algorithms/initialization#07-Set-Security-Initializer'>security initializer</a>.</p>
<div class="section-example-container">
    <pre class="csharp">var seeder = new FuncSecuritySeeder(GetLastKnownPrices);
SetSecurityInitializer(new BrokerageModelSecurityInitializer(BrokerageModel, seeder, this));</pre>
    <pre class="python">seeder = FuncSecuritySeeder(self.GetLastKnownPrices)
self.SetSecurityInitializer(BrokerageModelSecurityInitializer(self.BrokerageModel, seeder, self))</pre>
</div>

<h4>Supported Assets</h4>
<p>To view the supported assets in the US Index Options dataset, see the <a href="/docs/v2/writing-algorithms/datasets/tickdata/us-cash-indices#05-Supported-Indices">Supported Indices</a>.</p>
