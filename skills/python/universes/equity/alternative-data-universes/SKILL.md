---
name: alternative-data-universes
description: Use when selecting a dynamic Equity universe from an alternative-data class in a QuantConnect/LEAN algorithm — calling `add_universe(<AltClass>, selector)` with Brain, CoinGecko, EOD Historical Data, Quiver Quantitative, or Smart Insider universe classes. Triggers — questions like "which class do I pass to add_universe for Brain sentiment / Quiver insider trades / Smart Insider buybacks / EODHD upcoming earnings / CoinGecko market cap", missing-class compile errors on names like `BrainSentimentIndicatorUniverse` or `EODHDUpcomingEarnings`. Skip when — the universe is Morningstar Fundamental (use `fundamental-universes`), ETF constituents (use `self.universe.etf(...)`), or pure indicator-driven selection (use `indicator-universes`).
---

# Available Alternative Data Universes

The snippets below show how to call `add_universe(<AltClass>, selector)` with each alternative-data universe class. Replace `Universe.UNCHANGED` with your selection logic.

## Brain Language Metrics on Company Filings

```python
def initialize(self) -> None:
    self._universe = self.add_universe(BrainCompanyFilingLanguageMetricsUniverseAll, self.universe_selection)

def universe_selection(self, alt_coarse: List[BrainCompanyFilingLanguageMetricsUniverseAll]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Brain ML Stock Ranking

```python
def initialize(self) -> None:
    self._universe = self.add_universe(BrainStockRankingUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[BrainStockRankingUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Brain Sentiment Indicator

```python
def initialize(self) -> None:
    self._universe = self.add_universe(BrainSentimentIndicatorUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[BrainSentimentIndicatorUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Crypto Market Cap

```python
def initialize(self) -> None:
    self._universe = self.add_universe(CoinGeckoUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[CoinGeckoUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Upcoming Dividends

```python
def initialize(self) -> None:
    self._universe = self.add_universe(EODHDUpcomingDividends, self.universe_selection)

def universe_selection(self, alt_coarse: List[EODHDUpcomingDividends]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Upcoming Earnings

```python
def initialize(self) -> None:
    self._universe = self.add_universe(EODHDUpcomingEarnings, self.universe_selection)

def universe_selection(self, alt_coarse: List[EODHDUpcomingEarnings]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Upcoming IPOs

```python
def initialize(self) -> None:
    self._universe = self.add_universe(EODHDUpcomingIPOs, self.universe_selection)

def universe_selection(self, alt_coarse: List[EODHDUpcomingIPOs]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Upcoming Splits

```python
def initialize(self) -> None:
    self._universe = self.add_universe(EODHDUpcomingSplits, self.universe_selection)

def universe_selection(self, alt_coarse: List[EODHDUpcomingSplits]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## CNBC Trading

```python
def initialize(self) -> None:
    self._universe = self.add_universe(QuiverCNBCsUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[QuiverCNBCsUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Corporate Lobbying

```python
def initialize(self) -> None:
    self._universe = self.add_universe(QuiverLobbyingUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[QuiverLobbyingUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Insider Trading

```python
def initialize(self) -> None:
    self._universe = self.add_universe(QuiverInsiderTradingUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[QuiverInsiderTradingUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## US Congress Trading

```python
def initialize(self) -> None:
    self._universe = self.add_universe(QuiverQuantCongressUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[QuiverQuantCongressUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## US Government Contracts

```python
def initialize(self) -> None:
    self._universe = self.add_universe(QuiverGovernmentContractUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[QuiverGovernmentContractUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## WallStreetBets

```python
def initialize(self) -> None:
    self._universe = self.add_universe(QuiverWallStreetBetsUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[QuiverWallStreetBetsUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

## Corporate Buybacks

```python
def initialize(self) -> None:
    self._universe = self.add_universe(SmartInsiderIntentionUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[SmartInsiderIntentionUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```

```python
def initialize(self) -> None:
    self._universe = self.add_universe(SmartInsiderTransactionUniverse, self.universe_selection)

def universe_selection(self, alt_coarse: List[SmartInsiderTransactionUniverse]) -> List[Symbol]:
    return Universe.UNCHANGED
```
