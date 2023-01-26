<p>
    The following table describes errors you may see when using the CLI:
</p>

<table class="table qc-table">
    <thead>
        <tr>
            <th>Error Message</th>
            <th>Possible Cause and Fix</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td nowrap="">
                <div class="error-messages">No such command '&lt;name&gt;'</div><br>
                <div class="error-messages">No such option: &lt;option&gt;</div>
            </td>
            <td>
                The command you tried to run does not exist or it doesn't support the option you provided.
                If the documentation says it is available you are probably using an outdated version of the CLI.
                Run <code>pip install --upgrade lean</code> to update to the latest version.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">Invalid credentials, please log in using `lean login`</div>
            </td>
            <td>
                You are trying to use a command which communicates with the QuantConnect API and you haven't authenticated yourself yet.
                Run <code>lean login</code> to log in with your API credentials.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">Please make sure Docker is installed and running</div>
            </td>
            <td>
                You are trying to use a command which needs to run the LEAN engine locally, which always happens in a Docker container.
                Make sure Docker is running if you installed it already, or visit <a href="/docs/v2/lean-cli/installation/installing-docker">Installing Docker</a> if you haven't.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">This command requires a Lean configuration file, run `lean init` in an empty directory to create one, or specify the file to use with --lean-config</div>
            </td>
            <td>
                The command you are trying to run requires a <a href="/docs/v2/lean-cli/initialization/configuration#03-Lean-Configuration">Lean configuration</a> file.
                The CLI automatically tries to find this file by recursively looking in the current directory and all of the parent directories for a <span class="public-file-name">lean.json</span> file.
                This error is shown if no such file can be found.
                It can be fixed by running the command in your <a href='/docs/v2/lean-cli/initialization/workspace'>workspace directory</a> (which generates the <span class="public-file-name">lean.json</span> file), or by specifying the path to the <span class="public-file-name">lean.json</span> file with the <code>--lean-config</code> option.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">Invalid value for 'PROJECT': Path '&lt;path&gt;' does not exist.</div>
            </td>
            <td>
                You are trying to run an action on a project but specified an invalid project path.
                Make sure you are running the command from your <a href='/docs/v2/lean-cli/initialization/workspace'>workspace directory</a> and make sure <code>./&lt;path&gt;</code> points to an existing directory.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">'&lt;path&gt;' is not a valid path</div>
            </td>
            <td>
                You provided a path that is not valid for your operating system.
                This error is most likely to appear on Windows, where the following characters are not allowed in path components: <code>&lt;</code>, <code>&gt;</code>, <code>:</code>, <code>"</code>, <code>|</code>, <code>?</code>, and <code>*</code>.
                On top of those characters the following names are not allowed (case-insensitive): <code>CON</code>, <code>PRN</code>, <code>AUX</code>, <code>NUL</code>, <code>COM1</code> until <code>COM9</code>, and <code>LPT1</code> until <code>LPT9</code>.
                Last but not least, path components cannot start or end with a space or end with a period on Windows.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">invalid mount config for type "bind": bind source path does not exist: <span class='public-directory-name'>/ var / folders / &lt;path&gt; / config.json</span></div>
                <br>
                <div class="error-messages">Mounts denied: The path  <span class='public-directory-name'>/ Users / &lt;path&gt; / data</span> is not shared from the host and is not known to Docker</div>
            </td>
            <td>
                Your Mac's Docker file sharing settings do not permit binding one or more directories that we need to share with the container.
                Go to Docker's <span class="menu-name">Settings &gt; Resources &gt; File Sharing</span> and add <span class="public-directory-name">/ private / var / folders</span> and either <span class="public-directory-name">/ Users</span>
                to share your entire <span class="public-directory-name">/ Users</span> directory, or <span class="public-file-name">/ Users / &lt;path&gt;</span> where <span class="public-file-name">&lt;path&gt;</span> is the path to your QuantConnect directory, which should have
                a <span class="public-directory-name">data</span> child directory, and child directories for your individual projects.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">Docker wants access to &lt;path&gt;</div>
            </td>
            <td>
                You are running Docker on Windows using the legacy Hyper-V backend and haven't configured file sharing correctly.
                You need to enable file sharing for your temporary directories and for your <a href='/docs/v2/lean-cli/initialization/workspace'>workspace directory</a>.
                To do so, open your Docker settings, go to <span class="menu-name">Resources &gt; File Sharing</span> and add <span class="public-file-name">C: / Users / &lt;username&gt; / AppData / Local / Temp</span> and your workspace directory to the list.
                Click <span class="button-name">Apply &amp; Restart</span> after making the required changes.
            </td>
        </tr>
    </tbody>
</table>
