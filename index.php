<? 
    $manifest = json_decode(file_get_contents('dist/manifest.json'), true);

    // ! Cards with text, opting for just icons for now.
    /*    <div class="w-60 flex flex-grow mr-2 align-items bg-white rounded">
            <img class='w-1/4 mr-2' src='img/brands/discord.svg'>
            <div class='card_txt w-3/4 text-base' style='color: #5865F2;'>
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
    </style>

    <div class="grid h-screen place-items-center bg-cover" style='background-image: url("img/bg.png");'>
        <div class="w-full flex flex-wrap shadow-md 
                    md:w-9/12 max-w-3xl
                  bg-white bg-opacity-60">

            <div class="w-full text-black">
                <h1>--- Connect ---</h1>
                Links open in new window
            </div>

            <div class='flex flex-wrap border-b-2'>

                <!-- TODO: see if I can get away with space-evenly -->
                <div class='w-60 flex m-2 align-items bg-white rounded-lg' target='_blank'>
                    <img class='w-1/4' src='img/brands/discord.svg'>
                    <div class='card_txt w-3/4 text-base pl-2' style='color: #5865F2;'>
                        Vael Victus#0001
                    </div>
                </div>
                
                <a class='w-60 flex m-2 align-items bg-white rounded-lg' href='https://www.twitch.tv/vaelvictus' target='_blank' style='color: #6441a4;'>
                    <img class='w-1/4' src='img/brands/twitch.svg'>
                    <div class='card_txt w-3/4 text-base pl-2'>
                        Vael Victus
                    </div>
                </a>

                <a class='w-60 flex m-2 align-items bg-white rounded-lg text-black hover:shadow-md transition-shadow' href='https://steamcommunity.com/id/vaelvictus/' target='_blank'>
                    <img class='w-1/4' src='img/brands/steam.svg'>
                    <div class='card_txt w-3/4 text-base pl-2'>
                        Vael Victus
                    </div>
                </a>
                
                <a class='w-60 flex m-2 align-items bg-white rounded-lg text-black' href='https://github.com/VaelVictus' target='_blank'>
                    <img class='w-1/4' src='img/brands/github.svg'>
                    <div class='card_txt w-3/4 text-base pl-2'>
                        Vael Victus
                    </div>
                </a>

                <!-- 
                    <img class='w-1/6 mx-2' src='img/brands/discord.svg'>
                    <a href='https://steamcommunity.com/id/vaelvictus/' target='_blank'>
                    <img class='w-1/6 mx-2' src='img/brands/steam.svg'>
                </a>

                <a href='https://www.twitch.tv/vaelvictus' target='_blank'>
                    <img class='w-1/6 mx-2' src='img/brands/twitch.svg'>
                </a>

                <a href='https://github.com/VaelVictus' target='_blank'>
                    <img class='w-1/6 mx-2' src='img/brands/github.svg'>
                </a> -->

            </div>
            
        </div>
    </div>
    
  </body>
</html>