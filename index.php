<? 
    $manifest = json_decode(file_get_contents('dist/manifest.json'), true);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vael Victus</title>

    <script type="module" crossorigin src="dist/<?=$manifest['index.html']['file']?>"></script>
    <link rel="stylesheet" href="dist/<?=$manifest['index.html']['css'][0]?>">

    <!-- <script type="module" src="http://localhost:1337/main.js"></script> -->
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
                    md:w-9/12 xl:w-6/12
                  bg-white bg-opacity-70">

            <div class="w-full text-black">
                --- Connect ---
            </div>

            <div class='flex border-b-2'>
                <div class="w-9/12 bg-white">
                    hi im vael
                </div>
            </div>
            
        </div>
    </div>
    
  </body>
</html>