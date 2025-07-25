<!-- Code generated by indicator_reference_code_generator.py -->
<? 
$hasReference = false;
$hasAutomaticIndicatorHelper = true;
$helperPrefix = '';
$typeName = 'AbsolutePriceOscillator';
$helperName = 'APO';
$pyHelperName = 'apo';
$helperArguments = 'symbol, 10, 20, MovingAverageType.Simple';
$properties = array("Fast","Slow","Signal","Histogram");
$pyProperties = array("fast","slow","signal","histogram");
$otherProperties = array();
$otherPyProperties = array();
$updateParameterType = 'time/number pair or an <code>IndicatorDataPoint</code>';
$constructorArguments = '10, 20, MovingAverageType.Simple';
$updateParameterValue = 'bar.EndTime, bar.Close';
$hasMovingAverageTypeParameter = False;
$constructorBox = 'absolute-price-oscillator';
$isOptionIndicator = false;
include(DOCS_RESOURCES."/indicators/using-indicator.php");
?>