<p>The <code class="csharp">Asynchronous</code><code class="python">asynchronous</code> setting is a <code>bool</code> that defines whether or not LEAN can run universe selection asynchronously, utilizing concurrent execution to increase the speed of your algorithm. The default value for this setting is <code class='csharp'>false</code><code class='python'>False</code>. If you enable this setting, abide by the following rules:</p>

<ul>
    <li>Don't make any <a href='/docs/v2/writing-algorithms/historical-data/history-requests'>history requests</a> in your <a href='/docs/v2/writing-algorithms/universes/key-concepts#05-Selection-Functions'>filter function</a>. History requests can only provide data up to the <a href='/docs/v2/writing-algorithms/key-concepts/time-modeling/timeslices#02-Time-Frontier'>algorithm time</a>, but if your filter function runs asynchronously, the algorithm time may not be what you expect.</li>
    <li>Don't use the portfolio, security, or orders state. The <code class="csharp">Portfolio</code><code class="python">portfolio</code>, <code class="csharp">Securities</code><code class="python">securities</code>, and <code class="csharp">Transactions</code><code class="python">transactions</code> objects are also functions of the algorithm time.</li>
    <li>If your filter function updates a class variable, don't update the class variable anywhere else in your algorithm.</li>
</ul>

<p>To enable asynchronous universe selection, in the <a href='/docs/v2/writing-algorithms/initialization'>Initialize</a> method, adjust the algorithm's <code class="csharp">UniverseSettings</code><code class="python">universe_settings</code> before you 
