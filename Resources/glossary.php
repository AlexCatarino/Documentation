<?php
$definitionByTerm = array(
    "alpha" => "The quantity of an algorithm's returns that aren't explained by its underlying benchmark.",
    "annual standard deviation" => "A staticial measure that describes the dispersion of annual returns relative to the mean annual return. It's the square root of the annual variance.",
    "annual variance" => "A staticial measure that describes the dispersion of annual returns relative to the mean annual return.",
    "average loss" => "The average rate of return for unprofitable trades.",
    "average win" => "The average rate of return for profitable trades.",
    "beta" => "The scale and direction of an algorithm's returns relative to movements in the underlying benchmark.",
    "capacity" => "The maximum amount of money an algorithm can trade before its performance degrades from market impact.",
    "compounding annual return" => "The annual percentage return that would be required to grow a portfolio from its starting value to its ending value.",
    "day trade" => "Buying and selling the same asset within one trading day.",
    "drawdown" => "The largest peak to trough decline in an algorithm's equity curve.",
    "equity" => "The total portfolio value if all of the holdings were sold at current market rates.", 
    "expectancy" => "The expected return per trade.",
    "holdings" => "The absolute sum of the items in the portfolio.",
    "information ratio" => "The amount of excess return from the risk-free rate per unit of systematic risk.",
    "intrinsic value" => array("Call Option" => "The price of an asset minus the strike price if the price is above the strike price, otherwise zero.", "Put Option" => "The strike price minus the price of an asset if the price is below the strike price, otherwise zero."),
    "look-ahead bias" => "The practice of making decisions using information that would not be available until some time in the future.", 
    "loss rate" => "The proportion of trades that were not profitable.",
    "lowest capacity asset" => "The asset an algorithm traded that has the lowest capacity.",
    "net profit" => array("Percent" => "The rate of return across the entire trading period.", "Dollar-value" => "The dollar-value return across the entire trading period."),
    "out-of-the-money amount" => array("Call Option" => "The strike price minus the price of an asset if the price is below the strike price, otherwise zero.", "Put Option" => "The price of an asset minus the strike price if the price is above the strike price, otherwise zero."),
    "payoff" => "The profit or loss that an Option buyer or seller makes from a trade.",
    "pattern day trader" => "A trader who executes four or more day trades in the US Equity market within five business days.",
    "Probabilistic Sharpe ratio" => "The probability that the estimated Sharpe ratio of an algorithm is greater than a benchmark (1).",
    "profit-loss ratio" => "The ratio of the average win rate to the average loss rate.",
    "return" => "The rate of return across the entire trading period.",
    "Sharpe ratio" => "A measure of the risk-adjusted return, developed by William Sharpe.",
    "total fees" => "The total quantity of fees paid for all the transactions.",
    "total net profit" => "The rate of return across the entire trading period.", 
    "total trades" => "The number of orders that were filled or partially filled.",
    "tracking error" => "A measure of how closely a portfolio follows the index to which it is benchmarked. A tracking error of 0 is a perfect match.",
    "Treynor ratio" => "A measurement of the returns earned in an algorithm in excess of the risk-free rate per unit of benchmark risk, developed by Jack Treynor.",
    "unrealized" => "The amount of profit a portfolio would capture if it liquidated all open positions and paid the fees for transacting and crossing the spread.",
    "volume" => "The total value of assets traded for all of an algorithm's transactions.",
    "win rate" => "The proportion of trades that were profitable after transaction fees."
);
    
$getGlossaryTermHTML = function($term) use ($definitionByTerm)
{
    $definition = $definitionByTerm[$term];
    if (is_string($definition))
    {
        echo "<p>{$definition}</p>";
    }
    else if (is_array($definition))
    {
        foreach ($definition as $key => $value)
        {
            echo "<p><span class='qualifier'>({$key})</span> {$value}</p>";
        }
    }
    else
    {
        echo "returned {$definition}";
    }
};
?>
