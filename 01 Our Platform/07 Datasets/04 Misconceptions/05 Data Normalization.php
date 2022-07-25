<p>The data normalization mode defines how historical data is adjusted to accommodate for splits, dividends, and continuous Future contract roll overs.  When you compare the data in the Dataset Market to data that's hosted on other platforms, the data may have different values because a different data normalization mode is being used to adjust the data. Ensure datasets are using the same normalization mode before reporting data issues. The most common way to recognize this bug is by comparing the two price series and seeing them significantly deviate in the past. The following data normalization modes are available:</p>

<div data-tree='QuantConnect.DataNormalizationMode'></div>

<?php 
include(DOCS_RESOURCES."/datasets/data-normalization.php"); 
$getDataNormalizationAdjustmentText(true);
?>
