<?php

return [
    "apiOperation"          => "CREATE_CHECKOUT_SESSION",
    "currency"              => env("BANKMISR_CURRENCY", "EGP"),
    "ApiUrl"                => "https://banquemisr.gateway.mastercard.com/api/rest/version/43/",

    "MeezaJSSandBoxUrl"     => "https://upgstaging.egyptianbanks.com:3006/js/Lightbox.js",
    "MeezaJSLiveBoxUrl"     => "https://upg.egyptianbanks.com:2008/INVCHOST/js/Lightbox.js",

    "checkOutSandBoxUrl"    => "https://banquemisr.test.gateway.mastercard.com/checkout/version/43/checkout.js",
    "checkOutLiveUrl"       => "https://banquemisr.gateway.mastercard.com/checkout/version/43/checkout.js",
];
