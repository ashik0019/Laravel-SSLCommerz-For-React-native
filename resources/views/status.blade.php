<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <title></title>
</head>
<body>
@if($status=="success")
    <p>Transaction successful. Returning to App...</p>
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            if (window && window.ReactNativeWebView && window.ReactNativeWebView.postMessage) {
                window.ReactNativeWebView.postMessage("success")
            } else {
               return 'web request'
            }
        }, false)
    </script>
@elseif($status=="fail")
    <p>Transaction Failed. Returning to App...</p>
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            if (window && window.ReactNativeWebView && window.ReactNativeWebView.postMessage) {
                window.ReactNativeWebView.postMessage("fail")
            } else {
                return 'web request'
            }
        }, false)
    </script>
@elseif($status=="cancel")
    <p>Transaction Canceled. Returning to App...</p>
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            if (window && window.ReactNativeWebView && window.ReactNativeWebView.postMessage) {
                window.ReactNativeWebView.postMessage("cancel")
            } else {
                return 'web request'
            }
        }, false)
    </script>
@endif
</body>
</html>
