
        // jQuery version of copy URL function
        $('#copyButton').click(function() {
            const url = $('#urlInput').val();
            
            // Use the Clipboard API to copy the URL
            navigator.clipboard.writeText(url).then(function() {
                // Display the copied URL
                $('#urlDisplay').text('Copied URL: ' + url);
            }).catch(function(err) {
                // In case of error, display a fallback message
                $('#urlDisplay').text('Failed to copy URL');
            });
        });
