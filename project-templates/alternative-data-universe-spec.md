# Adding an Alternative-Data Universe Template

End-to-end recipe for adding a new `alternative-data-universe-<class>` template (Python + C#) and verifying it on QuantConnect Cloud. Each entry pairs a docs Universe Selection example with the universal scheduled-rebalance trading wrapper, then deploys and backtests both languages to confirm parity.

## 1. Inputs

For the new universe, you need:

- **Universe class name** (e.g. `QuiverCNBCsUniverse`, `BrainStockRankingUniverse`)
- **Selection logic** from `03 Writing Algorithms/14 Datasets/<provider>/<dataset>/<NN> Universe Selection.html` (Python and C# blocks). Some datasets show the universe under `Example Applications.html` instead.
- **Friendly title** for the QC Cloud project name and the templates.json entry (e.g. "WallStreetBets")

## 2. Outputs

For each universe, produce:

| File | Purpose |
| --- | --- |
| `project-templates/python/alternative-data-universe-<class>/main.py` | Python template |
| `project-templates/csharp/alternative-data-universe-<class>/Main.cs` | C# template |
| `project-templates/python/templates.json` | Add one entry to the array |
| QC Cloud project `Docs/Templates/AlternativeData/<friendly> Python` | Deployed + backtested |
| QC Cloud project `Docs/Templates/AlternativeData/<friendly> CSharp` | Deployed + backtested |

The `templates.json` lives only on the python side and is the single registry for both languages.

## 3. Folder naming

`<class>` is the Universe class name lowercased with no separators:

| Class | Folder slug |
| --- | --- |
| `QuiverCNBCsUniverse` | `quivercnbcsuniverse` |
| `BrainCompanyFilingLanguageMetricsUniverseAll` | `braincompanyfilinglanguagemetricsuniverseall` |
| `EODHDUpcomingEarnings` | `eodhdupcomingearnings` |

Smart Insider exposes two universe classes (`SmartInsiderIntentionUniverse`, `SmartInsiderTransactionUniverse`); produce one template per class.

## 4. Trading wrapper (universal)

Both Python and C# templates use the same shape: dynamic universe + scheduled daily rebalance + equal weight. The user-facing trading logic lives entirely in the rebalance method and is identical across all templates. **Do not** swap in `ConstantAlphaModel` / `EqualWeightingPortfolioConstructionModel` — those were the old shape and have been replaced.

### Python skeleton

```python
# region imports
from AlgorithmImports import *
# endregion

class <Name>UniverseAlgorithm(QCAlgorithm):

    def initialize(self) -> None:
        self.set_start_date(2024, 9, 1)
        self.set_end_date(2024, 12, 31)
        self.set_cash(100000)

        self.universe_settings.resolution = Resolution.DAILY
        # <one-line description of what passes the filter>
        self._universe = self.add_universe(<UniverseClass>, self._select_assets)

        # Rebalance shortly after the open so today's universe is locked in.
        self.schedule.on(self.date_rules.every_day("SPY"), self.time_rules.at(9, 0, 0), self._rebalance)

    def _select_assets(self, data: List[<UniverseClass>]) -> List[Symbol]:
        # <selection comment>
        return [d.symbol for d in data
                if <truthy guard> and <comparison> ...]

    def _rebalance(self) -> None:
        if not self._universe.selected:
            return

        weight = 1 / len(self._universe.selected)
        targets = [PortfolioTarget(symbol, weight) for symbol in self._universe.selected]

        self.set_holdings(targets, liquidate_existing_holdings=True)
```

### C# skeleton

```csharp
using System.Linq;
using QuantConnect.Algorithm.Framework.Portfolio;
using QuantConnect.Data.UniverseSelection;
using QuantConnect.DataSource;

namespace QuantConnect.Algorithm.CSharp
{
    public class <Name>UniverseAlgorithm : QCAlgorithm
    {
        private Universe _universe;

        public override void Initialize()
        {
            SetStartDate(2024, 9, 1);
            SetEndDate(2024, 12, 31);
            SetCash(100000);

            UniverseSettings.Resolution = Resolution.Daily;
            // <one-line description of what passes the filter>
            _universe = AddUniverse<<UniverseClass>>(data =>
            {
                return from d in data.OfType<<UniverseClass>>()
                       where <conditions>
                       select d.Symbol;
            });

            // Rebalance shortly after the open so today's universe is locked in.
            Schedule.On(DateRules.EveryDay("SPY"), TimeRules.At(9, 0, 0), Rebalance);
        }

        private void Rebalance()
        {
            if (_universe.Selected.Count == 0)
            {
                return;
            }

            var weight = 1m / _universe.Selected.Count;
            var targets = _universe.Selected
                .Select(symbol => new PortfolioTarget(symbol, weight))
                .ToList();

            SetHoldings(targets, liquidateExistingHoldings: true);
        }
    }
}
```

Add `using QuantConnect.Orders;` if the selection touches `OrderDirection`. Add `using System.Collections.Generic;` if the selection builds a `Dictionary` for aggregation.

## 5. Selection-clause conventions

### Python — one-liner with positive truthy guard

When the comparison is `> Y` for a positive Y, write:

```python
return [d.symbol for d in data
        if d.amount and d.amount > 200000
        and d.transaction == OrderDirection.BUY]
```

`d.amount and d.amount > 200000` reads "amount is truthy AND > 200000". The truthy short-circuit handles None safely. **Do not** use `not d.amount and ...` — that inverts the meaning and raises on None. **Do not** use `d.amount is not None and ...` — verbose; the truthy form is preferred.

For nested attributes (Brain Language Metrics), guard each level:

```python
return [d.symbol for d in data
        if d.report_sentiment and d.report_sentiment.sentiment and d.report_sentiment.sentiment > 0
        ...]
```

For aggregations across multiple records per symbol (Lobbying, Insider Trading, Government Contracts, CNBC), use a dict and a list comprehension; coerce `None` numeric fields with `(x.amount or 0)` inside `sum()`:

```python
def _select_assets(self, data):
    by_symbol = {}
    for d in data:
        by_symbol.setdefault(d.symbol, []).append(d)
    return [s for s, ds in by_symbol.items()
            if len(ds) >= 3 and sum(x.amount or 0 for x in ds) > 50000]
```

### C# — LINQ `where ... select`

C# nullable decimals (`decimal?`) silently return false on `null > 0m`, so the docs C# can be ported as-is. Aggregations use `GroupBy(x => x.Symbol)` + `Sum`/`Count`.

## 6. Attribute-name gotcha (Python)

QC's pythonnet generates snake_case aliases by inserting an underscore on **both sides** of each digit run:

| C# property | Python (snake_case) | Wrong form often shown in docs HTML |
| --- | --- | --- |
| `Rank2Days` | `rank_2_days` | `rank2_days` |
| `Sentiment7Days` | `sentiment_7_days` | `sentiment7_days` |
| `TotalArticleMentions7Days` | `total_article_mentions_7_days` | `total_article_mentions7_days` |

Both PascalCase (`Rank2Days`) and the correct snake_case work in Python; prefer snake_case for idiomatic templates.

If unsure, probe by uploading a one-shot algorithm that raises with the attribute list:

```python
def _select(self, data):
    for d in data:
        attrs = sorted(a for a in dir(d) if not a.startswith('_') and 'rank' in a.lower())
        raise RuntimeError(f"PROBE: {attrs}")
    return []
```

The exception message lands in `/backtests/read` → `backtest.error`. (There is no `/backtests/read/logs` endpoint in QC Cloud API v2 — `self.debug` output isn't retrievable that way.)

## 7. `add_universe` signature variants

Most universes take the 2-arg form `add_universe(<Class>, selector)`. A few take a 4-arg form with explicit name + resolution — keep the original signature from the docs:

```python
self._universe = self.add_universe(QuiverLobbyingUniverse, "QuiverLobbyingUniverse",
                                   Resolution.DAILY, self._select_assets)

self._universe = self.add_universe(CoinGeckoUniverse, "CoinGeckoUniverse",
                                   Resolution.DAILY, self._select_assets)
```

C# equivalent:

```csharp
_universe = AddUniverse<QuiverLobbyingUniverse>("QuiverLobbyingUniverse", Resolution.Daily, data => ...);
```

## 8. `templates.json` entry

Append one entry to `project-templates/python/templates.json` inside the `templates` array (after the existing alt-data-universe entries to keep them grouped):

```json
{
    "name": "Alternative Data Universe for <Friendly Title>",
    "folder": "alternative-data-universe-<class>",
    "description": "Selects <criteria> and equal-weights them with a daily scheduled rebalance.",
    "tags": ["alternative-data", "universe", "equity"]
}
```

- **Description style:** "Selects <noun phrase from filter> and equal-weights them with a daily scheduled rebalance." Two clauses — what's selected, how it trades.
- **Tags:** always `["alternative-data", "universe", <asset-tag>]`. Asset tag is `equity` for stock universes, `crypto` for CoinGecko. Add a second domain tag (e.g. `earnings`, `dividends`, `splits`, `ipos`) for the EODHD upcoming-event datasets.
- After editing, validate with `python -c "import json; json.load(open(r'project-templates/python/templates.json'))"`.

## 9. Syntax-check before deploy

Before creating a QC Cloud project, run each entry file through `/ai/tools/syntax-check` (see [.claude/skills/qc-cloud-backtest/SKILL.md](.claude/skills/qc-cloud-backtest/SKILL.md), Step 0). The endpoint is free and fast — it catches typos and missing imports that would otherwise cost a project + a compile round-trip and leave a dead project behind.

Response shape: `{state, payload}`. `state == "End"` means clean. `state == "Error"` means `payload` is a list of human-readable error strings. **Use the payload to fix the source locally**, then re-check until clean. Only proceed to `/projects/create` after a clean check for both Python and C#.

```python
def syntax_check(language, entry_file, source):
    r = post(f"{BASE_URL}/ai/tools/syntax-check", headers=headers(), json={
        "language": language,  # "Py" or "C#"
        "files": [{"name": entry_file, "content": source}],
    }).json()
    if r.get("state") == "Error":
        raise RuntimeError(f"Syntax errors in {entry_file}:\n" + "\n".join(r["payload"]))

syntax_check("Py", "main.py", py_path.read_text())
syntax_check("C#", "Main.cs", cs_path.read_text())
```

Common payload categories worth auto-fixing in templates:

| Payload pattern | Fix |
| --- | --- |
| Missing `using` for `OrderDirection` / `PortfolioTarget` / `DataSource` types | Add the corresponding `using QuantConnect.Orders;` / `QuantConnect.Algorithm.Framework.Portfolio;` / `QuantConnect.DataSource;` |
| Unknown class name (e.g. `QuiverQuantCongresssUniverse` with three s's) | Cross-check the docs typo against the actual class name (often the cleaner spelling); update the template |
| `'EODHD' is a type not a namespace` (C#) | The `EODHD` symbol is itself a class containing nested types. Drop `using QuantConnect.DataSource.EODHD;`, fully qualify the nested type as `EODHD.DealType` (with `using QuantConnect.DataSource;` already present). |
| `'>' not supported between instances of 'NoneType' and 'int'` won't surface here — it's a runtime-only issue. Section 6 still applies. | — |

### Known false positives

`/ai/tools/syntax-check` uses static type stubs that are sometimes stale relative to the deployed runtime. When a payload reports `"<Class>" has no attribute "x"` (Python) or `<Class> does not contain a definition for X` (C#), and the docs HTML used `x`/`X`, **verify against the runtime probe** (section 6) before changing the template:

- If `dir(d)` confirms the attribute exists at runtime, the template is correct — ignore the syntax-check error.
- Witnessed example: `QuiverQuantCongressUniverse` exposes both `amount`/`Amount` and `transaction`/`Transaction` at runtime, but syntax-check claims neither exists and suggests fictitious `amount_value`/`direction` replacements. The original docs names are right.

This step does **not** replace the compile step (section 10) — `/compile/create` performs deeper checks (type resolution, framework references). Syntax-check is a cheap pre-filter, with the false-positive caveat above.

## 10. Deploy + backtest on QC Cloud

Use the QC Cloud API v2 (see [.claude/skills/qc-cloud-backtest/SKILL.md](.claude/skills/qc-cloud-backtest/SKILL.md)). Project names: `Docs/Templates/AlternativeData/<friendly> Python` and `Docs/Templates/AlternativeData/<friendly> CSharp`.

For batches of universes, run pairs sequentially (Python and C# in the same iteration), waiting for both backtests before moving to the next pair. Reuse already-deployed projects when iterating on fixes (`/files/update` + `/compile/create` instead of creating a new project each time). Track which project IDs already have a passing backtest so you don't redo them.

End-to-end pseudocode for one pair (assumes both files passed section 9):

```python
py_id = create_project(f"Docs/Templates/AlternativeData/{friendly} Python", "Py")
cs_id = create_project(f"Docs/Templates/AlternativeData/{friendly} CSharp", "C#")

for pid, entry, source in [(py_id, "main.py", py_path), (cs_id, "Main.cs", cs_path)]:
    upload(pid, entry, source)
    cid = start_compile(pid)
    poll_compile(pid, cid)  # state must be "BuildSuccess"
    bid = start_backtest(pid, cid, run_name)
    bt = poll_backtest(pid, bid)  # poll /backtests/read until completed=True
    print(bt["status"], bt["statistics"])
```

## 11. Validation criteria

A new pair is good when **all** hold:

1. Both Python and C# `BuildSuccess`.
2. Both backtests reach status `Completed.` (not `Runtime Error`).
3. Their statistics match — same `Net Profit`, `Total Orders`, `Win Rate`, `Drawdown`. Mismatched stats mean the selection logic diverged between languages.

`Total Orders: 0` is acceptable when the dataset is genuinely sparse over the backtest window (Brain Sentiment Indicator with `> 0` on both sentiment and mentions falls in this bucket). It is **not** acceptable if only one language returns 0 — that signals a Python attribute-name bug or a None comparison that silently filters everything in C#.

## 12. Special cases

- **Crypto (CoinGecko)** — both Python and C# Runtime Error under the universal wrapper because crypto holdings interact differently with `set_holdings(liquidate_existing_holdings=True)` (cash currency holdings are not equity positions). The CoinGecko template needs additional setup: a brokerage model (`set_brokerage_model(BrokerageName.COINBASE, AccountType.CASH)`) and likely a different rebalance pattern. Treat as a separate effort — the universe selection is fine, the trading wrapper is not.
- **Brain Sentiment Indicator** — selects 0 stocks under `sentiment_7_days > 0 AND total_article_mentions_7_days > 0` for the default Sep–Dec 2024 window. This is data sparsity, not a bug. Both Python and C# return 0 orders identically; ship as-is.
- **Smart Insider** — two universe classes share one dataset. Produce two separate templates (`smartinsiderintentionuniverse`, `smartinsidertransactionuniverse`).
- **Brain Language Metrics MD&A field** — keep the long attribute name `management_discussion_analyasis_of_financial_condition_and_results_of_operations` verbatim, including the `analyasis` typo carried by the SDK.

## 13. Order of work for a new universe

1. Read `<NN> Universe Selection.html` (and `Example Applications.html` for context).
2. Create the two folders under `project-templates/python/` and `project-templates/csharp/`.
3. Write `main.py` and `Main.cs` from the skeletons in section 4, plugging in the selection clause from section 5.
4. Add the `templates.json` entry per section 8 and validate JSON.
5. Run `/ai/tools/syntax-check` against both files (section 9). Fix any payload errors locally and re-check until clean.
6. Deploy both projects on QC Cloud per section 10.
7. Backtest both, confirm the validation criteria in section 11.
8. If Python fails with `AttributeError`, probe attributes (section 6) and fix; redeploy file via `/files/update` and rerun.
9. If Python and C# stats diverge, audit the selection clause for None handling (Python truthy guard) — C# silently passes through nulls.
