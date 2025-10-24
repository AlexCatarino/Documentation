<p>To set the pricing model of an Option, set its <code class="csharp">PriceModel</code><code class="python">price_model</code> property.</p>

<p>If you have access to the <code>Option</code> object when you subscribe to the Option universe or contract, you can set the price model immediately after you create the subscription.</p>

<div class="section-example-container">
    <pre class="csharp">public override Initialize()
{
    UniverseSettings.Asynchronous = true;
    var option = AddOption("SPY");
    // SPY options are American Options, in which IV and greeks more accurately calculated using Binomial model
    option.PriceModel = OptionPriceModels.BinomialCoxRossRubinstein();
}</pre>
    <pre class="python">def initialize(self):
    self.universe_settings.asynchronous = True
    option = self.add_option("SPY")
    # SPY options are American Options, in which IV and greeks more accurately calculated using Binomial model
    option.price_model = OptionPriceModels.binomial_cox_ross_rubinstein()</pre>
</div>

<p>Otherwise, set the price model in a <a href='/docs/v2/writing-algorithms/initialization#07-Set-Security-Initializer'>security initializer</a>.</p>

<?php

$overwriteCodePy = "if security.type == SecurityType.OPTION: # Option type
            security.price_model = OptionPriceModels.binomial_cox_ross_rubinstein()";
$overwriteCodeC = "if (security.Type == SecurityType.Option) // Option type
        {
            (security as Option).PriceModel = OptionPriceModels.BinomialCoxRossRubinstein();
        }";
$comment = "the price model";
include(DOCS_RESOURCES."/reality-modeling/brokerage-model-security-init.php");
?>