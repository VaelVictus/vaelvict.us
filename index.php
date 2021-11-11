<? 
    $manifest = json_decode(file_get_contents('dist/manifest.json'), true);

    require_once('inc/helpers.php');

    $abel   = GetAge('2011-01-03');
    $violet = GetAge('2021-01-05');

    // ! Cards with text, opting for just icons for now.
    /*    <div class="flex flex-grow mr-2 align-items bg-white rounded">
            <img class='w-1/6 md:w-1/5 mx-1 my-3 mr-2' src='img/brands/discord.svg'>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <title>Vael Victus</title>

    <script type="module" crossorigin src="dist/<?=$manifest['index.html']['file']?>"></script>
    <link rel="stylesheet" href="dist/<?=$manifest['index.html']['css'][0]?>">

    <!-- <script type="module" src="http://localhost:1337/main.js"></script> -->
  </head>

  <body>

    <main class="grid text-base h-screen place-items-center bg-cover" style='background-image: url("img/bg-min.png");'>
        <div class="w-full md:w-9/12 max-w-4xl shadow-xl
                    flex flex-wrap 
                  bg-white">

            <h1 class='w-full p-2 m-0 text-center bg-black text-white text-2xl'>
                Vael Victus
            </h1>

            <div class='w-full md:w-3/4'>
                <div>
                    <div class="w-full p-2 shadow-xs  text-black" style="background-color: rgba(255, 160, 11, 1)">
                        <h2 class='m-0 text-xl'>About Me</h2>
                    </div>
                    
                    <div class='w-full p-2 py-3'>
                        <div class='text-base'>
                            I'm a web developer, game developer, writer, and father of two. I run <a href='https://tinydark.com'>tinydark</a>, an ethics-focused indie game microstudio. I spend most of my time making games and raising my kids.
                        </div>
                        
                        <div class='text-base mt-2'>
                            I live in Greenville, South Carolina. I'm married to the incomparable <a href='https://500px.com/p/evelynvictus?view=galleries'>Evelyn Victus</a>. We have two kids: Abel (<?=$abel?> old) and Violet (<?=$violet?> old).
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="w-full p-2 shadow-xs  text-black" style="background-color: rgba(255, 78, 50, 1);">
                        <h2 class='m-0 text-xl'>My Work</h2>
                    </div>

                    <div class='w-full p-2 py-3'>
                        I publish my games under <a href='https://tinydark.com'>tinydark</a>. I adhere to a <a href='https://tinydark.com'>code of ethics</a> with my design.

                        <h3 class='mb-1'>Games</h3>
                        <ul>
                            <li><a href='https://www.theorbium.com/urpg'>URPG (alpha)</a> - Open-World Roleplaying MMO</li>
                            <li>Black Crown (2022) - Narrative Horror Game</li>
                            <li>Bean Grower (2018) - Casual Strategy Game</li>
                            <li><a href='https://monbre.com/'>MonBre</a> (2010) - Monster MMORPG</li>
                        </ul>

                        <h3 class='mb-1'>Software</h3>
                        <ul>
                            <li>GAM3, proprietary web game engine</li>
                            <li><a href='http://hub.tinydark.com/'>Tinydark Hub</a></li>
                            <li><a href='http://lab.tinydark.com/'>Tinydark Lab</a>, </li>
                        </ul>

                        <h3 class='mb-1'>Writing</h3>
                        More soon.
                        <ul>
                            <li>Two analytical teardowns of browser games: <a href='https://vael.tumblr.com/post/187341440887/die2nite-teardown-a-teardown-is-a-document-that'>Die2Nite</a> and <a href='https://vael.tumblr.com/post/634149707769430016/marosia-teardown-2020-final'>Marosia</a></li>
                            <li>Blogging <a href='https://vael.tumblr.com/'>on Tumblr</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='w-full md:w-1/4'>
                <div class="w-full p-2 shadow-xs  text-black " style="background-color: rgba(0, 212, 129, 1);">
                    <h1 class='m-0 text-xl'>Connect</h1>
                    <!-- <div class='text-gray-800 pt-1'>Links open in new window</div> -->
                </div>

                <div class='w-full grid grid-bubbles'>
                    
                    <? /* Email.  Mobile: most people have mailto: functionality */ ?>
                    <a class='flex align-items shadow no-underline bg-white  text-black md:hidden' href='mailto:vael@tinydark.com' target='_blank'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/mail.svg'>
                        <div class='card_txt w-4/5 text-base pl-1'>
                            <span class='underline'>vael@tinydark.com</span>
                            <div class='text-gray-600 text-xs mt-1'>tap to mail</div>
                        </div>
                    </a>

                    <? /* Email. Plaintext for desktop */ ?>
                    <div class='hidden align-items shadow bg-white  text-black md:flex cursor-pointer' onClick="copyToClipboard('vael@tinydark.com')" target='_blank'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/mail.svg'>
                        <div class='card_txt w-4/5 text-base pl-1'>
                            vael@tinydark.com
                            <div class='text-gray-600 text-xs mt-1' id='click2copy'>click to copy</div>
                        </div>
                    </div>

                    
                    <? /* Discord */ ?>
                    <div class='flex align-items shadow no-underline bg-white ' target='_blank'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/discord.svg'>
                        <div class='w-4/5 card_txt text-base pl-2' style='color: #5865F2;'>
                            Vael Victus#0001
                            <div class='text-xs mt-1'>Discord</div>
                        </div>
                    </div>
                    
                    <? /* Twitch */ ?>
                    <a class='flex align-items shadow no-underline bg-white ' href='https://www.twitch.tv/vaelvictus' target='_blank' style='color: #6441a4;'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/twitch.svg'>
                        <div class='card_txt w-4/5 text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>Twitch</div>
                        </div>
                    </a>

                    <? /* Twitter */ ?>
                    <a class='flex align-items shadow no-underline text-white' href='https://twitter.com/VaelVictus' target='_blank' style='background: #1DA1F2;'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/twitter.svg'>
                        <div class='card_txt w-4/5 text-base pl-1'>
                            <span class='underline'>@VaelVictus</span>
                            <div class='text-xs mt-1'>Twitter</div>
                        </div>
                    </a>

                    <? /* Steam */ ?>
                    <a class='flex align-items shadow no-underline  text-white' href='https://steamcommunity.com/id/vaelvictus/' target='_blank' style='background: #171a21;'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/steam.svg'>
                        <div class='card_txt w-4/5 text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>Steam</div>
                        </div>
                    </a>
                    
                    <? /* Github */ ?>
                    <a class='flex align-items shadow no-underline text-white' href='https://github.com/VaelVictus' target='_blank' style='background: #111;'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/github.svg'>
                        <div class='card_txt w-4/5 text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>GitHub</div>
                        </div>
                    </a>

                    <? /* Stack Exchange */ ?>
                    <a class='flex align-items shadow no-underline bg-white  text-black' href='https://stackexchange.com/users/262546/vael-victus' target='_blank'>
                        <img class='w-1/6 md:w-1/5 mx-1 my-3' src='img/brands/stackexchange.svg'>
                        <div class='card_txt w-4/5 text-base pl-1'>
                            <span class='underline'>Vael Victus</span>
                            <div class='text-xs mt-1'>Stack Exchange</div>
                        </div>
                    </a>
                </div>
            </div>


        </div>
    </main>
    
  </body>
</html>