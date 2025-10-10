<p>The following examples demonstrate some common practices for using order events.</p>

<h4>Example 1: Illiquid Stock Partial Fill</h4>
<p>The following algorithm trades EMA cross on CARZ, an illiquid ETF. To realistically simulate the fill behavior, we set a fill model to partially fill the orders with at most 50% of the previous bar's volume per fill. We cancel the remaining open order after the partial fill since we only trade on the updated information.</p>
<div class="section-example-container">
    <pre class="csharp">public class OrderEventsAlgorithm : QCAlgorithm
{
    private Symbol _carz;
    private ExponentialMovingAverage _ema;

    public override void Initialize()
    {
        SetStartDate(2024, 9, 1);
        SetEndDate(2024, 12, 31);

        // Request CARZ data to feed indicator and trade.
        var equity = AddEquity("CARZ");
        _carz = equity.Symbol;
        // Set a custom partial fill model for the illiquid CARZ stock since it is more realistic.
        equity.SetFillModel(new CustomPartialFillModel(this));

        // Create EMA indicator to generate trade signals.
        _ema = EMA(_carz, 60, Resolution.Daily);
        // Warm up indicator for immediate readiness to use.
        WarmUpIndicator(_carz, _ema, Resolution.Daily);
    }

    public override void OnData(Slice slice)
    {
        if (slice.Bars.TryGetValue(_carz, out var bar))
        {
            // Trade EMA cross on CARZ for trend-following strategy.
            if (bar.Close &gt; _ema &amp;&amp; !Portfolio[_carz].IsLong)
            {
                SetHoldings(_carz, 0.5m);
            }
            else if (bar.Close &lt; _ema &amp;&amp; !Portfolio[_carz].IsShort)
            {
                SetHoldings(_carz, -0.5m);
            }
        }
    }

    public override void OnOrderEvent(OrderEvent orderEvent)
    {
        // If an order is only partially filled, we cancel the rest to avoid trade on non-updated information.
        if (orderEvent.Status == OrderStatus.PartiallyFilled)
        {
            Transactions.CancelOpenOrders();
        }
    }
    
    /// Implements a custom fill model that partially fills each order with a ratio of the previous trade bar.
    private class CustomPartialFillModel : FillModel
    {
        private readonly QCAlgorithm _algorithm;
        private readonly Dictionary&lt;int, decimal&gt; _absoluteRemainingByOrderId;
        // Save the ratio of the volume of the previous bar to fill the order.
        private decimal _ratio;

        public CustomPartialFillModel(QCAlgorithm algorithm, decimal ratio = 0.5m)
            : base()
        {
            _algorithm = algorithm;
            _absoluteRemainingByOrderId = new Dictionary&lt;int, decimal&gt;();
            _ratio = ratio;
        }

        public override OrderEvent MarketFill(Security asset, MarketOrder order)
        {
            decimal absoluteRemaining;
            if (!_absoluteRemainingByOrderId.TryGetValue(order.Id, out absoluteRemaining))
            {
                absoluteRemaining = order.AbsoluteQuantity;
            }

            var fill = base.MarketFill(asset, order);

            // Partially filled each order with at most 50% of the previous bar.
            fill.FillQuantity = Math.Sign(order.Quantity) * asset.Volume * _ratio;
            if (Math.Min(Math.Abs(fill.FillQuantity), absoluteRemaining) == absoluteRemaining)
            {
                fill.FillQuantity = Math.Sign(order.Quantity) * absoluteRemaining;
                fill.Status = OrderStatus.Filled;
                _absoluteRemainingByOrderId.Remove(order.Id);
            }
            else
            {
                fill.Status = OrderStatus.PartiallyFilled;
                // Save the remaining quantity after it is partially filled.
                _absoluteRemainingByOrderId[order.Id] = absoluteRemaining - Math.Abs(fill.FillQuantity);
                var price = fill.FillPrice;
            }
            return fill;
        }
    }
}</pre>
    <pre class="python">class OrderEventsAlgorithm(QCAlgorithm):
    def initialize(self) -&gt; None:
        self.set_start_date(2024, 9, 1)
        self.set_end_date(2024, 12, 31)

        # Request CARZ data to feed indicator and trade.
        equity = self.add_equity("CARZ")
        self.carz = equity.symbol
        # Set a custom partial fill model for the illiquid CARZ stock since it is more realistic.
        equity.set_fill_model(CustomPartialFillModel(self))

        # Create EMA indicator to generate trade signals.
        self._ema = self.ema(self.carz, 60, Resolution.DAILY)
        # Warm-up indicator for immediate readiness to use.
        self.warm_up_indicator(self.carz, self._ema, Resolution.DAILY)

    def on_data(self, slice: Slice) -&gt; None:
        bar = slice.bars.get(self.carz)
        if bar and self._ema.is_ready:
            ema = self._ema.current.value
            # Trade EMA cross on CARZ for trend-following strategy.
            if bar.close &gt; ema and not self.portfolio[self.carz].is_long:
                self.set_holdings(self.carz, 0.5)
            elif bar.close &lt; ema and not self.portfolio[self.carz].is_short:
                self.set_holdings(self.carz, -0.5)

    def on_order_event(self, order_event: OrderEvent) -&gt; None:
        # If an order is only partially filled, we cancel the rest to avoid trade on non-updated information.
        if order_event.status == OrderStatus.PARTIALLY_FILLED:
            self.transactions.cancel_open_orders()

# Implements a custom fill model that partially fills each order with a ratio of the previous trade bar.
class CustomPartialFillModel(FillModel):
    def __init__(self, algorithm: QCAlgorithm, ratio: float = 0.5) -&gt; None:
        self.algorithm = algorithm
        self.absolute_remaining_by_order_id = {}
        # Save the ratio of the volume of the previous bar to fill the order.
        self.ratio = ratio

    def market_fill(self, asset: Security, order: MarketOrder) -&gt; None:
        absolute_remaining = self.absolute_remaining_by_order_id.get(order.id, order. AbsoluteQuantity)

        fill = super().market_fill(asset, order)

        # Partially fill each order with at most 50% of the previous bar.
        fill.fill_quantity = np.sign(order.quantity) * asset.volume * self.ratio
        if (min(abs(fill.fill_quantity), absolute_remaining) == absolute_remaining):
            fill.fill_quantity = np.sign(order.quantity) * absolute_remaining
            fill.status = OrderStatus.FILLED
            self.absolute_remaining_by_order_id.pop(order.id, None)
        else:
            fill.status = OrderStatus.PARTIALLY_FILLED
            # Save the remaining quantity after it is partially filled.
            self.absolute_remaining_by_order_id[order.id] = absolute_remaining - abs(fill.fill_quantity)
            price = fill.fill_price

        return fill</pre>
</div>

<? 
$number = 2;
include(DOCS_RESOURCES."/examples/take-profit-stop-loss-example.php");
?>