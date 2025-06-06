<h4>Order Types</h4>
<p>The following table describes the available order types for each asset class that <?= $cloudPlatform ? "our Bitfinex integration" : "the <code>BitfinexBrokerageModel</code>" ?> supports:</p>

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
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-market-orders'>Stop market</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-limit-orders'>Stop market</a></td>
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
<p><?= $writingAlgorithms ? "The <code>BitfinexBrokerageModel</code> supports custom order properties." : "We model custom order properties from the Bitfinex API." ?> The following table describes the members of the <code>BitfinexOrderProperties</code> object that you can set to customize order execution:</p>


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
         <td><code>TimeInForce</code></td>
         <td>
             A <a href='/docs/v2/writing-algorithms/trading-and-orders/order-properties#03-Time-In-Force'>TimeInForce</a> instruction to apply to the order. The following instructions are supported:
             <ul>
                 <li><code class="csharp">Day</code><code class="python">DAY</code></li>
                 <li><code class="csharp">GoodTilCanceled</code><code class="python">GOOD_TIL_CANCELED</code></li>
                 <li><code class="csharp">GoodTilDate</code><code class="python">good_til_date</code></li>
             </ul>
         </td>
         <td><code class='csharp'>TimeInForce.GoodTilCanceled</code><code class='python'>TimeInForce.GOOD_TIL_CANCELED</code></td>
      </tr>
      <tr>
         <td><code class="csharp">Hidden</code><code class="python">hidden</code></td>
         <td><code>bool</code></td>
         <td>A flag to signal that the order should be hidden. Hidden orders do not appear in the order book, so they do not influence other market participants. Hidden orders incur the taker fee.</td>
         <td></td>
      </tr>
      <tr>
         <td><code class="csharp">PostOnly</code><code class="python">post_only</code></td>
         <td><code>bool</code></td>
         <td>A flag to signal that the order must only add liquidity to the order book and not take liquidity from the order book. If part of the order results in taking liquidity rather than providing liquidity, the order is rejected without any part of it being filled.</td>
         <td></td>
      </tr>
   </tbody>
</table>

<?php if ($writingAlgorithms) { ?>
<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set the default order properties
    DefaultOrderProperties = new BitfinexOrderProperties
    {
        TimeInForce = TimeInForce.GoodTilCanceled,
        Hidden = false,
        PostOnly = false
    };
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new BitfinexOrderProperties
               { 
                   TimeInForce = TimeInForce.Day,
                   Hidden = true,
                   PostOnly = false
               });
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new BitfinexOrderProperties
               { 
                   TimeInForce = TimeInForce.GoodTilDate(new DateTime(year, month, day)),
                   Hidden = false,
                   PostOnly = true
               });
}</pre>
    <pre class="python">def initialize(self) -&gt; None:
    # Set the default order properties
    self.default_order_properties = BitfinexOrderProperties()
    self.default_order_properties.time_in_force = TimeInForce.GOOD_TIL_CANCELED
    self.default_order_properties.hidden = False
    self.default_order_properties.post_only = False

def on_data(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.limit_order(self._symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = BitfinexOrderProperties()
    order_properties.time_in_force = TimeInForce.DAY
    order_properties.hidden = True
    order_properties.post_only = False
    self.limit_order(self._symbol, quantity, limit_price, order_properties=order_properties)

    order_properties.time_in_force = TimeInForce.good_til_date(datetime(year, month, day))
    order_properties.hidden = False
    order_properties.post_only = True
    self.limit_order(self._symbol, quantity, limit_price, order_properties=order_properties)</pre>
</div>
<?php } ?>

<h4>Updates</h4>
<p><?= $writingAlgorithms ? "The <code>BitfinexBrokerageModel</code> supports" : "We model the Bitfinex API by supporting"?> <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets#04-Update-Orders'>order updates</a>.</p>
