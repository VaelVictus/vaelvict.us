<? 
    require_once('inc/helpers.php');

    $abel   = GetAge('2011-01-03');
    $violet = GetAge('2021-01-05');

    // TODO:
    // Fade in content
    // Read from site manifest, set up perpetual asset caching
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Vael Victus</title>

<? if (DEV_ENV == 'prod') { ?>
    <link rel="stylesheet" href="dist/assets/index.css">
    <script type="module" crossorigin src="dist/assets/index.js"></script>
<? } else { ?>
    <script type="module" src="http://localhost:1337/main.js"></script>
<? } ?>

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
    <link href="https://fonts.googleapis.com/css2?family=Charm:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
  </head>

  <body>

    <main class="text-base overflow-auto bg-cover w-full h-full">
        <div id='vv' class="w-full py-3 sm:w-9/12 max-w-4xl sm:pb-4 text-center mx-auto">
            <h1 id='vael_victus' class='p-2 pb-3 m-0 text-black text-5xl' style='font-family: Charm;'>
                Vael Victus
            </h1>

            <h2 id='vael_victus_subtitle' class='w-full sm:w-1/2 m-0 mx-auto text-base sm:text-lg'>
                <span id='web_dev'>
                    <img src='img/dev_web.svg' alt=''> web dev
                </span>
                <span id='game_dev'>
                    <img src='img/game_dev.svg' alt=''> game dev
                </span>
                <span id='writer'>
                    <img src='img/writer.svg' alt=''> writer
                </span>
            </h2>
        </div>

        <div class="w-full max-w-3xl flex flex-wrap mx-auto">
            <section>
                <div class="w-full px-2 sm:px-3 pt-3 shadow-xs section_header" id='about_header'>
                    <h2 class='m-0'>About Me</h2>
                </div>
                
                <div class='w-full px-2 sm:px-3 p-3'>
                    <div class='text-base'>
                        My name is Spencer "Vael" Victus. I work in the financial tech industry and in my spare time I run <a href='https://tinydark.com'>tinydark</a>, an ethics-focused indie game microstudio.
                    </div>
                    
                    <div class='text-base mt-2'>
                        I live in upstate South Carolina with my wife, <a href='https://500px.com/p/evelynvictus?view=photos'>Evelyn Victus</a>, and our two kids: Abel (<?=$abel?> old) and Violet (<?=$violet?> old). I spend most of my time making games, playing games, and raising my kids.
                    </div>
                </div>
            </section>
            
            <section class='container_shadow mt-0 sm:mt-3'>
                <div class="w-full px-2 sm:px-3 pt-3 shadow-xs section_header" id="work_header">
                    <h2 class='m-0'>My Work</h2>
                </div>

                <div class='w-full bg-white px-2 sm:px-3 p-3'>
                    <h3 class='m-0'>Games</h3>

                    <div class='mb-2'>
                        I publish my games under <a href='https://tinydark.com'>tinydark</a>. I adhere to a <a href='https://tinydark.com/mission'>code of ethics</a> with my design, because I believe games should be doing more to directly benefit the player.
                    </div>

                    <ul>
                        <li><b><a href='https://www.theorbium.com/urpg'>URPG (alpha)</a></b> - Open-World Roleplaying MMORPG</li>
                        <li><b>Black Crown: Exhumed (2022)</b> - Narrative horror; revival of the original game by Rob Sherman</li>
                        <li><b>Bean Grower (2018)</b> - Casual strategy game about growing beans</li>
                        <li><b><a href='https://monbre.com/'>MonBre</a> (2010)</b> - Monster MMORPG</li>
                    </ul>

                    <h3 class='mb-2'>Software</h3>
                    <ul>
                        <li><b>GAM3</b> - tinydark's proprietary web game engine</li>
                        <li><b><a href='http://hub.tinydark.com/'>Tinydark Hub</a></b> - Single sign-on for all tinydark games</li>
                        <li><b>Tinydark Lab</b> - Prototypes and demos of unfinished games</li>
                        <? # <li><b><a href='http://tinydark.com/lab'>Tinydark Lab</a></b> - Prototypes and demos of unfinished games</li> ?>
                    </ul>

                    <h3 class='mb-2'>Writing</h3>
                    <ul>
                        <li>Two design analyses of browser games: <a href='https://vael.tumblr.com/post/187341440887/die2nite-teardown-a-teardown-is-a-document-that'>Die2Nite</a> and <a href='https://vael.tumblr.com/post/634149707769430016/marosia-teardown-2020-final'>Marosia</a></li>
                        <? # <li>Blogging <a href='https://vael.tumblr.com/'>on Tumblr</a></li> ?>
                        <li>More soon...</li>
                    </ul>
                </div>
            </section>

            <section class='pl-0 mt-0 sm:my-3 sm:mb-5'>
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
                    <div class='hidden align-items bg-white  text-black sm:flex cursor-pointer
                                connect_border' onClick="copyToClipboard('vael@tinydark.com')" target='_blank'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/email.svg' alt='email'>
                        <div class='w-4/5 card_txt text-sm pl-1'>
                            vael@tinydark.com
                            <div class='text-gray-600 text-xs mt-1' id='click2copy'>click to copy</div>
                        </div>
                    </div>
                    
                    <? /* Discord */ ?>
                    <div class='flex align-items no-underline bg-white 
                                connect_border' target='_blank'>
                        <img class='w-1/6 sm:w-1/5 mx-1 my-3 px-1 md:px-0' src='img/brands/discord.svg' alt=''>
                        <div class='w-4/5 card_txt text-base pl-1' style='color: #5865F2;'>
                            Vael Victus#0001
                            <div class='text-xs mt-1'>Discord</div>
                        </div>
                    </div>
                    
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
                            <div class='text-xs mt-1'>Twitter</div>
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