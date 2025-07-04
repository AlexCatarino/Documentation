<p>
    Equity Option algorithms require the following data:
</p>

<ul>
    <li><a href="https://www.quantconnect.com/datasets/quantconnect-us-equity-security-master/pricing">US Equity Security Master</a></li>
    <li><a href='https://www.quantconnect.com/datasets/quantconnect-us-equity-option-universe'>US Equity Option Universe</a></li>
    <li>Some data from the <a href="https://www.quantconnect.com/datasets/algoseek-us-equity-options/pricing">US Equity Options</a> dataset</li>
    <li>Data for the underlying <a href='https://www.quantconnect.com/docs/v2/lean-cli/datasets/quantconnect/download-by-ticker/costs#02-US-Equity'>US Equity universes and assets</a></li>
</ul>

<p>The following table shows the cost of an annual subscription to the US Equity Security Master for each organization tier:</p>

<? include(DOCS_RESOURCES."/datasets/us-equity-security-master-price.html"); ?>

<p>The file format of the US Equity Option Universe data is one file per underlying Equity and each file costs 100 QCC = $1 USD.</p>

<p>The US Equity Options dataset is available is several resolutions. The resolution you need depends on the US Equity Option subscriptions you create in your algorithm and the resolution of data you get in <a href="https://www.quantconnect.com/docs/v2/writing-algorithms/historical-data/history-requests">history requests</a>. The following table describes the file format and costs of each resolution:</p>

<table class="qc-table table">
    <thead>
        <tr>
            <th>Resolution</th>
            <th>File Format</th>
            <th>Cost per file</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Minute</td>
            <td>One file per Option per trading day per data format. Quote, trade, and open interest data are separate files.</td>
            <td>15 QCC = $0.15 USD</td>
        </tr>
        <tr>
            <td>Hour</td>
            <td>One file per Option per year per data format. Trade and open interest data are separate files.</td>
            <td>900 QCC = $9 USD</td>
        </tr>
        <tr>
            <td>Daily</td>
            <td>One file per Option per year. Trade and open interest data are separate files.</td>
            <td>300 QCC = $3 USD</td>
        </tr>
    </tbody>
</table>

<p>For example, the following algorithm subscribes to minute resolution data for an Equity Option and its underlying asset:<br></p>



<div class="section-example-container">
<pre class="csharp">public class USEquityOptionsDataAlgorithm : QCAlgorithm
{
    public override void Initialize()
    {
        SetStartDate(2020, 1, 1);
        SetEndDate(2021, 1, 1);
        UniverseSettings.Asynchronous = true;
        var underlying = AddEquity("GOOG").Symbol;
        AddOption(underlying);
    }
}</pre>
<pre class="python">class USEquityOptionsDataAlgorithm(QCAlgorithm):
    def initialize(self) -&gt; None:
        self.set_start_date(2020, 1, 1)
        self.set_end_date(2021, 1, 1)
        self.universe_settings.asynchronous = True
        underlying = self.add_equity("GOOG").symbol
        self.add_option(underlying)</pre>
</div>

<p>The following table shows the data cost of the preceding algorithm on the Quant Researcher tier:</p>

<table class="qc-table table">
    <thead>
        <tr>
            <th>Dataset</th>
            <th>Package</th>
            <th>Initial Cost</th>
            <th>Ongoing Cost</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>US Equity Security Master</td>
            <td>Download On Premise</td>
            <td>$600 USD</td>
            <td>$600 USD/year</td>
        </tr>
        <tr>
            <td>US Equity Option Universe</td>
            <td>Download On Premise</td>
            <td>
                1 underlying Equity over 252 trading days
                <br>=&gt; 1 * 252 files
                <br>= 252 files
                <br>
                <br>252 files @ 100 QCC/file
                <br>=&gt; 252 * 100 QCC
                <br>= 25,200 QCC
                <br>= $252 USD
            </td>
            <td>
                1 underlying Equity
                <br>=&gt; 1 file/day
                <br>
                <br>1 file/day @ 100 QCC/file
                <br>= 100 QCC/day
                <br>= $1 USD/day
            </td>
        </tr>
        <tr>
            <td>US Equity</td>
            <td>Minute Download</td>
            <td>
                1 security over 252 trading days with 2 data formats
                <br>=&gt; 1 * 252 * 2 files
                <br>= 504 files
                <br>
                <br>504 files @ 5 QCC/file
                <br>=&gt; 504 * 5 QCC 
                <br>= 2,520 QCC 
                <br>= $25.20 USD
            </td>
            <td>
                1 security with 2 data formats
                <br>=&gt; 2 files/day
                <br>
                <br>2 files/day @ 5 QCC/file
                <br>=&gt; 2 * 5 QCC/day
                <br>= 10 QCC/day
                <br>= $0.10 USD/day
            </td>
        </tr>
        <tr>
            <td>US Equity Options</td>
            <td>Minute Download</td>
            <td>
                1 Option over 252 trading days with 3 data formats
                <br>=&gt; 1 * 252 * 3 files
                <br>= 756 files
                <br>
                <br>756 files @ 15 QCC/file
                <br>=&gt; 756 * 15 QCC 
                <br>= 11,360 QCC 
                <br>= $113.60 USD
            </td>
            <td>
                1 Option with 3 data formats
                <br>=&gt; 3 files/day
                <br>
                <br>3 files/day @ 15 QCC/file
                <br>=&gt; 3 * 15 QCC/day
                <br>= 45 QCC/day
                <br>= $0.45 USD/day
            </td>
        </tr>
    </tbody>
</table>

<p>The preceding table assumes you download trade, quote, and open interest data. However, you can run backtests with only trade data.</p>
