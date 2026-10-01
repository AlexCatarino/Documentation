# Handoff: VS Code dev container workflow for dataset contributors

## Where this came from

The local branch `feature-dev-container` held one commit, `f91b533e8d` ("WIP", 2023-01-18). It never had a PR or a remote copy. The branch is deleted; run `git show f91b533e8d` to see the commit until Git garbage-collects it. This note keeps what is worth keeping.

The commit edited the old `06 LEAN Engine/07 Contributing Datasets` tutorial. The 2023-02-03 "Contributing redesign" (`fdeefda772`) replaced that tutorial with `06 LEAN Engine/02 Contributions/01 Datasets`. The commit no longer applies: it conflicts in every file it touches.

## What the commit did

It added a [VS Code Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) workflow so contributors could build, run, and debug a dataset without installing .NET or Visual Studio:

1. **Set Up Coding Environment** (new page): install VS Code, the Dev Containers extension, and Docker.
2. **Create Data Source Repository** (new page): create the repository from the SDK template, run the rename script, set `mounts` in the SDK's `devcontainer.json`, reopen in the container, and build with `dotnet build QuantConnect.DataSource.csproj` or Ctrl+Shift+B.
3. **Clone Lean** (new page): fork and clone LEAN, mount the data folder and the data source repository in LEAN's `devcontainer.json`, set `"data-folder": "/Data/"` in `Launcher/config.json`, and press F5 to run `BasicTemplateFrameworkAlgorithm`.
4. **Define Data Type** (trading and universe): open the repository in the container first and build at the end.
5. **Write a Processing Script**: open the container first; debug the C# processor from Run and Debug with Ctrl+F5. It also linked the QuiverQuantTwitterFollowers `process.py` and `Program.cs` as examples.
6. **Listing Your Dataset** and **Testing Your Implementation** (new pages): demo algorithms, unit tests, and testing the processed data in LEAN. The redesign already covers this content.
7. Root-relative link rewrites to an `/our-platform/` docs path that never shipped. Drop these.

## What still applies today

| Fact | Status (2026-10-01) |
|---|---|
| LEAN ships a dev container | Yes: `Lean/.devcontainer/devcontainer.json` and a Dockerfile. `Lean/.vscode/readme.md` "Option 2: Lean Development Container" documents it. `mounts` is empty with a commented data-folder example. |
| The SDK ships a dev container | **No.** `Lean.DataSource.SDK` has no `.devcontainer` folder, and its history has none. Step 2 above depends on a file that doesn't exist. |
| The SDK ships VS Code configs | Yes: `.vscode/launch.json` has "Run Data Processor" and "Run Tests"; `tasks.json` has `build`, `test`, and `run-data-processor`. |
| The docs mention dev containers | No page does. |

## Bugs in the current docs that this review found

These are on master now, separate from the dev container work. Fix them in the same PR or first.

- `02 Defining Data Models/02 Part 1%2F Set up SDK.html` says to `chmod` and run `renameDataset.sh`. The SDK ships `renameDataset.py`, which takes two PascalCase arguments: `python renameDataset.py <VendorName> <DatasetName>` (`--dry-run` previews). The script renames `MyCustomDataType.cs`, `Demonstration.*`, the tests, and the `output/alternative/myvendorname/mydatasetname` sample folder.
- `05 Testing Data Models/02 Run Demonstration Algorithms.html` and `03 Run Unit Tests.html` say `net9.0`. The SDK targets `net10.0` (see `.vscode/launch.json`).
- `04 Rendering Data/02 Rendering Data with CSharp/02 Using Processing Framework.html` declares `var mapFileProvider` twice in the snippet and misspells `pointInIimeTicker`.

## How to document it

Recommended scope: one optional page that shows the VS Code route next to the Visual Studio steps the tutorial already has. Don't rewrite the tutorial around containers.

1. Add a section to `02 Defining Data Models/02 Part 1%2F Set up SDK.html` (or a sibling page) titled along the lines of "Use Visual Studio Code". Cover:
   - Open the data source repository in VS Code. Build with the `build` task (Ctrl+Shift+B). Run the processor and the tests with the "Run Data Processor" and "Run Tests" launch configs. These need the .NET 10 SDK on the host because the SDK has no container.
2. In `05 Testing Data Models/02 Run Demonstration Algorithms.html`, add an alternative to the Visual Studio steps that uses LEAN's dev container:
   - Install Docker, VS Code, and the Dev Containers extension.
   - In `Lean/.devcontainer/devcontainer.json`, add `mounts` for the data folder and the data source repository, for example `"source=C:/Users/<you>/Lean/Data,target=/Data,type=bind,consistency=cached"`. Rebuild the container after any mount change.
   - Set `"data-folder": "/Data/"` in `Launcher/config.json`.
   - Run **Dev Containers: Rebuild and Reopen in Container**. The command was "Remote-Containers" in 2023; check the current name.
   - Reference the data source DLL and run the demo algorithm with F5 from Run and Debug.
   - Link `Lean/.vscode/readme.md` instead of copying its setup steps.
3. If QuantConnect wants a container for the SDK too, that's an SDK repository change first (add `.devcontainer`), then docs. Ask the data team before you document step 2 of the old commit.

Before you write, verify the steps end to end on a fresh clone. The 2023 text was never tested against the redesign.

## Style

Follow `.claude/skills/docs-style/SKILL.md` and run its linter on the folder. The 2023 text needs rewording: "Follow these set up", "either" lists, quoted menu names instead of `<span class="menu-name">`, Markdown backticks inside HTML, and a dead `<a href='/docs/v2'>` link.
