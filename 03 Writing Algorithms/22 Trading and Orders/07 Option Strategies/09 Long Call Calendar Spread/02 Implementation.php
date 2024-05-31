<p>Follow these steps to implement the long call calendar spread strategy:</p>

<ol>
    <li>In the <code class="csharp">Initialize</code><code class="python">initialize</code> method, set the start date, end date, cash, and <a href="/docs/v2/writing-algorithms/universes/equity-options">Option universe</a>.</li>
    <div class="section-example-container">
        <pre class="csharp">private Symbol _symbol;

public override void Initialize()
{
    SetStartDate(2017, 2, 1);
    SetEndDate(2017, 2, 19);
    SetCash(500000);
    UniverseSettings.Asynchronous = true;
    var option = AddOption("GOOG", Resolution.Minute);
    _symbol = option.Symbol;
    option.SetFilter(universe =&gt; universe.IncludeWeeklys().Strikes(-1, 1).Expiration(0, 62));
}</pre>
        <pre class="python">def initialize(self) -&gt; None:
    self.set_start_date(2017, 2, 1)
    self.set_end_date(2017, 2, 19)
    self.set_cash(500000)
    self.universe_settings.asynchronous = True
    option = self.add_option("GOOG", Resolution.MINUTE)
    self._symbol = option.symbol
    option.set_filter(lambda universe: universe.include_weeklys().strikes(-1, 1).expiration(0, 62))</pre>
    </div>
</ol>

<h4>Using Helper strategies</h4>
<ol>
    <li>In the <code class="csharp">OnData</code><code class="python">on_data</code> method, select the expiration and strikes of the contracts in the strategy legs.</li>
    <div class="section-example-container">
        <pre class="csharp">public override void OnData(Slice slice)
{
    if (Portfolio.Invested) return;

    // Get the OptionChain
    var chain = slice.OptionChains.get(_symbol, null);
    if (chain == null || chain.Count() == 0) return;

    // Get the ATM strike
    var atmStrike = chain.OrderBy(x =&gt; Math.Abs(x.Strike - chain.Underlying.Price)).First().Strike;

    // Select the ATM call Option contracts
    var calls = chain.Where(x =&gt; x.Strike == atmStrike &amp;&amp; x.Right == OptionRight.Call);
    if (calls.Count() == 0) return;

    // Select the near and far expiry dates
    var expiries = calls.Select(x =&gt; x.Expiry).OrderBy(x =&gt; x);
    var nearExpiry = expiries.First();
    var farExpiry = expiries.Last();</pre>
        <pre class="python">def on_data(self, slice: Slice) -&gt; None:
    if self.portfolio.invested: return

    # Get the OptionChain
    chain = slice.option_chains.get(self._symbol, None)
    if not chain: return

    # Get the ATM strike
    atm_strike = sorted(chain, key=lambda x: abs(x.strike - chain.underlying.price))[0].strike

    # Select the ATM call Option contracts
    calls = [i for i in chain if i.strike == atm_strike and i.right == OptionRight.CALL]
    if len(calls) == 0: return

    # Select the near and far expiry dates
    expiries = sorted([x.expiry for x in calls])
    near_expiry = expiries[0]
    far_expiry = expiries[-1]</pre>
    </div>

    <li>In the <code class="csharp">OnData</code><code class="python">on_data</code> method, call the <code class="csharp">OptionStrategies.CallCalendarSpread</code><code class="python">OptionStrategies.call_calendar_spread</code> method and then submit the order.</li>
    <div class="section-example-container">
        <pre class="csharp">var optionStrategy = OptionStrategies.CallCalendarSpread(_symbol, atmStrike, nearExpiry, farExpiry);
Buy(optionStrategy, 1);</pre>
        <pre class="python">option_strategy = OptionStrategies.call_calendar_spread(self._symbol, atm_strike, near_expiry, far_expiry)
self.buy(option_strategy, 1)</pre>
    </div>

<?php 
$methodNames = array("Buy");
include(DOCS_RESOURCES."/trading-and-orders/option-strategy-extra-args.php"); 
?>

</ol>

<h4>Using Combo Orders</h4>
<ol>
    <li>In the <code class="csharp">OnData</code><code class="python">on_data</code> method, select the strategy legs.</li>
    <div class="section-example-container">
        <pre class="csharp">public override void OnData(Slice slice)
{
    if (Portfolio.Invested) return;

    // Get the OptionChain
    var chain = slice.OptionChains.get(_symbol, null);
    if (chain == null || chain.Count() == 0) return;

    // Get the ATM strike
    var atmStrike = chain.OrderBy(x =&gt; Math.Abs(x.Strike - chain.Underlying.Price)).First().Strike;

    // Select the ATM call Option contracts
    var calls = chain.Where(x =&gt; x.Strike == atmStrike &amp;&amp; x.Right == OptionRight.Call);
    if (calls.Count() == 0) return;

    // Select the near and far expiry contracts
    var orderedCalls = calls.OrderBy(x =&gt; x.Expiry);
    var nearExpiryCall = orderedCalls.First();
    var farExpiryCall = orderedCalls.Last();</pre>
        <pre class="python">def on_data(self, slice: Slice) -&gt; None:
    if self.portfolio.invested: return

    # Get the OptionChain
    chain = slice.option_chains.get(self._symbol, None)
    if not chain: return

    # Get the ATM strike
    atm_strike = sorted(chain, key=lambda x: abs(x.strike - chain.underlying.price))[0].strike

    # Select the ATM call Option contracts
    calls = [i for i in chain if i.strike == atm_strike and i.right == OptionRight.CALL]
    if len(calls) == 0: return

    # Select the near and far expiry dates
    ordered_calls = sorted(calls, key=lambda x: x.expiry)
    near_expiry_call = ordered_calls[0]
    far_expiry_call = ordered_calls[-1]</pre>
    </div>

    <li>In the <code class="csharp">OnData</code><code class="python">on_data</code> method, create <code>Leg</code> and call the <a href="/docs/v2/writing-algorithms/trading-and-orders/order-types/combo-market-orders">Combo Market Order</a>/<a href="/docs/v2/writing-algorithms/trading-and-orders/order-types/combo-limit-orders">Combo Limit Order</a>/<a href="/docs/v2/writing-algorithms/trading-and-orders/order-types/combo-leg-limit-orders">Combo Leg Limit Order</a> to submit the order.</li>
    <div class="section-example-container">
        <pre class="csharp">var legs = new List&lt;Leg&gt;()
    {
        Leg.Create(nearExpiryCall.Symbol, -1),
        Leg.Create(farExpiryCall.Symbol, 1)
    };
ComboMarketOrder(legs, 1);</pre>
        <pre class="python">legs = [
    Leg.create(near_expiry_call.symbol, -1),
    Leg.create(far_expiry_call.symbol, 1)
]
self.combo_market_order(legs, 1)</pre>
    </div>

</ol>
