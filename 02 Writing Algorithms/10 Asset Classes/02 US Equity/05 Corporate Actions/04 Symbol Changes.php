<div>-SymbolChangedEvents provides notice of new ticker names for stocks, or mergers of two tickers into one or reverse mergers</div><div>&nbsp;&nbsp;&nbsp; - Example: AOL TimeWarner became TimeWarner and changed their symbol from AOL to TWX.</div><div>- It provides the OldSymbol and NewSymbol tickers ; Show properties of SymbolChangedEvent class</div><div>&nbsp;&nbsp;&nbsp; - OldSymbol, NewSymbol</div><div>-accessed in the time-slice<br></div><div>-The benefit of our Symbol class is that ticker changes don't really matter, we're not passing strings of company ticker<br></div><div>-Full example: There are none in the repo (add example?)<br></div><div>-Data saved in map files</div><div></div>
<br>-Open Orders get canceled in case of a SymbolChanged event. In this case, we recommend using the OnOrderEvent handler to get the order quantity and the symbol associated with the canceled order and resubmitting a new order.


<div class="section-example-container">
        <pre class="csharp">if (data.SymbolChangedEvents.ContainsKey(_googl))
{
    var symbolChangedEvent = data.SymbolChangedEvents[_googl];
}</pre>
        <pre class="python">if self.googl in data.SymbolChangedEvents:
    symbolChangedEvent = data.SymbolChangedEvents[self.googl]</pre>
    </div>

<div data-tree="QuantConnect.Data.Market.SymbolChangedEvent"></div>