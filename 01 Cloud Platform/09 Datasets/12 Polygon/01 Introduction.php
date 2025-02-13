<? include(DOCS_RESOURCES."/brokerages/introduction-by-brokerage/polygon.html"); ?>

<p>
  The Polygon data provider serves live asset prices from Polygon. 
  Instead of using the data from QuantConnect or your brokerage, you can use data from <a rel='nofollow' target='_blank' href='https://polygon.io/'>Polygon</a> if you're deploying a live algorithm and have an API key. 
  To get an API key, see the <a href='https://polygon.io/dashboard/api-keys' rel='nofollow' target='_blank'>API Keys</a> page on the Polygon website.
  This page explains our integration with Polygon and its functionality.
</p>

<p>To view the implementation of the Polygon integration, see the <a href='https://github.com/QuantConnect/Lean.DataSource.Polygon' rel='nofollow' target='_blank'>Lean.DataSource.Polygon repository</a>.</p>

<p>
  QuantConnect Cloud currently only supported streaming Polygon data during live trading. 
  To download Polygon for backtesting, research, and optimizations, use the <a href='/docs/v2/lean-cli/datasets/polygon'>CLI</a>.
</p>
