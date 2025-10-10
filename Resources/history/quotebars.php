<p class='csharp'>
  To get historical <a href='<?=$dataTypeLink?>'>quote data</a>, call the <code>History&lt;<?=$dataType?>&gt;</code> method with a security's <code>Symbol</code>.
</p>

<p class='python'>
  To get historical <a href='<?=$dataTypeLink?>'>quote data</a>, call the <code>history</code> method with the <code><?=$dataType?></code> type and a security's <code>Symbol</code>.
  This method returns a DataFrame with columns for the open, high, low, close, and size of the bid and ask quotes.
  The columns that don't start with "bid" or "ask" are the mean of the quote prices on both sides of the market.
</p>

<div class="section-example-container">
    <pre class="csharp">public class <?=$assetClass?><?=$dataType?>HistoryAlgorithm : QCAlgorithm
{
    public override void Initialize()
    {
        SetStartDate(2024, 12, 19);
        SetEndDate(2024, 12, 31);
        // Get the Symbol of a security.
        <?=$symbolC?>

        // Get the 5 trailing minute <?=$dataType?> objects of the security. 
        var history = History&lt;<?=$dataType?>&gt;(symbol, 5, Resolution.Minute);
        // Iterate through the QuoteBar objects and calculate the spread.
        foreach (var bar in history)
        {
            var t = bar.EndTime;
            var spread = bar.Ask.Close - bar.Bid.Close;
        }
    }
}</pre>
    <pre class="python">class <?=$assetClass?><?=$dataType?>HistoryAlgorithm(QCAlgorithm):

    def initialize(self) -> None:
        self.set_start_date(2024, 12, 19)
        self.set_end_date(2024, 12, 31)
        # Get the Symbol of a security.
        <?=$symbolPy?>

        # Get the 5 trailing minute <?=$dataType?> objects of the security in DataFrame format. 
        history = self.history(<?=$dataType?>, symbol, 5, Resolution.MINUTE)</pre>
</div>

<?=$dataFrame?>

<div class="python section-example-container">
    <pre class="python"># Calculate the spread at each minute.
spread = history.askclose - history.bidclose</pre>
</div>

<div class="python section-example-container">
    <pre><?=$series?></pre>
</div>

<p class='python'>
  If you intend to use the data in the DataFrame to create <code><?=$dataType?></code> objects, request that the history request returns the data type you need. 
  Otherwise, LEAN consumes unnecessary computational resources populating the DataFrame.  
  To get a list of <code><?=$dataType?></code> objects instead of a DataFrame, call the <code>history[<?=$dataType?>]</code> method.
</p>

<div class="python section-example-container">
    <pre class="python"># Get the 5 trailing minute <?=$dataType?> objects of the security in <?=$dataType?> format. 
history = self.history[<?=$dataType?>](symbol, 5, Resolution.MINUTE)
<? if ($supportsQuoteSize) { ?>
# Iterate through each QuoteBar and calculate the dollar volume on the bid.
for quote_bar in history:
    t = quote_bar.end_time
    bid_dollar_volume = quote_bar.last_bid_size * quote_bar.bid.close
<? } else { ?>
# Iterate through each QuoteBar and calculate the spread.
for quote_bar in history:
    t = quote_bar.end_time
    spread = quote_bar.ask.close - quote_bar.bid.close
<? } ?>
</pre>
</div>
