<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="<?php echo URL_WEBROOT ?>css/relPdf/bootstrap_relPdf.css" />
        <script>
            function subst() {
                var vars = {};
                var query_strings_from_url = document.location.search.substring(1).split('&');
                for (var query_string in query_strings_from_url) {
                    if (query_strings_from_url.hasOwnProperty(query_string)) {
                        var temp_var = query_strings_from_url[query_string].split('=', 2);
                        vars[temp_var[0]] = decodeURI(temp_var[1]);
                    }
                }
                var css_selector_classes = ['page', 'topage'];
                //      var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
                for (var css_class in css_selector_classes) {
                    if (css_selector_classes.hasOwnProperty(css_class)) {
                        var element = document.getElementsByClassName(css_selector_classes[css_class]);
                        for (var j = 0; j < element.length; ++j) {
                            element[j].textContent = vars[css_selector_classes[css_class]];
                        }
                    }
                }
            }
        </script>
        <style>
            body {
                border-top: 1px solid darkred;
                font-size: 12px;
            }
        </style>
    </head>
    <body onload="subst()">
        <div id="footer" class="footer" >
            <?php if ($response->get("rodape")) { ?>
                <?php echo $response->get('rodape'); ?>
            <?php } else { ?>
                <div style="float: left;"><?php echo date("d/m/Y H:i:s") ?></div>
                <div style="float: right;">Pág.: <span class="page"></span>/<span class="topage"></span></div>
            <?php } ?>
        </div>
    </body>
</html>