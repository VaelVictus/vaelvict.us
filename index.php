<? 
    require_once('inc/helpers.php');

    $abel   = get_age('2011-01-03');
    $violet = get_age('2021-01-05');
    $olivia = get_age('2022-11-09');
    $everett = get_age('2025-05-14');
?>
<!DOCTYPE html>
<html lang="en">
  <head>

<? if (DEV_ENV == 'prod') { ?>
    <? $manifest = json_decode(file_get_contents('./dist/manifest.json'), true); ?>
    <? foreach ($manifest['index.html']['css'] as $path) { ?>
        <link rel="stylesheet" href="dist/<?=$path?>">
    <? } ?>

    <script type="module" crossorigin src="dist/<?=$manifest['index.html']['file']?>"></script>
<? } else { ?>
    <link rel="stylesheet" href="<?= VITE_ORIGIN ?>/src/style.css">
    <script type="module" src="<?= VITE_ORIGIN ?>/main.js"></script>
<? } ?>

    <title>Vael Victus</title>

    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Vael Victus">
    <meta name="description" content="Vael Victus is a web-based game designer and application developer.">
    <meta name="keywords" content="vael victus, tinydark, victus, bean grower, monbre, black crown exhumed">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Vael Victus">

    <meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Vael Victus - Web Game Developer" />
	<meta property="og:description" content="Vael Victus is a web-based game designer and application developer." />
	<meta property="og:url" content="https://vaelvict.us" />
	<meta property="og:site_name" content="Vael Victus" />

	<meta name="twitter:card" content="summary"/>
	<meta name="twitter:site" content="@vaelvictus"/>
	<meta name="twitter:domain" content="Vael Victus"/>
	<meta name="twitter:creator" content="@vaelvictus"/>

	<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
	<link rel="manifest" href="site.webmanifest">
	<link rel="mask-icon" href="safari-pinned-tab.svg" color="#000000">
	<meta name="msapplication-TileColor" content="#000000">
	<meta name="theme-color" content="#000000">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  </head>

  <body>
    <main class="text-base overflow-auto bg-cover w-full h-full">
        <div id='vv' class="w-full pb-3 sm:w-9/12 max-w-4xl text-center mx-auto">
            <div id='vael_victus'>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 179 46" version="1.1" role="img" aria-label="Vael Victus" class="vael_victus_svg" preserveAspectRatio="xMidYMid meet">
                <defs>
                    <mask id="signature_reveal_mask" maskUnits="userSpaceOnUse" x="0.0" y="0.0" width="179.0" height="46.0">
                        <rect x="0.0" y="0.0" width="179.0" height="46.0" fill="black" /><path d="m 9.3544333,18.307962 2.8063297,-4.944486 3.608139,0.133635 2.000211,25.513058 9.626014,-15.223181 2.138156,-11.358955 14.715265,8.560836 -8.434432,2.129945 -5.078121,10.156241 1.358653,5.735114 7.4676,-7.2009 1.6383,-8.382 -1.377389,14.124098 4.996889,-3.722798 5.333945,-1.6383 7.977129,-6.933299 -1.336347,-4.409947 -5.34539,3.340869 -3.073601,10.42351 2.806909,4.398767 6.280255,-4.933305 17.227397,-27.9088948 -6.670252,2.2510208 -3.207234,8.68626 -1.603616,12.561667 -1.891998,8.657452 4.965597,-1.975713 0.558903,-3.548787 15.076365,-14.759176 4.409946,-6.147199 2.53906,4.009043 1.177452,23.107632 7.107904,-10.011426 4.944488,-10.824415 -0.93544,-5.345391 10.18087,0.235132 -3.2766,4.8768 -3.7719,8.343899 4.88571,-5.036841 -3.01881,17.762242 5.02333,-4.666036 13.798,-13.431464 -4.44356,1.270701 -3.34087,2.939965 -2.13816,6.414469 1.99779,7.472365 5.6388,-6.096 12.27499,-17.011632 -4.40995,19.911579 1.05031,3.196053 3.9624,-4.6863 -7.95267,-12.541403 9.48807,-0.267269 2.84602,5.036272 5.3721,-5.5245 -3.22482,17.085507 7.98732,-6.112707 3.85736,-10.618207 c -1.23913,9.446323 -7.34952,24.647756 0.94324,11.799306" fill="none" stroke="white" stroke-width="9" stroke-linecap="round" stroke-linejoin="round" pathLength="1" style="stroke-dasharray: 1; stroke-dashoffset: 1;">
                        <animate attributeName="stroke-dashoffset" from="1" to="0" dur="1.9s" begin="0s" fill="freeze" calcMode="spline" keySplines="0.2 0 0.2 1" keyTimes="0;1" /></path>
                        <rect x="150" y="10" width="29" height="36" fill="black" opacity="1"><animate attributeName="opacity" from="1" to="0" begin="1.39s" dur="0.01s" fill="freeze" /></rect><path d="m 168.41591,23.732069 -0.60406,-2.818229 -3.80859,-0.06682 -2.83974,3.073599 -0.10022,3.441096 3.87541,4.476764 0.7684,1.737251 -0.90204,3.173828 -3.90882,1.603616 -2.86499,-1.769842 0.7812,-1.885952" fill="none" stroke="white" stroke-width="9" stroke-linecap="round" stroke-linejoin="round" pathLength="1" style="stroke-dasharray: 1; stroke-dashoffset: 1;">
                        <animate attributeName="stroke-dashoffset" from="1" to="0" dur="0.5s" begin="1.5s" fill="freeze" calcMode="spline" keySplines="0.2 0 0.2 1" keyTimes="0;1" /></path>
                    </mask>
                </defs>
                <g mask="url(#signature_reveal_mask)">
                    <g aria-label="Vael Victus" style="font-size:38.1px;line-height:1.25;stroke-width:0.264583;fill:currentColor;" transform="translate(-12.700002,1.5875)">
                        <path d="m 30.469115,37.422668 q -0.2667,0 -0.381,-0.1905 -0.0762,-0.1905 -0.1524,-0.8382 -0.381,-7.1247 -0.9525,-12.3825 -0.5715,-5.295899 -1.6383,-8.648699 -0.2667,-0.9906 -0.6096,-1.4478 -0.3429,-0.4572 -0.9906,-0.4572 -1.6764,0 -2.7813,3.2766 -0.2667,0.8001 -0.5715,0.8001 -0.2667,0 -0.2667,-0.6477 0,-1.4859 0.6858,-3.048 0.7239,-1.5621 1.905,-2.5908 1.1811,-1.0287 2.5527,-1.0287 0.8382,0 1.6002,0.7239 0.762,0.6858 1.4097,2.8575 0.8001,2.667 1.4859,8.1534 0.7239,5.448299 0.9906,10.972799 7.200899,-11.391899 7.200899,-16.954499 0,-0.9525 -0.2286,-1.4478 -0.1905,-0.4953 -0.6858,-1.0668 -0.1143,-0.1143 0.4191,-0.9525 0.5334,-0.8382 1.2192,-1.5621 0.7239,-0.7239 1.143,-0.7239 0.4572,0 0.9144,0.9525 0.4572,0.9525 0.4572,2.2479 0,1.7907 -0.9144,4.8387 -0.9144,3.0099 -2.7813,6.210299 l -5.562599,9.6393 q -0.0381,0.1143 -0.4953,0.8763 -0.4191,0.762 -0.762,1.2192 -0.381,0.4572 -1.0287,0.8382 -0.6477,0.381 -1.1811,0.381 z" />
                        <path d="m 44.794651,37.422668 q -1.9431,0 -1.9431,-3.6957 0,-3.5433 1.524,-6.9723 1.5621,-3.4671 4.191,-5.638799 2.6289,-2.2098 5.6769,-2.2098 1.5621,0 2.7051,0.4953 -0.4953,1.9431 -0.6858,2.8575 l -0.8001,4.114799 q -1.0668,4.8768 -1.2954,6.7437 -0.0381,0.2667 -0.0381,0.6477 0,0.8382 0.4953,0.8382 0.6096,0 1.143,-0.762 0.5334,-0.8001 1.2192,-2.2479 0.0381,-0.0381 0.1143,-0.2286 0.1143,-0.1905 0.2667,-0.1905 0.2286,0 0.2286,0.4572 l -0.0762,0.6096 q -0.2667,1.2573 -1.1049,2.4765 -0.8001,1.2192 -1.8288,1.9812 -0.9906,0.7239 -1.7907,0.7239 -1.3335,0 -1.3335,-2.1717 0,-0.8382 0.1905,-1.7145 l 0.6477,-3.3147 h -0.0381 q -1.8288,3.2004 -3.9243,5.2197 -2.0574,1.9812 -3.5433,1.9812 z m 1.7907,-3.1242 q 1.0668,0 2.4384,-1.6383 1.4097,-1.6764 2.5908,-4.0767 1.2192,-2.4003 1.6764,-4.3053 l 0.6096,-2.438399 q -1.143,-0.762 -2.4003,-0.762 -1.6383,0 -3.0099,1.905 -1.3335,1.866899 -2.0955,4.571999 -0.762,2.667 -0.762,4.8387 0,0.9525 0.1905,1.4478 0.2286,0.4572 0.762,0.4572 z" />
                        <path d="m 63.882695,37.422668 q -1.7145,0 -2.7432,-1.2954 -0.9906,-1.3335 -0.9906,-3.6576 0,-2.8194 1.3335,-6.0198 1.3716,-3.2385 3.5052,-5.372099 2.1336,-2.1717 4.3053,-2.1717 1.9812,0 1.9812,2.4003 0,1.943099 -1.143,3.809999 -1.143,1.8669 -3.0861,3.3147 -1.905,1.4097 -4.191,2.1717 0,2.0574 0.6477,2.9718 0.6858,0.9144 1.9812,0.9144 1.3716,0 2.5146,-0.8763 1.143,-0.8763 1.9431,-2.4003 0.1143,-0.2286 0.2286,-0.381 0.1143,-0.1524 0.3048,-0.1524 0.3048,0 0.3048,0.4572 0,1.0287 -1.0287,2.5527 -1.0287,1.524 -2.6289,2.6289 -1.6002,1.1049 -3.2385,1.1049 z m 0.1905,-8.8392 q 0.9906,0 2.0955,-0.6858 1.143,-0.7239 1.905,-1.9431 0.762,-1.2192 0.762,-2.7432 0,-1.790699 -1.2573,-1.790699 -1.0287,0 -1.9812,1.1049 -0.9144,1.104899 -1.5621,2.743199 -0.6096,1.6383 -0.8382,3.1623 0.2286,0.1524 0.8763,0.1524 z" />
                        <path d="m 75.084048,37.422668 q -0.7239,0 -1.0668,-0.6858 -0.3048,-0.7239 -0.3048,-1.7907 0,-0.7239 0.1524,-1.7145 l 2.2479,-15.011399 q 0.8001,-5.1816 1.943099,-8.001 1.143,-2.8193999 2.7432,-4.0766998 0.9144,-0.7239 1.905,-1.0668 0.9906,-0.3429 3.048,-0.8381999 0.9525,-0.1905 1.2192,-0.3048 0.2667,-0.1143 0.3429,-0.1143 0.2667,0 0.2667,0.3048 0,0.1524 -0.1905,0.4571999 -0.1524,0.3048 -0.5334,0.6477 -0.4191,0.381 -0.8001,0.5334 -0.381,0.1143 -0.9144,0.1524 -2.2098,0.2286 -3.2004,1.3715999 -1.8669,2.1335999 -2.7432,7.8866999 l -2.781299,17.945099 q -0.0381,0.2667 -0.0381,0.6477 0,0.8382 0.4953,0.8382 1.142999,0 2.666999,-3.3909 0.1524,-0.4191 0.4191,-0.4191 0.2667,0 0.2667,0.5334 0,1.2573 -0.9144,2.7051 -0.8763,1.4478 -2.095499,2.4384 -1.2192,0.9525 -2.1336,0.9525 z" />
                        <path d="m 102.74457,37.422668 q -0.2667,0 -0.381,-0.1905 -0.0762,-0.1905 -0.1524,-0.8382 -0.381,-7.1247 -0.9525,-12.3825 -0.5715,-5.295899 -1.638304,-8.648699 -0.2667,-0.9906 -0.609599,-1.4478 -0.3429,-0.4572 -0.9906,-0.4572 -1.6764,0 -2.7813,3.2766 -0.2667,0.8001 -0.5715,0.8001 -0.2667,0 -0.2667,-0.6477 0,-1.4859 0.6858,-3.048 0.7239,-1.5621 1.905,-2.5908 1.1811,-1.0287 2.552699,-1.0287 0.838204,0 1.600204,0.7239 0.762,0.6858 1.4097,2.8575 0.8001,2.667 1.4859,8.1534 0.7239,5.448299 0.9906,10.972799 7.2009,-11.391899 7.2009,-16.954499 0,-0.9525 -0.2286,-1.4478 -0.1905,-0.4953 -0.6858,-1.0668 -0.1143,-0.1143 0.4191,-0.9525 0.5334,-0.8382 1.2192,-1.5621 0.7239,-0.7239 1.143,-0.7239 0.4572,0 0.9144,0.9525 0.4572,0.9525 0.4572,2.2479 0,1.7907 -0.9144,4.8387 -0.9144,3.0099 -2.7813,6.210299 l -5.5626,9.6393 q -0.0381,0.1143 -0.4953,0.8763 -0.4191,0.762 -0.762,1.2192 -0.381,0.4572 -1.0287,0.8382 -0.6477,0.381 -1.1811,0.381 z" />
                        <path d="m 121.10869,16.734369 q -0.381,0 -0.3429,-0.381 l 0.4572,-2.667 q 0.1905,-1.1049 0.8001,-1.6764 0.6477,-0.6096 1.6002,-0.6096 h 0.1524 q 0.2286,0 0.2667,0.0762 0.0762,0.0762 0.0381,0.3048 l -0.4191,2.6289 q -0.1524,1.0668 -0.8001,1.7145 -0.6477,0.6096 -1.6002,0.6096 z m -2.2479,20.688299 q -1.2192,0 -1.2192,-1.7526 0,-0.8763 0.2286,-2.0193 l 1.8288,-10.1727 q 0.1524,-0.990599 0.1524,-1.219199 0,-0.5715 -0.3429,-0.5715 -0.4572,0 -1.1049,0.7239 -0.6477,0.723899 -1.4097,2.285999 -0.1524,0.4572 -0.381,0.4572 -0.2286,0 -0.2286,-0.381 0,-0.9144 0.8001,-2.324099 0.8382,-1.4478 2.0193,-2.4765 1.2192,-1.0668 2.2479,-1.0668 1.1811,0 1.1811,1.6764 0,0.8001 -0.2286,2.0955 l -1.9812,11.010899 -0.0762,0.4953 q 0,0.4191 0.3429,0.4191 0.4572,0 1.1049,-0.7239 0.6477,-0.762 1.4097,-2.286 0.1905,-0.4191 0.381,-0.4191 0.2286,0 0.2286,0.4953 0,0.8763 -0.8382,2.286 -0.8001,1.3716 -1.9812,2.4384 -1.1811,1.0287 -2.1336,1.0287 z" />
                        <path d="m 129.75732,37.422668 q -1.6383,0 -2.4384,-1.4478 -0.8001,-1.4859 -0.8001,-3.5052 0,-2.8956 1.3716,-6.096 1.4097,-3.2004 3.6195,-5.333999 2.2098,-2.1336 4.572,-2.1336 1.0287,0 1.6002,0.4191 0.6096,0.381 0.6096,1.0287 0,0.6096 -0.4572,1.4097 -0.2667,0.4572 -0.4953,0.4572 -0.1524,0 -0.2667,-0.1905 -0.8382,-1.1049 -2.0955,-1.1049 -1.524,0 -2.8575,1.2954 -1.2954,1.257299 -2.0574,3.390899 -0.762,2.1336 -0.762,4.6101 0,4.2672 2.3622,4.2672 1.2192,0 2.0955,-0.9144 0.8763,-0.9144 1.6383,-2.2479 0.0762,-0.1143 0.1905,-0.3048 0.1143,-0.1905 0.1905,-0.2667 0.1143,-0.0762 0.2667,-0.0762 0.1143,0 0.1905,0.1524 0.0762,0.1143 0.0762,0.3048 0,1.1049 -1.0287,2.6289 -1.0287,1.4859 -2.5908,2.5908 -1.524,1.0668 -2.9337,1.0668 z" />
                        <path d="m 144.31147,37.422668 q -1.143,0 -1.6002,-0.762 -0.4572,-0.8001 -0.4572,-2.1336 0,-0.9906 0.1524,-2.0955 0.1905,-1.143 0.2286,-1.3716 l 1.5621,-9.791699 h -3.8481 q -0.1905,0 -0.1905,-0.1905 0,-0.381 0.8382,-1.0668 0.8382,-0.7239 1.2192,-0.7239 h 2.286 l 0.381,-2.3622 q 0.1524,-1.2573 1.1811,-2.2479 1.0287,-0.9906 2.0574,-0.9906 0.1905,0 0.1905,0.1905 0,0.1524 -0.3429,0.9144 -0.3429,0.7239 -0.4953,1.5621 l -0.4572,2.9337 h 3.7338 q 0.2286,0 0.2286,0.2286 0,0.3048 -0.9144,1.0287 -0.8763,0.7239 -1.143,0.7239 h -2.1336 l -1.5621,9.715499 q -0.0381,0.2667 -0.2286,1.2954 -0.1524,1.0287 -0.1524,1.6002 0,1.2573 0.8382,1.2573 0.6096,0 1.2954,-0.5715 0.6858,-0.6096 1.2192,-1.6764 0.0381,-0.0762 0.0762,-0.1524 0.0762,-0.0762 0.1524,-0.0762 0.1905,0 0.1905,0.4953 0,0.762 -0.6858,1.7907 -0.6477,1.0287 -1.6764,1.7526 -0.9906,0.7239 -1.9431,0.7239 z" />
                        <path d="m 155.32229,37.422668 c -1.0668,0 -1.6002,-0.8001 -1.6002,-2.4003 0,-0.7874 0.127,-1.905 0.381,-3.3528 l 1.2954,-7.8486 c 0.1016,-0.914399 0.1524,-1.435099 0.1524,-1.562099 0,-0.381 -0.1016,-0.5715 -0.3048,-0.5715 -0.5842,0 -1.27,0.762 -2.0574,2.285999 l -0.2667,0.5334 c -0.1016,0.2286 -0.1905,0.381 -0.2667,0.4572 -0.0762,0.0508 -0.1524,0.0762 -0.2286,0.0762 -0.0508,0 -0.1016,-0.0381 -0.1524,-0.1143 -0.0508,-0.1016 -0.0762,-0.2159 -0.0762,-0.3429 0,-0.508 0.254,-1.2192 0.762,-2.133599 0.5334,-0.9398 1.1811,-1.7653 1.9431,-2.4765 0.762,-0.7112 1.4859,-1.0668 2.1717,-1.0668 0.4064,0 0.7239,0.1778 0.9525,0.5334 0.254,0.3302 0.381,0.7874 0.381,1.3716 0,0.381 -0.0254,0.6731 -0.0762,0.8763 l -1.7907,11.239499 c -0.0508,0.3556 -0.0762,0.5842 -0.0762,0.6858 0,0.5334 0.2032,0.8001 0.6096,0.8001 0.8382,0 1.7399,-0.5588 2.7051,-1.6764 0.9906,-1.143 1.8542,-2.5019 2.5908,-4.0767 0.762,-1.5748 1.2573,-2.9591 1.4859,-4.1529 l 0.5334,-2.781299 c 0.2032,-0.9144 0.6096,-1.6129 1.2192,-2.0955 0.635,-0.4826 1.2192,-0.7239 1.7526,-0.7239 0.2032,0 0.3048,0.0635 0.3048,0.1905 0,0.0762 -0.0508,0.2286 -0.1524,0.4572 -0.1016,0.2032 -0.1778,0.4572 -0.2286,0.762 -0.3556,1.5748 -1.0541,5.2324 -2.0955,10.972799 l -0.2286,1.2192 c -0.1778,0.889 -0.2667,1.4351 -0.2667,1.6383 0,0.3556 0.1143,0.5334 0.3429,0.5334 0.4064,0 0.8509,-0.3175 1.3335,-0.9525 0.508,-0.6604 0.9144,-1.3716 1.2192,-2.1336 0.1524,-0.2794 -0.0547,-0.185239 0.0469,-0.185239 0.1524,0 0.32883,0.04748 0.32883,0.276082 0,0.2794 0.17505,0.453883 0.12425,0.657083 -0.1778,0.9144 -0.48418,1.664775 -1.03339,2.452474 -0.49648,0.712079 -1.1303,1.4224 -1.7907,1.905 -0.6604,0.4826 -1.27,0.7239 -1.8288,0.7239 -0.9906,0 -1.4605,-0.7874 -1.4097,-2.3622 0.0508,-0.6858 0.2032,-1.6129 0.4572,-2.7813 l 0.3429,-1.8669 h -0.0381 c -1.3208,2.1082 -2.667,3.81 -4.0386,5.1054 -1.3716,1.27 -2.5146,1.905 -3.429,1.905 z" />
                        <path d="m 173.03872,37.422668 q -1.1811,0 -2.0193,-0.6477 -0.8382,-0.6477 -1.1049,-1.7145 -0.0762,-0.3048 0.2286,-0.9525 0.3429,-0.6858 0.8763,-1.3335 0.3048,-0.3429 0.4953,-0.3429 0.1905,0 0.3048,0.3048 1.143,2.667 3.1623,2.667 1.0287,0 1.6002,-0.6096 0.6096,-0.6477 0.6096,-1.7145 0,-1.4478 -1.6383,-3.7338 l -0.8001,-1.143 q -0.9144,-1.2954 -1.2954,-2.1336 -0.3429,-0.8382 -0.3429,-1.7907 0,-1.523999 0.8001,-2.743199 0.8382,-1.2192 2.1717,-1.905 1.3335,-0.7239 2.7813,-0.7239 2.7432,0 2.7432,1.8669 0,0.6858 -0.4953,1.3716 -0.2667,0.4572 -0.4572,0.4572 -0.2286,0 -0.4191,-0.4572 -0.4191,-0.7239 -1.0287,-1.0287 -0.5715,-0.3429 -1.4859,-0.3429 -1.0668,0 -1.7145,0.5715 -0.6477,0.5715 -0.6477,1.4478 0,0.495299 0.3048,1.142999 0.3429,0.6096 1.2573,1.905 l 0.8001,1.1049 q 1.0668,1.4097 1.4859,2.4384 0.4191,0.9906 0.4191,2.0955 0,1.4097 -0.9144,2.8194 -0.9144,1.3716 -2.4384,2.2479 -1.524,0.8763 -3.2385,0.8763 z" />
                    </g>
                </g>
            </svg>
            </div>

            <h2 id='vael_victus_subtitle' class='w-full sm:w-1/2 m-0 mt-1 mx-auto text-base sm:text-lg flex flex-wrap justify-center items-center gap-x-6 gap-y-2'>
                <span id='web_dev' class="flex items-center justify-center">
                    <img src='img/laptop.svg' alt=''> Web Dev
                </span>
                <span id='game_dev' class="flex items-center justify-center">
                    <img src='img/sword.svg' alt=''> Game Dev
                </span>
                <span id='writer' class="flex items-center justify-center">
                    <img src='img/square-pen.svg' alt=''> Writer
                </span>
            </h2>
        </div>

        <div class="w-full max-w-3xl flex flex-wrap mx-auto">
            <? /* TODO: make navigation if/when I get a third view
                <a href="/blog">
                    <button class="button_primary" type="button">blog</button>
                </a>
                */ 
            ?>
            <section class='mt-0 sm:mt-1' style='opacity: 0; transform: translateY(-20px);'>
                <div class="w-full px-2 sm:px-3 pt-1 sm:pt-3 shadow-xs section_header" id='about_header'>
                    <h2 class='m-0'>About Me</h2>
                </div>
                
                <div class='w-full px-2 sm:px-3 p-3 overflow-auto'>
                    <div>
                        <img id='about_pic' class='mb-1 mr-2 float-left' src='img/vael_headshot_2025.jpg' alt='Vael Victus'> 

                        I am Spencer "Vael" Victus. I work in the financial tech industry and in my spare time I run <a href='https://tinydark.com'>Tinydark</a>, a player-first indie game studio.
                    </div>
                    
                    <div class='mt-2'>
                        I live in upstate South Carolina with my wife, <a href='https://500px.com/p/evelynvictus?view=photos'>Evelyn Victus</a>, and our four kids: Abel <span class='age'>(<?=$abel?> old)</span>, Violet <span class='age'>(<?=$violet?> old)</span>, Olivia <span class='age'>(<?=$olivia?> old)</span>, and Everett <span class='age'>(<?=$everett?> old)</span>. I also have five cats! <span id="view_pets" aria-expanded="false">show<span class="arrow">&#9662;</span></span> I spend most of my time making games, playing games, and raising my kids. I'm a <a href='https://www.youtube.com/playlist?list=PLKQKi0BW3i8xEeDhUJkUnuQVLjMaNnzAE'>motivation junkie</a> and love staying productive, whether it's code, writing, fitness, or research.
                    </div>
                </div>
            </section>

            <section id="pets_section" class="container_shadow mt-0 sm:mt-4">
                <div class="w-full px-2 sm:px-3 pt-3 shadow-xs section_header" id="pets_header">
                    <h3 class="m-0">Our Cats</h3>
                </div>
				<div class='w-full bg-white px-2 sm:px-3 p-3'>
					<div class="w-full mb-4 flex border-b" role="tablist" aria-label="cats tabs">
						<input type="radio" name="cats_tabs" id="tab_living" class="tab_radio" checked>
						<label for="tab_living" class="tab_btn mr-2 px-3 py-1 text-sm rounded-t-md border border-b-0">🐱</label>
						<input type="radio" name="cats_tabs" id="tab_dead" class="tab_radio">
						<label for="tab_dead" class="tab_btn px-3 py-1 text-sm rounded-t-md border border-b-0" title="kitty graveyard :(">😿</label>
					</div>

					<div id="cats_dead" class="pets-grid">
						<div class="pet-card">
							<img src="img/pets/arya.png" alt="Arya">
							<div class="pet-name">Arya</div>
							<div class='memento_mori'>Oct 15th, 2025</div>
						</div>
						<div class="pet-card">
							<img src="img/pets/raja.png" alt="Raja">
							<div class="pet-name">Raja</div>
							<div class='memento_mori'>Oct 2nd, 2022</div>
						</div>
					</div>

					<div id="cats_living" class="pets-grid">
						<div class="pet-card">
							<img src="img/pets/osiris.png" alt="Osiris">
							<div class="pet-name">Osiris</div>
						</div>
						<div class="pet-card">
							<img src="img/pets/primordus.png" alt="Primordus">
							<div class="pet-name">Primordus</div>
						</div>
						<div class="pet-card">
							<img src="img/pets/fennec.png" alt="Fennec">
							<div class="pet-name">Fennec</div>
						</div>
						<div class="pet-card">
							<img src="img/pets/fox.png" alt="Fox">
							<div class="pet-name">Fox</div>
						</div>
						<div class="pet-card">
							<img src="img/pets/willow.png" alt="Willow">
							<div class="pet-name">Willow</div>
						</div>
					</div>

					<div id='credits'>
						Thanks to <a href='https://pixelcatsend.com'>Pixel Cat's End</a> for the art
					</div>
				</div>
            </section>
            
            <section class='container_shadow mt-0 sm:mt-4' style='opacity: 0; transform: translateY(-20px);'>
                <div class="w-full px-2 sm:px-3 pt-3 shadow-xs section_header" id="work_header">
                    <h2 class='m-0'>My Work</h2>
                </div>

                <div class='w-full bg-white px-2 sm:px-3 p-3'>
                    <h3 class='m-0'>Games</h3>

                    <div class='mb-2'>
                        I publish my games under <a href='https://tinydark.com'>Tinydark</a>. I adhere to a <a href='https://tinydark.com/mission'>code of ethics</a> with my design, because I believe games should be doing more to directly benefit the player.
                    </div>

                    <ul>
                        <li><b><a href='https://urpg.tinydark.com'>URPG</a> (alpha)</b> - Open-World Roleplaying MMORPG</li>
                        <li><b><a href='https://blackcrownexhumed.com'>Black Crown: Exhumed (2026)</a></b> - Narrative horror; revival of the original game by Rob Sherman</li>
                        <li><b>Bean Grower (2018)</b> - Casual strategy game about growing beans</li>
                        <li><b><a href='https://monbre.com/'>MonBre</a> (2010)</b> - Monster MMORPG</li>
                    </ul>

                    <h3 class='mb-2'>Software</h3>
                    <ul>
                        <li><b><a href='https://tinydark.com/engine'>GAM3</a></b> - tinydark's proprietary web game engine</li>
                        <li><a href='http://hub.tinydark.com/'>Tinydark Hub</a> - Single sign-on for all tinydark games</li>
                        <li><b>Tinydark Lab</b> - Prototypes and demos of unfinished games</li>
                        <? # <li><b><a href='http://tinydark.com/lab'>Tinydark Lab</a></b> - Prototypes and demos of unfinished games</li> ?>
                    </ul>

                    <h3 class='mb-2'>Writing</h3>
                    <ul>
                        <li><a href='/blog'>vaelvict.us/blog</a></li>
                        <li>Two design analyses of browser games: <a href='blog/post/die2nite-teardown'>Die2Nite</a> and <a href='blog/post/marosia-design-analysis-2020'>Marosia</a></li>
                        <li><a href='https://medium.com/@vaelvictus/calling-all-heroes-blizzards-pernicious-diversity-initiative-cbca4f0ab0ca'>Calling All Heroes: Blizzard's Pernicious Diversity Initiative</a></li>
                    </ul>
                </div>
            </section>

            <section id='connect' class='pl-0 mt-0 sm:mt-4 sm:mb-5' style='opacity: 0; transform: translateY(-20px);'>
                <div class="w-full px-2 sm:px-3 pt-3 shadow-xs section_header" id='connect_header'>
                    <h2 class='m-0'>Connect</h2>
                </div>

                <div class='w-full pt-0 sm:pt-3 px-2 sm:px-3 p-3 grid grid-bubbles bg-white'>
                    
                    <? /* Email.  Mobile: most people have mailto: functionality */ ?>
                    <a class='flex align-items no-underline bg-white  text-black sm:hidden
                                connect_border' href='mailto:vael@tinydark.com' target='_blank'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-2 md:px-0 p-1' src='img/brands/email.svg' alt='email'>
                        <div class='w-4/5 card_txt text-base pl-1'>
                            <span class='underline'>vael@tinydark.com</span>
                            <div class='text-gray-600 text-xs mt-1'>tap to mail</div>
                        </div>
                    </a>

                    <? /* Email. Plaintext for desktop */ ?>
                    <div class='hidden align-items bg-white text-black sm:flex cursor-pointer
                                connect_border' onClick="copyToClipboard('vael@tinydark.com')" 
                                role='button' tabindex="0">
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/email.svg' alt='email'>
                        <div class='w-4/5 card_txt text-sm pl-1'>
                            vael@tinydark.com
                            <div class='text-gray-600 text-xs mt-1' id='click2copy'>click to copy</div>
                        </div>
                    </div>
                    
                    <? /* Discord */ ?>
                    <a href="https://discord.com/users/71398206692401152" class='flex align-items no-underline bg-white 
                    connect_border' target='_blank' title="Note: link only works if we share a server (Discord limitation)">
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/discord.svg' alt=''>
                        <div class='w-4/5 card_txt text-base pl-1' style='color: #2e3dda;'> <? # slightly darker #5865F2 (discord blue) ?>
                            vaelvictus
                            <div class='text-xs mt-1'>Discord</div>
                        </div>
                    </a>
                    
                    <? /* Twitch */ ?>
                    <a class='flex align-items no-underline bg-white 
                                connect_border' href='https://www.twitch.tv/vaelvictus' target='_blank' style='color: #6441a4;'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/twitch.svg' alt=''>
                        <div class='w-4/5 card_txt text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>Twitch</div>
                        </div>
                    </a>

                    <? /* Twitter */ ?>
                    <a class='flex align-items no-underline text-white
                                connect_border' href='https://twitter.com/VaelVictus' target='_blank' style='background: #1DA1F2;'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/twitter.svg' alt=''>
                        <div class='w-4/5 card_txt text-base pl-1'>
                            <span class='underline'>@VaelVictus</span>
                            <div class='text-xs mt-1'>X/Twitter</div>
                        </div>
                    </a>

                    <? /* Steam */ ?>
                    <a class='flex align-items no-underline  text-white
                                connect_border' href='https://steamcommunity.com/id/vaelvictus/' target='_blank' style='background: #231f20;'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/steam.svg' alt=''>
                        <div class='w-4/5 card_txt text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>Steam</div>
                        </div>
                    </a>
                    
                    <? /* Github */ ?>
                    <a class='flex align-items no-underline text-white
                                connect_border' href='https://github.com/VaelVictus' target='_blank' style='background: #111;'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/github.svg' alt=''>
                        <div class='w-4/5 card_txt text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>GitHub</div>
                        </div>
                    </a>

                    <? /* Stack Exchange */ ?>
                    <a class='flex align-items no-underline bg-white  text-black
                                connect_border' href='https://stackexchange.com/users/262546/vael-victus' target='_blank'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/stackexchange.svg' alt=''>
                        <div class='w-4/5 card_txt text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>Stack Exchange</div>
                        </div>
                    </a>
                </div>
            </section>
        </div>
    </main>
    
  </body>
</html>
