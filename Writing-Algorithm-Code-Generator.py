import os
import pathlib
from urllib.request import urlopen

source = "http://cdn.quantconnect.com.s3.us-east-1.amazonaws.com/terminal/cache/api/csharp_tree.json"

base = "02 Writing Algorithms/04 API Reference/"
dir_ = ["Adding Data", "Algorithm Framework", "Charting", "Consolidating Data",
       "Handling Data", "Historical Data", "Indicators", "Live Trading", "Logging",
       "MachineLearning", "Modeling", "Parameter and Optimization", "Scheduled Events",
       "Securities and Portfolio", "Trading and Orders", "Universes"]

path_ = pathlib.Path(base)
path_.mkdir(parents=True, exist_ok=True)

with open(path_ / "01 All Available Methods.html", "w", encoding="utf-8") as html_file:
    html_file.write('''<style>

  td {
    vertical-align:text-top;
    padding: 0 0 1rem 0;
  }

  .tablinks {
    font-size: 14px;
    border: 1px solid #D9E1EB;
    border-radius: 2px;
    background-color: #FBFCFD;
    margin: 0.2rem 0;
    padding: 5px 10px;
    font-weight: 600;
  }

  .api-ref-tag-list {
    margin: 0.5rem 0rem;
    display: flex;
  }
  
  .ref-table-container {
    position: relative;
    border: 1px solid #D9E1EB;
    border-radius: 4px;
    padding: 1.2rem;
    margin: 2rem 0;
    height: 420px;
    overflow-x: hidden;
    display: none;
  }

  .ref-tag-active {
    color: #fff;
    border: 1px solid #8F9CA3;
    background-color: #8F9CA3;
  }

</style>
                    
<script>
function openTab(evt, category) {
  var i, tabcontent, tablinks;
  
  tabcontent = document.getElementsByClassName("ref-table-container");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  tablinks = document.getElementsByClassName("tablinks ref-tag-active");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" ref-tag-active", "");
  }

  document.getElementById(category).style.display = "block";
  evt.currentTarget.className += " ref-tag-active";
}

document.getElementById("All_button").click()
</script>

<h3><code>QCAlgorithm</code> class subclasses/methods</h3><hr class="solid">

<div class="api-ref-tag-list">

  <div style="margin-right: 0.8rem;">
    <button id="All_button" class="tablinks ref-tag-active" onclick="openTab(event, 'All')">All</button>
  </div>
  
  <div>''')
    
    for topic in dir_:
        html_file.write(f'''    <button id="{topic}_button" class="tablinks" onclick="openTab(event, '{topic}')">{topic}</button>\n''')
    
    html_file.write('''  </div>
                    
</div>

<div id="All" class="ref-table-container" style="display: block;">
<table cellspacing="0" cellpadding="0">
<tbody>
</tbody></table>
</div>''')

    for topic in dir_:    
        html_file.write( f'''<div id="{topic}" class="ref-table-container">
<table cellspacing="0" cellpadding="0">
<tbody>
</tbody></table>
</div>''')
        
with open(path_ / "02 Public Members.html", "w", encoding="utf-8") as html_file:
    html_file.write("""<style>

    .method-container {
        border: 1px solid #D9E1EB;
        border-top: 0;
        border-radius: 4px;
        margin-top: 2rem;
    }

    .method-container > div {
        padding-left: 1.5rem;
        padding-right: 1rem;
        margin-bottom: 2rem;
    }

    .method-details > div {
        margin-bottom: 2rem;
        display: block;
    }

    .method-header {
        background: #FBFCFD;
        border-bottom: 1px solid #D9E1EB;
        border-top: 1px solid #D9E1EB;
        padding: 1.5rem;
    }

    .method-header > pre {
        white-space: pre-line;
    }

    .method-header:first-child {
        border-radius: 4px 4px 0px 0px;
    }

    .method-tag {
        border: 1px solid #D9E1EB;
        border-radius: 2px;
        font-size: 12px;
        color: #8F9CA3;
        background-color: transparent;
        text-transform: uppercase;
    }

    .method-order {
        color: #8F9CA3;
        font-size: 14px;
    }

    .parameter-table{
        margin: 2rem 0 2rem -0.25rem;
    }

    .parameter-table th {
        padding-bottom: 1rem;
        text-align: left;
    }

    .parameter-table td {
        padding: 1rem 3rem 0 0;
        vertical-align: top;
    }

    .method-definition {
        margin-top: 3rem;
    }
    
    .show-hide-detail {
        background: none;
        border: none;
        padding: 0;
        color: #069;
        cursor: pointer;
    }

</style>

<script>
function ShowHide(event, idName) {
    var x = document.getElementById(idName);
    if (x.style.display == "none") {
        x.style.display = "block";
        event.target.innerHTML = "Hide Details <span><img src='https://cdn.quantconnect.com/i/tu/api-chevron-hide.svg' alt='arrow-hide'></span>";
    }
    else {
        x.style.display = "none";
        event.target.innerHTML = "Show Details";
    }
};

function openTopTab(event, category) {
    document.getElementById(category + "_button").scrollIntoView();
    document.getElementById(category + "_button").click();
}
</script>

<hr>""")
    
def Table(input_, previous_name, type_map, j):
    if "DocumentationAttributes" not in input_ or not "DocumentationAttributes":
        if "concentrate" in input_:
            for item in input_["concentrate"]:
                previous_name, j = Table(item, previous_name, type_map, j)
                
        elif "children" in input_:
            for item in input_["children"]:
                previous_name, j = Table(item, previous_name, type_map, j)
                
        return previous_name, j
    
    doc_attr = [x["tag"] for x in input_["DocumentationAttributes"]]
    name = input_["Name"] if "Name" in input_ else input_["ShortType"]
    
    for count, tag in enumerate(doc_attr):
        doc_ref = (input_["DocumentationAttributes"][count]["line"], input_["DocumentationAttributes"][count]["fileName"])
        args = {}
            
        if "Parameters" in input_:
            params = input_["Parameters"]
            for item in params:
                if "GenericParameters" not in item:
                    args[item["Name"]] = type_map[str(item["typeId"])]
                    
                else:
                    args[item["GenericParameters"][-1]["Name"]] = type_map[str(item["GenericParameters"][-1]["typeId"])]
            
        call = name + "(" + ", ".join([str(value) + " " + str(key) for key, value in args.items()]).replace("/", "_") + ")"
        
        if previous_name != name:
            with open(path_ / f'02 Public Members.html', "r", encoding="utf-8") as fin:
                lines = fin.readlines()
            
            with open(path_ / f'02 Public Members.html', "w", encoding="utf-8") as html_file:
                k = 1
                
                for line in lines:
                    if '<span class="method-order">0/0</span>' in line:
                        line = line.replace(">0/0<", f">{k}/{j}<")
                    
                        k += 1
                        
                    html_file.write(line)
                
                write_up, description = Box(input_, doc_attr, doc_ref, type_map, j)
                html_file.write(write_up)
        
            j = 1
            
        else:
            with open(path_ / f'02 Public Members.html', "rb+") as html_file:
                html_file.seek(-10, os.SEEK_END)
                html_file.truncate()
            
            with open(path_ / f'02 Public Members.html', "a", encoding="utf-8") as html_file:
                write_up, description = Box(input_, doc_attr, doc_ref, type_map, j)
                write_up_lines = write_up.split('<div class="method-container">')
                for line in write_up_lines[1:]:
                    html_file.write(line)
                
            j += 1
            
        if name != previous_name: 
            with open(path_ / f'01 All Available Methods.html', "r", encoding="utf-8") as fin:
                lines = fin.readlines()
                    
            with open(path_ / f'01 All Available Methods.html', "w", encoding="utf-8") as html_file:
                active = False
                
                for line in lines:
                    if '<div id="All" class="ref-table-container"' in line or f'<div id="{tag}" class="ref-table-container"' in line:
                        active = True
                    
                    if active and '</tbody></table>' in line:
                        link = line.replace('</tbody></table>', f'''<tr>
<td><a href="#{call.replace(" ", "-") + str(j)}">{name}()</a></td>
<td>{description}</td>
</tr>
</tbody></table>''')
                        html_file.write(link)
                        
                        active = False
                        
                    else:
                        html_file.write(line)

    return name, j


def Box(input_, doc_attr, doc_ref, type_map, j):
    args = {}
        
    if "Parameters" in input_:
        params = input_["Parameters"]
        for item in params:
            if "GenericParameters" in item:
                item = item["GenericParameters"][-1]
                
            args[item["Name"]] = {"Description": "/", "Type": "/"}
            
            if "Description" in item:
                args[item["Name"]]["Description"] = item["Description"]
                
                if args[item["Name"]]["Description"][-1] != ".":
                    args[item["Name"]]["Description"] = args[item["Name"]]["Description"] + "."
                
            if "EnumValues" in item:
                args[item["Name"]]["Description"] = args[item["Name"]]["Description"] + '<br/><i>\n' + f'Options: {item["EnumValues"]}</i>'

            if "ShortType" in item:
                args[item["Name"]]["Type"] = item["ShortType"]
                
            elif "Type" in item:
                args[item["Name"]]["Type"] = item["Type"]
                
            else:
                args[item["Name"]]["Type"] = type_map[str(item["typeId"])]
        
    call = input_["Name"] + "(" + ", ".join([str(value["Type"]) + " " + str(key) for key, value in args.items()]).replace("/", "_") + ")"
    
    params = ""
    if args:
        params += """        <div class="parameter-list">
            <table class="parameter-table">
                <th><strong>Parameters</strong></th>"""

        for name, prop in args.items():
            description = prop["Description"]
            
            start = description.find("<")
            while start != -1:
                end = description.find(">", start) + 1
                substring = description[start:end]
                new_substring = ""
                start2 = substring.find('"')
                
                if start2 != -1:
                    new_substring = substring[start2:substring.find('"', start2 + 1)]
                    new_substring = '<code>' + new_substring.split('(')[0].split(".")[-1].split('"')[0] + '</code>'
                
                if "seealso" in substring:
                    new_substring = "\nSee also: " + new_substring + ".\n"
                
                description = description.replace(substring, new_substring)
                start = description.find("<", end)
            
            description = description.replace("</value>", "").replace("``1", "&lt;T&gt;")
            params += f'''                <tr>
                    <td><code>{prop["Type"]}</code></td>
                    <td>{name}</td>
                    <td>{description}</td>
                </tr>'''
            
        params += """            </table>
        </div>"""
        
    else:
        params += "<p>This method requires no argument input.</p>"
    
    ret = """        <div class="method-return">
            <h4>Return</h4>\n"""
    
    if "ReturnValue" in input_:
        if "Name" in input_["ReturnValue"]:
            ret_ = input_["ReturnValue"]["Name"]
            
        elif "ShortType" in input_["ReturnValue"]:
            ret_ = input_["ReturnValue"]["ShortType"]\
            
        elif "Type" in input_["ReturnValue"]:
            ret_ = input_["ReturnValue"]["Type"].split(".")[-1]
            
        else:
            ret_ = type_map[str(input_["ReturnValue"]["typeId"])]
            
        if ret_ == "Void":
            ret += f"            <p>{ret_} - This method provides no return.</p>\n"
        
        else:
            ret += f'            <p>{ret_}'
                
            if "Description" in input_["ReturnValue"]:
                ret += f' - {input_["ReturnValue"]["Description"]}</p>\n'
                
            else:
                ret += '</p>\n'
            
    else:
        ret += "            <p>This method provides no return.</p>\n"
        
    ret += "        </div>"
        
    if "Description" in input_:
        slash = r"\'"
        description = input_["Description"].replace(f"{slash}", "")
        
        if ret_ == "Security":
            description = "The new Security"
        
        start = description.find("<")
        while start != -1:
            end = description.find(">", start) + 1
            substring = description[start:end]
            new_substring = ""
            start2 = substring.find('"')
            
            if start2 != -1:
                new_substring = substring[start2:substring.find('"', start2 + 1)]
                new_substring = '<code>' + new_substring.split('(')[0].split(".")[-1].split('"')[0] + '</code>'
            
            description = description.replace(substring, new_substring)
            start = description.find("<", end)
    
        description = description.replace("</value>", "")
        
    else: 
        description = ""
    
    this_ = " (\n&emsp;"
    head_ = '<font color="#cdcdcd">' + ret_ + "</font> QuantConnect.Algorithm.QCAlgorithm." + input_["Name"] + this_
    next_ = ",\n" + "&emsp;"
    
    max_ = 0
    for value in args.values():
        type_ = str(value["Type"])
        
        if len(type_) > max_:
            max_ = len(type_)
        
    call_ = head_ + \
        next_.join(["<code>" + str(value["Type"]) + "</code>" + " " * (max_ + 2 - len(str(value["Type"]))) + str(key) for key, value in args.items()]) + \
        "\n" + ")"
    call_ = call_.replace("\n", "\n" + " " * 3)
        
    buttons = "\n".join([f'''<button class="method-tag" onclick="openTopTab(event, '{attr_}')">{attr_}</button>''' for attr_ in doc_attr])
    
    write_up = f"""<a id="{call.replace(" ", "-") + str(j)}"></a>
<div class="method-container">

    <div class="method-header">
        {buttons}
        <h3>{input_["Name"]}()<span class="method-order">0/0</span></h3>
        <pre>
            {call_}
        </pre>
    </div>
    
    <div class="method-description">
        <p>{description}</p>
    </div>
    
    <div class="details-btn">
        <button class="show-hide-detail" onclick="ShowHide(event, '{call.replace(" ", "-")}-details')">Hide Details <span><img src='https://cdn.quantconnect.com/i/tu/api-chevron-hide.svg' alt='arrow-hide'></span></button>
    </div>

    <div class="method-details" id="{call.replace(" ", "-")}-details">
    
{params}

{ret}

        <div class="method-def">
            <p>Definition at <a href="https://github.com/QuantConnect/Lean/blob/master/{doc_ref[1]}#L{doc_ref[0]}">line {doc_ref[0]}</a> of file  <a href="https://github.com/QuantConnect/Lean/blob/master/{doc_ref[1]}">{doc_ref[1]}.</a></p>
        </div>
        
    </div>

</div>

"""

    return write_up, description


json_file = urlopen(source).read().decode("utf-8")
json_file = json_file.replace("true", "True").replace("false", "False").replace("null", "None")
doc = eval(json_file)

keys = doc["keys"]

type_map = {}
for key in keys.items():
    if "GenericParameters" in key[1]:
        type_map[key[0]] = key[1]["Type"].split(".")[-1][:-1]
    else:
        type_map[key[0]] = key[1]["ShortType"]

algo_methods = [doc["tree"]["core"]["data"][0]["children"], keys.values()]
    
for branch in algo_methods:
    previous_name = ""
    j = 1
    
    for item in branch:
        previous_name, j = Table(item, previous_name, type_map, j)