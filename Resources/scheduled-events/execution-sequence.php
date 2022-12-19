<?php
$getExecutionText = function($linkScheduledEvents) {
    $result = "<p>The algorithm manager calls events in the following order:</p>
<ol>";
  
    if ($linkScheduledEvents)
    {
        $result .= "
<li><a href='/docs/v2/writing-algorithms/scheduled-events'>Scheduled Events</a></li>
<li>Consolidation event handlers</li>";
    }
    else
    {
        $result .= "
<li>Scheduled Events</li>
<li><a href='/docs/v2/writing-algorithms/consolidating-data/getting-started#04-Receive-Consolidated-Bars'>Consolidation event handlers</a></li>";
    }
  
    $result .= "
    <li><code>OnData</code> event handler</li>
</ol>

<p>This event flow is important to note. For instance, if your consolidation handlers or <code>OnData</code> event handler appends data to a <code>RollingWindow</code> and you use that <code>RollingWindow</code> in your Scheduled Event, when the Scheduled Event executes, the <code>RollingWindow</code> won't contain the most recent data.</p>"; 
    
  
    echo $result;
}
?>
