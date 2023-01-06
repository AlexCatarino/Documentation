<p>To set the pricing model of an Option, set its <code>PriceModel</code> property.</p>

<p>If you have access to the <code>Option</code> object when you subscribe to the Option universe or contract, you can set the price model immediately after you create the subscription.</p>

<div class="section-example-container">
    <pre class="csharp">// In Initialize
var option = AddOption("SPY");
option.PriceModel = OptionPriceModels.CrankNicolsonFD();</pre>
    <pre class="python"># In Initialize
option = self.AddOption("SPY")
option.PriceModel = OptionPriceModels.CrankNicolsonFD()</pre>
</div>

<p>Otherwise, set the price model in a <a href='/docs/v2/writing-algorithms/initialization#07-Set-Security-Initializer'>security initializer</a>.</p>

<?php
include(DOCS_RESOURCES."/reality-modeling/brokerage-mondel-security-init.php");
$overwriteCodePy = "if security.Type == SecurityType.Option: # Option type
            security.PriceModel = OptionPriceModels.CrankNicolsonFD()";
$overwriteCodeC = "if (security.Type == SecurityType.Option) // Option type
        {
            security.PriceModel = OptionPriceModels.CrankNicolsonFD();
        }";
$getBrokerageModelInitCodeBlock($overwriteCodePy, $overwriteCodeC, "the price model");
?>
