-{ Delisting} events provide notice that an asset is no longer trading on the exchange. A delisting warning is issued on the final trading day for a stock delisting event to give your algorithm time to gracefully exit out of positions before forced termination. 
<div>-Our data is survivorship-bias free<br></div><div>-Check if there are delistings in the current slice with data.Delistings</div><div>&nbsp;&nbsp;&nbsp; - returns key-value pairs</div><div>&nbsp;&nbsp;&nbsp; - value has a `.Value` that you can check against&nbsp; the DelistingType enum<br></div><div>- &lt;security&gt;.IsDelisted<br></div><div>-DelistingType (.Warning &amp; .Delisted)</div><div>-Accessed in the time-slice<br></div><div>-Example: DelistingEventsAlgorithm.py</div><div>-"We could also make a short tutorial on delisting. Some people save the symbols in list (to make history requests), they should remove the security from that list too."<br></div><div></div>

<div class="section-example-container">
        <pre class="csharp">if (data.Delistings.ContainsKey(_msft))
{
    var delisting = data.Delistings[_msft];
}</pre>
        <pre class="python">if data.ContainsKey(self.msft):
    delisting = data.Delistings[self.msft]</pre>
    </div>
-^ Add SetOrderTicket method and add the Ticket member to get the order ticket that liquidates the position

<div data-tree="QuantConnect.Data.Market.Delisting"></div>