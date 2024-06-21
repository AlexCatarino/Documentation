<h4>Order Types</h4>
<p>The following table describes the available order types for each asset class that <?= $cloudPlatform ? "our Bybit integration" : "the <code>BybitBrokerageModel</code>" ?> supports:</p>

<table class="qc-table table" id='order-types-table'>
   <thead>
      <tr>
        <th style='width: 50%'>Order Type</th>
        <th>Crypto</th>
        <th>Crypto Futures</th>
      </tr>
   </thead>
   <tbody>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/market-orders'>Market</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/limit-orders'>Limit</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-market-orders'>Stop market</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-limit-orders'>Stop limit</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
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
<p><?= $writingAlgorithms ? "The <code>BybitBrokerageModel</code> supports custom order properties." : "We model custom order properties from the Bybit API." ?> The following table describes the members of the <code>BybitBrokerageModel</code> object that you can set to customize order execution:</p>


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
            <td><code class='csharp'>TimeInForce.GoodTilCanceled</code><code class='python'>TimeInForce.GOOD_TIL_CANCELED</code></td>
         </td>
      </tr>
      <tr>
         <td><code class="csharp">PostOnly</code><code class="python">post_only</code></td>
         <td><code>bool</code></td>
         <td>A flag to signal that the order must only add liquidity to the order book and not take liquidity from the order book. If part of the order results in taking liquidity rather than providing liquidity, the order is rejected without any part of it being filled. This order property is only available for limit orders.</td>
         <td></td>
      </tr>
      <tr>
         <td><code class="csharp">ReduceOnly</code><code class="python">reduce_only</code></td>
         <td><code class='csharp'>bool?</code><code class='python'>bool/NoneType</code></td>
         <td>A flag to signal that the order must only reduce your current position size. For more information about this order property, see <a href='https://www.bybit.com/en-US/help-center/s/article/What-is-a-Reduce-Only-Order' rel='nofollow' target='_blank'>Reduce-Only Order</a> on the Bybit website.</td>
         <td></td>
      </tr>
   </tbody>
</table>

<?php if ($writingAlgorithms) { ?>
<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set the default order properties
    DefaultOrderProperties = new BybitOrderProperties
    {
        TimeInForce = TimeInForce.GoodTilCanceled,
        PostOnly = false,
        ReduceOnly = false
    };
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new BybitOrderProperties
               { 
                   TimeInForce = TimeInForce.Day,
                   PostOnly = true,
                   ReduceOnly = false
               });
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new BybitOrderProperties
               { 
                   TimeInForce = TimeInForce.GoodTilDate(new DateTime(year, month, day)),
                   PostOnly = false,
                   ReduceOnly = true
               });
}</pre>
    <pre class="python">def initialize(self) -&gt; None:
    # Set the default order properties
    self.default_order_properties = BybitOrderProperties()
    self.default_order_properties.time_in_force = TimeInForce.GOOD_TIL_CANCELED
    self.default_order_properties.post_only = False
    self.default_order_properties.reduce_only = False

def on_data(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.limit_order(self._symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = BybitOrderProperties()
    order_properties.time_in_force = TimeInForce.DAY
    order_properties.post_only = True
    self.default_order_properties.reduce_only = False
    self.limit_order(self._symbol, quantity, limit_price, order_properties=order_properties)

    order_properties.time_in_force = TimeInForce.good_til_date(datetime(year, month, day))
    order_properties.post_only = False
    self.default_order_properties.reduce_only = True
    self.limit_order(self._symbol, quantity, limit_price, order_properties=order_properties)</pre>
</div>
<?php } ?>

<h4>Updates</h4>
<p><?= $writingAlgorithms ? "The <code>BybitBrokerageModel</code> supports" : "We model the Bybit API by supporting"?> <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets#04-Update-Orders'>order updates</a> for Crypto Future assets that have one of the following <a href='/docs/v2/writing-algorithms/trading-and-orders/order-events#03-Order-States'>order states</a>:</p>
<ul>
  <li><code class='csharp'>OrderStatus.New</code><code class='python'>OrderStatus.NEW</code></li>
  <li><code class='csharp'>OrderStatus.PartiallyFilled</code><code class='python'>OrderStatus.PARTIALLY_FILLED</code></li>
  <li><code class='csharp'>OrderStatus.Submitted</code><code class='python'>OrderStatus.SUBMITTED</code></li>
  <li><code class='csharp'>OrderStatus.UpdateSubmitted</code><code class='python'>OrderStatus.FILLED</code></li>
</ul>
<p>In cases where you can't update an order, you can cancel the existing order and then create a new order with the desired arguments. For more information about this workaround, see the <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets#workaround-for-brokerages-that-dont-support-updates'>Workaround for Brokerages That Don’t Support Updates</a>.</p>
