<? if ($leanCli) { ?>
<p> 
    The Lean CLI is distributed as a Python package, so it requires <code>pip</code> to be installed. Because <code>pip</code> is distributed as a part of Python, you must install Python before you can install the CLI.
</p>
<? } else { ?>
<p> 
    QuantConnect Local Platform is better with <code>pip</code> installed. Because <code>pip</code> is distributed as a part of Python, you must install Python before you can install the QuantConnect Local Platform. The pip package manager is used to install the quantconnect-stubs package, which provides local autocomplete on the QuantConnect QCAlgorithm API.
</p>
<? } ?>

<p>This page contains installation instructions for <a href="https://docs.anaconda.com/anaconda/" target="_blank">Anaconda</a>, which is a Python distribution containing a lot of packages that are also available when running the LEAN engine. Having these packages installed locally makes it possible for your editor to provide autocomplete for them.</p>
<p>The Python distribution from the Microsoft Store is not supported.</p>