<p>The following table describes the arguments that the automatic Option indicators methods accept:</p>

<table class="qc-table table">
    <thead>
        <tr>
            <th>Argument</th>
            <th>Data Type</th>
            <th>Description</th>
            <th>Default Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>symbol</code></td>
            <td><code>Symbol</code></td>
            <td>The contract to use when calculating the indicator values.</td>
            <td></td>
        </tr>
        <tr>
            <td><code class="csharp">mirrorOption</code><code class="python">mirror_option</code></td>
            <td><code>Symbol</code></td>
            <td>The mirror contract to use in parity type calculations.</td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code class="csharp">riskFreeRate</code><code class="python">risk_free_rate</code></td>
            <td><code class="csharp">decimal</code><code class="python">float</code></td>
            <td>
                The risk-free interest rate. 
                If you don't provide a value, the default value is the US primary credit rate from the <a href='/docs/v2/writing-algorithms/reality-modeling/risk-free-interest-rate/supported-models#04-Interest-Rate-Provider-Model'>Interest Rate Provider Model</a>.
            </td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code class="csharp">dividendYield</code><code class="python">dividend_yield</code></td>
            <td><code class="csharp">decimal</code><code class="python">float</code></td>
            <td>
                The dividend yield rate.
                If you don't provide a value, the default value comes from the <a href="/docs/v2/writing-algorithms/reality-modeling/dividend-yield/supported-models#04-Dividend-Yield-Provider-Model">Dividend Yield Provider Model</a>.
            </td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code class="csharp">optionModel</code><code class="python">option_model</code></td>
            <td><code>OptionPricingModelType</code></td>
            <td>
                The Option pricing model that's used to calculate the Greeks. 
                If you don't provide a value, the default value is <?=$defaultPricingModel?>.
            </td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code>resolution</code></td>
            <td><code>Resolution</code></td>
            <td>
                The resolution of the indicator data.
                If you don't provide a value, the default value is the resolution of the subscription you have for the Option contract(s).
            </td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
    </tbody>
</table>

<p>
    To perform implied volatility (IV) smoothing with a put-call pair, pass one of the contracts as the <code>symbol</code> argument and pass the other contract in the pair as the <code class="csharp">mirrorOption</code><code class="python">mirror_option</code> argument.
    The default IV smoothing method uses the one contract in the pair that's at-the-money or out-of-money to calculate the IV. 
    To change the smoothing function, call the <code class="csharp">SetSmoothingFunction</code><code class="python">set_smoothing_function</code> method of the <code>ImpliedVolatility</code> class/property.
</p>

<p>Several different Option pricing models are supported to calculate the IV and Greeks. The following table describes the <code>OptionPricingModelType</code> enumeration members:</p>
<div data-tree='QuantConnect.Indicators.OptionPricingModelType'></div>
