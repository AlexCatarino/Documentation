<p>To send targets, pass a list of <code>PortfolioTarget</code> objects to the <code class="csharp">SetTargetPortfolio</code><code class="python">set_target_portfolio</code> method.  The method returns a boolean that represents if the targets were successfully sent to Numerai Signals. In this situation, the number you pass to the <code>PortfolioTarget</code> constructor represents the portfolio weight. Don't use the <code class="csharp">PortfolioTarget.Percent</code><code class="python">PortfolioTarget.percent</code> method.</p>

<div class="section-example-container">
<pre class="csharp">var success = SignalExport.SetTargetPortfolio(targets);</pre>
<pre class="python">success = self.signal_export.set_target_portfolio(targets)</pre>
</div>
