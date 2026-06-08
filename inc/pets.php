<?

$cats_dead = [
    [
        'id' => 'arya',
        'name' => 'Arya',
        'sprite' => 'img/pets/arya.png',
        'photo' => 'img/pet_photos/arya_optimized.webp',
        'description' => 'A runt named after Arya Stark because we found her abandoned on the street. Passed from thyroid issues.',
        'memento_mori' => 'Oct 15th, 2025',
    ],
    [
        'id' => 'raja',
        'name' => 'Raja',
        'sprite' => 'img/pets/raja.png',
        'photo' => 'img/pet_photos/raja_optimized.webp',
        'description' => "Our first cat, inherited from my mother-in-law. His name means 'king.' Likely passed from an unfortunate encounter with a toad.",
        'memento_mori' => 'Oct 2nd, 2022',
    ],
];

$cats_living = [
    [
        'id' => 'osiris',
        'name' => 'Osiris',
        'sprite' => 'img/pets/osiris.png',
        'photo' => 'img/pet_photos/osiris_optimized.webp',
        'description' => 'Named for his coloring.',
    ],
    [
        'id' => 'primordus',
        'name' => 'Primordus',
        'sprite' => 'img/pets/primordus.png',
        'photo' => 'img/pet_photos/primordus_optimized.webp',
        'description' => 'Named after the fire dragon from Guild Wars 2 because I thought it\'d be funny for this cute little kitty to be named after such a ferocious beast!',
    ],
    [
        'id' => 'fennec',
        'name' => 'Fennec',
        'sprite' => 'img/pets/fennec.png',
        'photo' => 'img/pet_photos/fennec_optimized.webp',
        'description' => 'Named for his coloring and resemblance to a fennec fox.',
    ],
    [
        'id' => 'fox',
        'name' => 'Fox',
        'sprite' => 'img/pets/fox.png',
        'photo' => 'img/pet_photos/fox_optimized.webp',
        'description' => "Named for his coloring and pairing with Fennec (they're brothers).",
    ],
    [
        'id' => 'willow',
        'name' => 'Willow',
        'sprite' => 'img/pets/willow.png',
        'photo' => 'img/pet_photos/willow_optimized.webp',
        'description' => 'Named after the willow tree.',
    ],
    [
        'id' => 'lune',
        'name' => 'Lune',
        'sprite' => 'img/pets/lune.png',
        'photo' => 'img/pet_photos/lune_optimized.webp',
        'description' => 'Named after Prince Lune from The Cat Returns.',
    ],
];

function render_pet_card(array $cat): void {
    $pet_id = $cat['id'];
    ?>
    <label for="pet_sel_<?= $pet_id ?>" class="pet-card">
        <img src="<?= $cat['sprite'] ?>" loading="lazy" decoding="async" alt="<?= $cat['name'] ?>">
        <div class="pet-name"><?= $cat['name'] ?></div>
        <? if (!empty($cat['memento_mori'])) { ?>
        <div class="memento_mori"><?= $cat['memento_mori'] ?></div>
        <? } ?>
        <div class="pet_tooltip" id="cat_tooltip_<?= $pet_id ?>" role="tooltip">
            <img class="pet_tooltip_img" src="<?= $cat['photo'] ?>" loading="lazy" decoding="async" alt="">
            <div class="pet_tooltip_name"><?= $cat['name'] ?></div>
            <div class="pet_tooltip_description"><?= $cat['description'] ?></div>
        </div>
    </label>
    <?
}


function render_pet_mobile_panel(array $cat): void {
    $pet_id = $cat['id'];
    ?>
    <div class="pet_mobile_panel" id="pet_mobile_<?= $pet_id ?>">
        <img class="pet_mobile_panel_img" src="<?= $cat['photo'] ?>" loading="lazy" decoding="async" alt="">
        <div class="pet_mobile_panel_body">
            <div class="pet_mobile_panel_name"><?= $cat['name'] ?></div>
            <? if (!empty($cat['memento_mori'])) { ?>
                <div class="pet_mobile_panel_mori"><?= $cat['memento_mori'] ?></div>
            <? } ?>
            <div class="pet_mobile_panel_description"><?= $cat['description'] ?></div>
        </div>
    </div>
    <?
}

function render_pets_tab(string $tab_id, string $radio_name, array $cats): void {
    ?>
    <div id="<?= $tab_id ?>" class="pets_tab_panel">
        <? foreach ($cats as $cat) { ?>
            <input type="radio" name="<?= $radio_name ?>" id="pet_sel_<?= $cat['id'] ?>" class="pet_select_radio">
        <? } ?>
        <div class="pets-grid">
            <? foreach ($cats as $cat) {
                render_pet_card($cat);
            } ?>
        </div>
        <div class="pets_mobile_info">
            <? foreach ($cats as $cat) {
                render_pet_mobile_panel($cat);
            } ?>
        </div>
    </div>
    <?
}

function render_pets_mobile_select_styles(string $tab_id, array $cats): void {
    foreach ($cats as $cat) {
        $pet_id = $cat['id'];
        echo "    #{$tab_id}:has(#pet_sel_{$pet_id}:checked) #pet_mobile_{$pet_id} { display: grid; }\n";
    }
}
