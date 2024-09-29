<p>The brokerage model of your algorithm automatically sets the fee model for each security, but you can override it. To manually set the fee model of a security, call the <code class="csharp">SetFeeModel</code><code class="python">set_fee_model</code> method on the <code>Security</code> object.</p>


<div class="section-example-container">
    <pre class="csharp">public override Initialize()
{
    var security = AddEquity("SPY");
    // Set the fee model for the requested security to backtest with the most realistic scenario
    // Constant fee model of 0 dollar is accurate for the commission-free brokerage
    security.SetFeeModel(new ConstantFeeModel(0));
}</pre>
    <pre class="python">def initialize(self):
    security = self.add_equity("SPY")
    # Set the fee model for the requested security to backtest with the most realistic scenario
    # Constant fee model of 0 dollar is accurate for the commission-free brokerage
    security.set_fee_model(ConstantFeeModel(0))</pre>
</div>

<p>You can also set the fee model in a <a href='/docs/v2/writing-algorithms/initialization#07-Set-Security-Initializer'>security initializer</a>. If your algorithm has a dynamic universe, use the security initializer technique. In order to initialize single security subscriptions with the security initializer, call <code class="csharp">SetSecurityInitializer</code><code class="python">set_security_initializer</code> before you create the subscriptions.</p>

<?
$overwriteCodePy = "security.set_fee_model(ConstantFeeModel(0))";
$overwriteCodeC = "security.SetFeeModel(new ConstantFeeModel(0));";
include(DOCS_RESOURCES."/reality-modeling/brokerage-model-security-init.php");
?>

<p>In live trading, the <code class="csharp">SetFeeModel</code><code class="python">set_fee_model</code> method isn't ignored. If we use order helper methods like <code class="csharp">SetHoldings</code><code class="python">set_holdings</code>, the fee model helps to calculate the order quantity. However, the algorithm doesn't update the <a href="/docs/v2/writing-algorithms/portfolio/cashbook">cash book</a> with the fee from the fee model. The algorithm uses the actual fee from the brokerage to update the cash book.</p>

<p>To view all the pre-built fee models, see <a href="/docs/v2/writing-algorithms/reality-modeling/transaction-fees/supported-models">Supported Models</a>.</p>
