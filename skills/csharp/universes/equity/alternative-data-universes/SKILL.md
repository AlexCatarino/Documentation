---
name: alternative-data-universes
description: Use when selecting a dynamic Equity universe from an alternative-data class in a QuantConnect/LEAN algorithm — calling `AddUniverse<AltClass>(selector)` with Brain, CoinGecko, EOD Historical Data, Quiver Quantitative, or Smart Insider universe classes. Triggers — questions like "which class do I pass to add_universe for Brain sentiment / Quiver insider trades / Smart Insider buybacks / EODHD upcoming earnings / CoinGecko market cap", missing-class compile errors on names like `BrainSentimentIndicatorUniverse` or `EODHDUpcomingEarnings`. Skip when — the universe is Morningstar Fundamental (use `fundamental-universes`), ETF constituents (use `Universe.ETF(...)`), or pure indicator-driven selection (use `indicator-universes`).
---

# Available Alternative Data Universes

The snippets below show how to call `AddUniverse<AltClass>(selector)` with each alternative-data universe class. Replace `Universe.Unchanged` with your selection logic.

## Brain Language Metrics on Company Filings

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<BrainCompanyFilingLanguageMetricsUniverseAll>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<BrainCompanyFilingLanguageMetricsUniverseAll> altCoarse)
{
    return Universe.Unchanged;
}
```

## Brain ML Stock Ranking

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<BrainStockRankingUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<BrainStockRankingUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## Brain Sentiment Indicator

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<BrainSentimentIndicatorUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<BrainSentimentIndicatorUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## Crypto Market Cap

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<CoinGeckoUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<CoinGeckoUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## Upcoming Dividends

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<EODHDUpcomingDividends>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<EODHDUpcomingDividends> altCoarse)
{
    return Universe.Unchanged;
}
```

## Upcoming Earnings

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<EODHDUpcomingEarnings>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<EODHDUpcomingEarnings> altCoarse)
{
    return Universe.Unchanged;
}
```

## Upcoming IPOs

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<EODHDUpcomingIPOs>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<EODHDUpcomingIPOs> altCoarse)
{
    return Universe.Unchanged;
}
```

## Upcoming Splits

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<EODHDUpcomingSplits>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<EODHDUpcomingSplits> altCoarse)
{
    return Universe.Unchanged;
}
```

## CNBC Trading

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<QuiverCNBCsUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<QuiverCNBCsUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## Corporate Lobbying

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<QuiverLobbyingUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<QuiverLobbyingUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## Insider Trading

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<QuiverInsiderTradingUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<QuiverInsiderTradingUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## US Congress Trading

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<QuiverQuantCongressUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<QuiverQuantCongressUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## US Government Contracts

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<QuiverGovernmentContractUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<QuiverGovernmentContractUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## WallStreetBets

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<QuiverWallStreetBetsUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<QuiverWallStreetBetsUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

## Corporate Buybacks

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<SmartInsiderIntentionUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<SmartInsiderIntentionUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```

```csharp
private Universe _universe;

public override void Initialize()
{
    _universe = AddUniverse<SmartInsiderTransactionUniverse>(UniverseSelection);
}

private IEnumerable<Symbol> UniverseSelection(IEnumerable<SmartInsiderTransactionUniverse> altCoarse)
{
    return Universe.Unchanged;
}
```
