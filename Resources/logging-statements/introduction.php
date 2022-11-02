<?php
$getLogIntroText = function($terminalLink)
{
    echo "
<p>Logging statements are statements you can add to your algorithm in order to add information to the log file, add information to the <a href='{$terminalLink}'>Cloud Terminal</a>, or even stop the algorithm. Use these statements to debug your backtests and live algorithms. Consider adding them in the code block of an <code>if</code> statement to signify an error has been caught.</p>

<p>It's good practice to add logging statements to live algorithm so that you can understand its behavior and keep records to compare against backtest results. If you don't add logging statements to a live algorithm and the algorithm doesn't trade as you expect, it's difficult to evaluate the underlying problem.</p>
    ";
}
?>
