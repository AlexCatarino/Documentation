<?php echo file_get_contents(DOCS_RESOURCES."/datasets/supported-securities/crypto/market.html"); ?>

<p>To set the market for a security, pass a <code>market</code> argument to the <code class="csharp">AddCrypto</code><code class="python">add_crypto</code> method.</p>

<div class="section-example-container">
    <pre class="csharp">_symbol = AddCrypto("BTCUSD", market: Market.Coinbase).Symbol;</pre>
    <pre class="python">self._symbol = self.add_crypto("BTCUSD", market=Market.COINBASE).symbol</pre>
</div>

<?php echo file_get_contents(DOCS_RESOURCES."/securities/supported-markets.html"); ?>
