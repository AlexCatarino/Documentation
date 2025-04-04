<p>The brokerage model of your algorithm automatically sets the settlement model for each security, but you can override it. To manually set the shortable provider of a security, call the <code class="csharp">SetShortableProvider</code><code class="python">set_shortable_provider</code> method on the <code>Security</code> object.</p>


<div class="section-example-container">
    <pre class="csharp" style="">public override void Initialize()
{
    var security = AddEquity("SPY");
    // Get shortable stocks and quantity from local disk
    security.SetShortableProvider(new LocalDiskShortableProvider("axos"));
}</pre>
    <pre class="python">def initialize(self) -&gt; None:
    security = self.add_equity("SPY")
    # Get shortable stocks and quantity from local disk
    security.set_shortable_provider(LocalDiskShortableProvider("axos"))</pre>
</div>

<p>You can also set the shortable provider in a security initializer. If your algorithm has a universe, use the security initializer technique. In order to initialize single security subscriptions with the security initializer, call <code class="csharp">SetSecurityInitializer</code><code class="python">set_security_initializer</code> before you create the subscriptions.</p>

<div class="section-example-container">
<pre class="csharp" style="">public override void Initialize()
{
    // Set the security initializer before requesting data to apply to all requested securities afterwards
    SetSecurityInitializer(CustomSecurityInitializer);
    AddEquity("SPY");
}

private void CustomSecurityInitializer(Security security)
{
    security.SetShortableProvider(new LocalDiskShortableProvider("axos"));
}
</pre>
<pre class="python">def initialize(self) -&gt; None:
    # Set the security initializer before requesting data to apply to all requested securities afterwards
    self.set_security_initializer(self.custom_security_initializer)
    self.add_equity("SPY")

def custom_security_initializer(self, security: Security) -&gt; None:
    security.set_shortable_provider(LocalDiskShortableProvider("axos"))
</pre>
</div>

<?php echo file_get_contents(DOCS_RESOURCES."/reality-modeling/security-initializers.html");?>

<p>To extend upon the default security initializer instead of overwriting it, create a custom <code>BrokerageModelSecurityInitializer</code>.</p>

<?php
$overwriteCodePy = "security.set_shortable_provider(LocalDiskShortableProvider(\"axos\"))";
$overwriteCodeC = "security.SetShortableProvider(new LocalDiskShortableProvider(\"axos\"));";
include(DOCS_RESOURCES."/reality-modeling/brokerage-model-security-init.php");
?>

<p>To view all the pre-built shortable providers, see <a href='/docs/v2/writing-algorithms/reality-modeling/short-availability/supported-providers'>Supported Providers</a>.</p>
