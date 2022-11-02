<?php
$getSupportedLanguagesText = function($isDesktopDocs)
{
    $fileType = $isDesktopDocs ? "private" : "public";
    echo "
<p>The Lean engine supports C# and Python. The engine is written in C#, so it is the native language. However, Python is supported using Python.NET. Comparing the languages, C# is faster than Python and it's easier to contribute to Lean if you have features written in C# modules. In contrast, Python is less verbose, has more third-party libraries, and is more popular among the QuantConnect community than C#. Python is also the native language for the research notebooks, so it's easier to use in the Research Environment.</p>

<p>The programming language that you have set on your account determines how autocomplete and IntelliSense are verified and determines the types of files that are included in your new projects. If you have Python set as your programming language, new projects will have <span class='{$fileType}-file-name'>.py</span> files. If you have C# set as your programming language, new projects will have <span class='{$fileType}-file-name'>.cs</span> files.</p>
    ";
}
?>
