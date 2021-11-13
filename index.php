<? 
    $manifest = json_decode(file_get_contents('dist/manifest.json'), true);

    require_once('inc/helpers.php');

    $abel   = GetAge('2011-01-03');
    $violet = GetAge('2021-01-05');

    // ! Cards with text, opting for just icons for now.
    /*    <div class="flex flex-grow mr-2 align-items bg-white rounded">
            <img class='w-1/6 sm:w-1/5 mx-1 my-3 mr-2' src='img/brands/discord.svg'>
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

    <meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Vael Victus - Web Game Developer" />
	<meta property="og:description" content="Vael Victus is a web-based game designer and application developer." />
	<meta property="og:url" content="https://www.vaelvictus.com" />
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
    <link href="https://fonts.googleapis.com/css2?family=Charm:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    
    <title>Vael Victus</title>

    <? if (DEV_ENV == 'prod') { ?>
        <script type="module" crossorigin src="dist/<?=$manifest['index.html']['file']?>"></script>
        <link rel="stylesheet" href="dist/<?=$manifest['index.html']['css'][0]?>">
    <? } else { ?>
        <script type="module" src="http://localhost:1337/main.js"></script>
    <? } ?>
  </head>

  <body>

    <main class="text-base overflow-auto bg-cover w-full h-full">
    
        <? // ! It's me! ?>
        <div class="w-full py-3 sm:w-9/12 max-w-4xl text-center mx-auto">
            <h1 id='vael_victus' class='p-2 m-0 text-black text-5xl' style='font-family: Charm;'>
                Vael Victus
            </h1>

            <h2 class='m-0 text-base sm:text-lg'>web developer • game developer • writer</h2>
        </div>

        <div class="w-full lg:pl-6 max-w-4xl flex flex-wrap mx-auto">

            <div class='w-full sm:w-3/4'>
                <div class='shadow'>
                    <div class="w-full px-3 py-2 shadow-xs  text-white" style="background-color: rgb(2 64 118);">
                        <h2 class='m-0 text-xl'>About Me</h2>
                    </div>
                    
                    <div class='w-full bg-white p-3'>
                        <div class='text-base'>
                            My name is Spencer "Vael" Victus. I work in the financial tech industry and in my spare time I run <a href='https://tinydark.com'>tinydark</a>, an ethics-focused indie game microstudio.
                        </div>
                        
                        <div class='text-base mt-2'>
                            I live in upstate South Carolina with my wife, <a href='https://500px.com/p/evelynvictus?view=galleries'>Evelyn Victus</a>, and our two kids: Abel (<?=$abel?> old) and Violet (<?=$violet?> old). I spend most of my time making games, playing games, and raising my kids.
                        </div>
                    </div>
                </div>
                
                <div class='shadow mt-0 sm:mt-3'>
                    <div class="w-full px-3 py-2 shadow-xs  text-white" style="background-color: rgb(153 21 0);">
                        <h2 class='m-0 text-xl'>My Work</h2>
                    </div>

                    <div class='w-full bg-white p-3'>
                        <h3 class='m-0'>Games</h3>

                        <div class='mb-2'>
                            I publish my games under <a href='https://tinydark.com'>tinydark</a>. I adhere to a <a href='https://tinydark.com/mission'>code of ethics</a> with my design, because I believe games should be doing more to directly benefit the player.
                        </div>

                        <ul>
                            <li><b><a href='https://www.theorbium.com/urpg'>URPG (alpha)</a></b> - Open-World Roleplaying MMO</li>
                            <li><b>Black Crown: Exhumed (2022)</b> - Narrative horror; revival of the original game by Rob Sherman</li>
                            <li><b>Bean Grower (2018)</b> - Casual strategy game about growing beans</li>
                            <li><b><a href='https://monbre.com/'>MonBre</a> (2010)</b> - Monster MMORPG</li>
                        </ul>

                        <h3 class='mb-2'>Software</h3>
                        <ul>
                            <li><b>GAM3</b> - tinydark's proprietary web game engine</li>
                            <li><b><a href='http://hub.tinydark.com/'>Tinydark Hub</a></b> - Single sign-on for all tinydark games</li>
                            <li><b>Tinydark Lab</b> - Prototypes and demos of unfinished games</li>
                            <!-- <li><b><a href='http://tinydark.com/lab'>Tinydark Lab</a></b> - Prototypes and demos of unfinished games</li> -->
                        </ul>

                        <h3 class='mb-2'>Writing</h3>
                        <ul>
                            <li>Two design analyses of browser games: <a href='https://vael.tumblr.com/post/187341440887/die2nite-teardown-a-teardown-is-a-document-that'>Die2Nite</a> and <a href='https://vael.tumblr.com/post/634149707769430016/marosia-teardown-2020-final'>Marosia</a></li>
                            <li>Blogging <a href='https://vael.tumblr.com/'>on Tumblr</a></li>
                            <li>More soon...</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='w-full pl-0 sm:w-1/4 sm:pl-3'>
                <div class='shadow'>
                    <div class="w-full px-3 py-2 shadow-xs  text-white" style="background-color: #407602;">
                        <h2 class='m-0 text-xl'>Connect</h2>
                        <!-- <div class='text-gray-800 pt-1'>Links open in new window</div> -->
                    </div>

                    <div class='w-full grid grid-bubbles'>
                        
                        <? /* Email.  Mobile: most people have mailto: functionality */ ?>
                        <a class='flex align-items shadow no-underline bg-white  text-black sm:hidden' href='mailto:vael@tinydark.com' target='_blank'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/mail.svg'>
                            <div class='w-4/5 card_txt text-base pl-1'>
                                <span class='underline'>vael@tinydark.com</span>
                                <div class='text-gray-600 text-xs mt-1'>tap to mail</div>
                            </div>
                        </a>

                        <? /* Email. Plaintext for desktop */ ?>
                        <div class='hidden align-items shadow bg-white  text-black sm:flex cursor-pointer' onClick="copyToClipboard('vael@tinydark.com')" target='_blank'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/mail.svg'>
                            <div class='w-4/5 card_txt text-base pl-1'>
                                vael@tinydark.com
                                <div class='text-gray-600 text-xs mt-1' id='click2copy'>click to copy</div>
                            </div>
                        </div>

                        
                        <? /* Discord */ ?>
                        <div class='flex align-items shadow no-underline bg-white ' target='_blank'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/discord.svg'>
                            <div class='w-4/5 card_txt text-base pl-1' style='color: #5865F2;'>
                                Vael Victus#0001
                                <div class='text-xs mt-1'>Discord</div>
                            </div>
                        </div>
                        
                        <? /* Twitch */ ?>
                        <a class='flex align-items shadow no-underline bg-white ' href='https://www.twitch.tv/vaelvictus' target='_blank' style='color: #6441a4;'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/twitch.svg'>
                            <div class='w-4/5 card_txt text-base pl-1'>
                                <span class='underline'>Vael Victus</span>
                                <div class='text-xs mt-1'>Twitch</div>
                            </div>
                        </a>

                        <? /* Twitter */ ?>
                        <a class='flex align-items shadow no-underline text-white' href='https://twitter.com/VaelVictus' target='_blank' style='background: #1DA1F2;'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/twitter.svg'>
                            <div class='w-4/5 card_txt text-base pl-1'>
                                <span class='underline'>@VaelVictus</span>
                                <div class='text-xs mt-1'>Twitter</div>
                            </div>
                        </a>

                        <? /* Steam */ ?>
                        <a class='flex align-items shadow no-underline  text-white' href='https://steamcommunity.com/id/vaelvictus/' target='_blank' style='background: #171a21;'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/steam.svg'>
                            <div class='w-4/5 card_txt text-base pl-1'>
                                <span class='underline'>Vael Victus</span>
                                <div class='text-xs mt-1'>Steam</div>
                            </div>
                        </a>
                        
                        <? /* Github */ ?>
                        <a class='flex align-items shadow no-underline text-white' href='https://github.com/VaelVictus' target='_blank' style='background: #111;'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/github.svg'>
                            <div class='w-4/5 card_txt text-base pl-1'>
                                <span class='underline'>Vael Victus</span>
                                <div class='text-xs mt-1'>GitHub</div>
                            </div>
                        </a>

                        <? /* Stack Exchange */ ?>
                        <a class='flex align-items shadow no-underline bg-white  text-black' href='https://stackexchange.com/users/262546/vael-victus' target='_blank'>
                            <img class='w-1/6 sm:w-1/5 mx-1 my-3' src='img/brands/stackexchange.svg'>
                            <div class='w-4/5 card_txt text-base pl-1'>
                                <span class='underline'>Vael Victus</span>
                                <div class='text-xs mt-1'>Stack Exchange</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </main>
    
  </body>
</html>