###
<br> Todo: Merge this section into the Organization > Resources > Backtesting Nodes section
<br>###

<p>You need an idle backtesting node in your organization to deploy a backtest. You can <a href='../../tutorials/organizations/handling-resources#02-View-All-Nodes'>view the status of all of your organization's nodes</a> in  the Algorithm Lab. Backtesting nodes that are more powerful can run faster backtests and backtest nodes with more RAM can handle more memory-intensive operations like training machine learning models, processing Options data, and managing large universes. The following table shows the specifications of the backtesting node models:</p>

<?php echo file_get_contents(DOCS_RESOURCES."/backtest-nodes-table.html"); ?>

<p>Refer to the <a href=/pricing">Pricing</a> page to see the price of each backtesting node model. The first organization on each account is given one free B-MICRO backtesting node. This node incurs a 20-second delay when you launch backtests, but the delay is removed and the node is replaced when you <a href='../../tutorials/organizations/managing-organizations#08-Change-Organization-Tiers'>upgrade the tier of your organization</a> and <a href='../../tutorials/organizations/handling-resources#03-Add-Nodes'>add a new backtesting node</a>.</p>
