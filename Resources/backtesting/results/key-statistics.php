<p>The backtest results page displays many key statistics to help you analyze the performance of your algorithm.</p> 

<h4>Overall Statistics</h4>
<p>The <span class="tab-name">Overview</span> tab on the backtest results page displays tables for Overall Statistics and Rolling Statistics. The Overall Statistics table displays the following statistics:<br></p>

<ul style="columns: 2">
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#24-Probabilistic-Sharpe-ratio">Probabilistic Sharpe Ratio (PSR)</a></li>
    <li>Total Trades</li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#05-average-loss">Average Loss</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#11-drawdown">Drawdown</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#20-net-profit">Net Profit</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#18-loss-rate">Loss Rate</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#25-profit-loss-ratio">Profit-Loss Ratio</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#07-beta">Beta</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#04-annual-variance">Annual Variance</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#33-tracking-error">Tracking Error</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#30-total-fees">Total Fees</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#19-lowest-capacity-asset">Lowest Capacity Asset</a></li>

    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#28-Sharpe-ratio">Sharpe Ratio</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#06-average-win">Average Win</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#09-compounding-annual-return">Compounding Annual Return</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#13-expectancy">Expectancy</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#37-win-rate">Win Rate</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#02-alpha">Alpha</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#03-annual-standard-deviation">Annual Standard Deviation</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#15-information-ratio">Information Ratio</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#34-Treynor-ratio">Treynor Ratio</a></li>
    <li><a href="/docs/v2/writing-algorithms/key-concepts/glossary#08-capacity">Estimated Strategy Capacity</a></li>
</ul>

<p>Some of the preceding statistics are sampled throughout the backtest to produce a time series of rolling statistics. The time series are displayed in the Rolling Statistics table.</p>

<? if ($localPlatform) { ?>
<p>To view the data from the Overall Statistics and Rolling Statistics tables in JSON format, open the <span class='public-file-name'><a href='/docs/v2/local-platform/development-environment/organization-workspaces'>&lt;organizationWorkspace&gt;</a> / &lt;projectName&gt; / backtests / &lt;unixTimestamp&gt; / &lt;algorithmId&gt;.json</span> file.</p>
<? } else { ?>
<p>To download the data from the Overall Statistics and Rolling Statistics tables, see <a href='/docs/v2/cloud-platform/backtesting/results#15-Download-Results'>Download Results</a>.</p>
<? } ?>

<h4>Research Guide</h4>
<p>For information about the Research Guide, see <a href="/docs/v2/cloud-platform/backtesting/research-guide">Research Guide</a>.
</p>

<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
</script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
