<? 
    $manifest = json_decode(file_get_contents('dist/manifest.json'), true);

    // ! Cards with text, opting for just icons for now.
    /*    <div class="flex flex-grow mr-2 align-items bg-white rounded">
            <img class='w-1/6 md:w-1/5 mr-2' src='img/brands/discord.svg'>
            <div class='card_txt w-4/5 text-base' style='color: #5865F2;'>
                Vael Victus#0001
            </div>
        </div> */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Vael Victus">
    <meta name="description" content="Vael Victus is a web-based game designer and application developer.">
    <meta name="keywords" content="vael victus, tinydark, victus, bean grower, monbre, black crown exhumed">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Vael Victus">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

    <title>Vael Victus</title>

    <!-- <script type="module" crossorigin src="dist/<?=$manifest['index.html']['file']?>"></script>
    <link rel="stylesheet" href="dist/<?=$manifest['index.html']['css'][0]?>"> -->

    <script type="module" src="http://localhost:1337/main.js"></script>
  </head>

  <body>

    <style>
        .card {
            display: flex;
            flex-direction: column;
        }

        <? # Not bothering with PostCSS's @media parsing ?>

        @media only screen and (min-width: 420px) {
            .grid-bubbles {
                grid-template-columns: repeat(auto-fill, 47%);
            }
        }

        @media only screen and (min-width: 768px) {
            .grid-bubbles {
                grid-template-columns: repeat(auto-fill, 31%);
            }
        }
    </style>

    <div class="grid h-screen place-items-center bg-cover" style='background-image: url("img/bg.png");'>
        <div class="w-full md:w-9/12 max-w-3xl
                  bg-white bg-opacity-40">

            <div class="w-full text-black">
                <h1 class='m-0 p-2 bg-white bg-opacity-40'>Connect</h1>
                <div class='text-gray-800 p-2'>Links open in new window</div>
            </div>

            <div class='w-full my-2 grid grid-bubbles px-2'>
                
                <? /* Email.  Mobile: most people have mailto: functionality */ ?>
                <a class='flex align-items py-2 bg-white  text-black md:hidden hover:shadow-md transition-shadow' href='mailto:vael@tinydark.com' target='_blank'>
                    <img class='w-1/6 md:w-1/5' src='img/brands/mail.svg'>
                    <div class='card_txt w-4/5 text-base pl-2'>
                        vael@tinydark.com
                    </div>
                </a>

                <? /* Email. Plaintext for desktop */ ?>
                <div class='hidden align-items bg-white  text-black md:flex hover:shadow-md transition-shadow' target='_blank'>
                    <img class='w-1/6 md:w-1/5' src='img/brands/mail.svg'>
                    <div class='card_txt w-4/5 text-base pl-2'>
                        vael@tinydark.com
                    </div>
                </div>

                
                <? /* Discord */ ?>
                <div class='flex align-items py-2 bg-white  hover:shadow-md transition-shadow' target='_blank'>
                    <img class='w-1/6 md:w-1/5' src='img/brands/discord.svg'>
                    <div class='w-4/5 card_txt text-base pl-2' style='color: #5865F2;'>
                        Vael Victus#0001
                    </div>
                </div>
                
                <? /* Twitch */ ?>
                <a class='flex align-items py-2 bg-white  hover:shadow-md transition-shadow' href='https://www.twitch.tv/vaelvictus' target='_blank' style='color: #6441a4;'>
                    <img class='w-1/6 md:w-1/5' src='img/brands/twitch.svg'>
                    <div class='card_txt w-4/5 text-base pl-2'>
                        Vael Victus
                    </div>
                </a>

                <? /* Steam */ ?>
                <a class='flex align-items py-2  text-white hover:shadow-md transition-shadow' href='https://steamcommunity.com/id/vaelvictus/' target='_blank' style='background: #171a21;'>
                    <img class='w-1/6 md:w-1/5' src='img/brands/steam.svg'>
                    <div class='card_txt w-4/5 text-base pl-2'>
                        Vael Victus
                    </div>
                </a>
                
                <? /* Github */ ?>
                <a class='flex align-items py-2 bg-black  text-white hover:shadow-md transition-shadow' href='https://github.com/VaelVictus' target='_blank'>
                    <img class='w-1/6 md:w-1/5' src='img/brands/github.svg'>
                    <div class='card_txt w-4/5 text-base pl-2'>
                        Vael Victus
                    </div>
                </a>

                <? /* Github */ ?>
                <a class='flex align-items py-2 bg-black  text-white hover:shadow-md transition-shadow' href='https://github.com/VaelVictus' target='_blank'>
                    <img class='w-1/6 md:w-1/5' src='img/brands/github.svg'>
                    <div class='card_txt w-4/5 text-base pl-2'>
                        Vael Victus
                    </div>
                </a>

            </div>
        </div>
    </div>
    
  </body>
</html>