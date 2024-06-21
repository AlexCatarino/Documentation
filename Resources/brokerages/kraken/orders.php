
<h4>Order Types</h4>
<p>The following table describes the available order types for each asset class that <?= $cloudPlatform ? "our Kraken integration" : "the <code>KrakenBrokerageModel</code>" ?> supports:</p>

<table class="qc-table table" id='order-types-table'>
   <thead>
      <tr>
        <th style='width: 50%'>Order Type</th>
        <th>Crypto</th>
      </tr>
   </thead>
   <tbody>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/market-orders'>Market</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/limit-orders'>Limit</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/limit-if-touched-orders'>Limit if touched</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-market-orders'>Stop market</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-limit-orders'>Stop limit</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
   </tbody>
</table>
<style>
#order-types-table td:not(:first-child), 
#order-types-table th:not(:first-child) {
    text-align: center;
}
</style>

<h4>Order Properties</h4>
<p><?= $writingAlgorithms ? "The <code>KrakenBrokerageModel</code> supports custom order properties." : "We model custom order properties from the Kraken API." ?> The following table describes the members of the <code>KrakenOrderProperties</code> object that you can set to customize order execution:</p>

<table class="table qc-table">
    <thead>
        <tr>
         <th>Property</th>
         <th>Data Type</th>
         <th>Description</th>
         <th>Default Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code class="csharp">TimeInForce</code><code class="python">time_in_force</code></td>
            <td>A <a href='/docs/v2/writing-algorithms/trading-and-orders/order-properties#03-Time-In-Force'>TimeInForce</a> instruction to apply to the order. The following instructions are supported:
                <ul>
                    <li><code class="csharp">Day</code><code class="python">DAY</code></li>
                    <li><code class="csharp">GoodTilCanceled</code><code class="python">GOOD_TIL_CANCELED</code></li>
                    <li><code class="csharp">GoodTilDate</code><code class="python">good_til_date</code></li>
                 </ul>
             </td>
             <td><code class='csharp'>TimeInForce.GoodTilCanceled</code><code class='python'>TimeInForce.GOOD_TIL_CANCELED</code></td>
        </tr>
        <tr>
            <td><code class="csharp">PostOnly</code><code class="python">post_only</code></td>
            <td><code>bool</code></td>
            <td>A flag to signal that the order must only add liquidity to the order book and not take liquidity from the order book. If part of the order results in taking liquidity rather than providing liquidity, the order is rejected without any part of it being filled.</td>
            <td></td>
        </tr>
        <tr>
            <td><code class="csharp">FeeInBase</code><code class="python">fee_in_base</code></td>
            <td><code>bool</code></td>
            <td>A flag to signal that the order fees should be paid in the base currency, which is the default behavior when selling. This flag must be the opposite of the <code class="csharp">FeeInQuote</code><code class="python">fee_in_quote</code> flag.</td>
            <td></td>
        </tr>
        <tr>
            <td><code class="csharp">FeeInQuote</code><code class="python">fee_in_quote</code></td>
            <td><code>bool</code></td>
            <td>A flag to signal that the order fees should be paid in the quote currency, which is the default behavior when buying. This flag must be the opposite of the <code class="csharp">FeeInBase</code><code class="python">fee_in_base</code> flag.</td>
            <td></td>
        </tr>
        <tr>
            <td><code class="csharp">NoMarketPriceProtection</code><code class="python">no_market_price_protection</code></td>
            <td><code>bool</code></td>
            <td>A flag to signal that no <a rel="nofollow" target="_blank" href="https://support.kraken.com/hc/en-us/articles/201648183-Market-Price-Protection">Market Price Protection</a> should be used.</td>
            <td></td>
        </tr>
        <tr>
            <td><code class="csharp">ConditionalOrder</code><code class="python">conditional_order</code></td>
            <td><code>Order</code></td>
            <td>An <code>Order</code> that's submitted when the primary order is executed. The <code class="csharp">ConditionalOrder</code><code class="python">conditional_order</code> quantity must match the primary order quantity and the <code class="csharp">ConditionalOrder</code><code class="python">conditional_order</code> direction must be the opposite of the primary order direction. This order property is only available for live algorithms.</td>
            <td></td>
        </tr>
    </tbody>
</table>

<?php if ($writingAlgorithms) { ?>
<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set the default order properties
    DefaultOrderProperties = new KrakenOrderProperties
    {
        TimeInForce = TimeInForce.GoodTilCanceled,
        PostOnly = false,
        FeeInBase = true,
        FeeInQuote = false,
        NoMarketPriceProtection = true
    };
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new KrakenOrderProperties
               { 
                   TimeInForce = TimeInForce.Day,
                   PostOnly = true,
                   FeeInBase = false,
                   FeeInQuote = true,
                   NoMarketPriceProtection = true
               });
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new KrakenOrderProperties
               { 
                   TimeInForce = TimeInForce.GoodTilDate(new DateTime(year, month, day)),
                   PostOnly = false,
                   FeeInBase = true,
                   FeeInQuote = false,
                   NoMarketPriceProtection = false,
                   ConditionalOrder = StopLimitOrder(_symbol, -quantity, stopLimitPrice, stopPrice)
               });
}</pre>
    <pre class="python">def initialize(self) -&gt; None:
    # Set the default order properties
    self.default_order_properties = KrakenOrderProperties()
    self.default_order_properties.time_in_force = TimeInForce.GOOD_TIL_CANCELED
    self.default_order_properties.post_only = False
    self.default_order_properties.fee_in_base = True
    self.default_order_properties.fee_in_quote = False
    self.default_order_properties.no_market_price_protection = True

def on_data(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.limit_order(self._symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = KrakenOrderProperties()
    order_properties.time_in_force = TimeInForce.DAY
    order_properties.post_only = True
    order_properties.fee_in_base = False
    order_properties.fee_in_quote = True
    order_properties.no_market_price_protection = True
    self.limit_order(self._symbol, quantity, limit_price, order_properties=order_properties)

    order_properties.time_in_force = TimeInForce.good_til_date(datetime(year, month, day))
    order_properties.post_only = False
    order_properties.fee_in_base = True
    order_properties.fee_in_quote = False
    order_properties.no_market_price_protection = False
    order_properties.conditional_order = StopLimitOrder(self._symbol, -quantity, stop_limit_price, stop_price)
    self.limit_order(self._symbol, quantity, limit_price, order_properties=order_properties)</pre>
</div>
<?php } ?>

<h4>Updates</h4>
<p><?= $writingAlgorithms ? "The <code>KrakenBrokerageModel</code> doesn't support order updates" : "We model the Kraken API by not supporting order updates" ?>, but you can cancel an existing order and then create a new order with the desired arguments. For more information about this workaround, see the <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets#workaround-for-brokerages-that-dont-support-updates'>Workaround for Brokerages That Don’t Support Updates</a>.</p>

