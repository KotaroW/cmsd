<?php
if (!defined('PLEASE_GIMME_THE_CONFIG')) exit;

    $_config_data =<<<KOTAROW

    {
        "title" : {
            "index" : "A Small Test"
        },
        "icon" : "icon.ico",
        "meta" : {
            "index" : {
                "author" : "KotaroW",
                "keyword" : "this is a keyword",
                "description" : "this is description"
            }
        },
        "css" : {
            "index" : [
                "css/style1.css",
                "css/style2.css"
            ]
        },
        "js" : {
            "index" : [
                "js/js1.js",
                "js/js2.js"
            ]
        },
        "content" : {
            "index" : "contents/index.php"
        },
        "footer" : "contents/footer.php"
    }

KOTAROW;

?>