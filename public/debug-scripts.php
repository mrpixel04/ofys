<?php
/**
 * Debug script to check for duplicate script loading
 */

header('Content-Type: text/html');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Script Debug</title>
</head>
<body>
    <h1>Script Loading Debug</h1>

    <div id="output"></div>

    <script>
    // Create a function to detect script tags
    function findScripts() {
        const scripts = document.getElementsByTagName('script');
        const scriptSources = {};
        let output = '<h2>Detected Scripts:</h2><ul>';

        for (let i = 0; i < scripts.length; i++) {
            const src = scripts[i].src;
            if (src) {
                if (!scriptSources[src]) {
                    scriptSources[src] = 1;
                } else {
                    scriptSources[src]++;
                }
            }
        }

        // List all scripts and highlight duplicates
        for (const src in scriptSources) {
            const count = scriptSources[src];
            const isDuplicate = count > 1;
            output += `<li style="${isDuplicate ? 'color:red;font-weight:bold' : ''}">
                ${src} - Loaded ${count} time${count > 1 ? 's' : ''}
            </li>`;
        }

        output += '</ul>';
        document.getElementById('output').innerHTML = output;
    }

    // Run after page loads
    window.addEventListener('load', findScripts);
    </script>
</body>
</html>
