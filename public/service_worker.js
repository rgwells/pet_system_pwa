const CACHE_NAME = `pandemon-cache-v1`;

const CACHE_BASE_URLS = [
    // HTML
    "/pandemon/public/index.html",

    // Stylesheets
    "/pandemon/public/css/style.css",

    // JavaScript
    "/pandemon/public/js/random_utility.js",
    "/pandemon/public/js/typewriter.js",

    // Images
    "/pandemon/public/img/frame/frame-black.webp",
    "/pandemon/public/img/frame/frame-blue.webp",
    "/pandemon/public/img/frame/frame-brown.webp",
    "/pandemon/public/img/frame/frame-green.webp",
    "/pandemon/public/img/frame/frame-purple.webp",
    "/pandemon/public/img/frame/frame-red.webp",
    "/pandemon/public/img/frame/frame-silver.webp",
    "/pandemon/public/img/frame/frame-skyblue.webp",
    "/pandemon/public/img/frame/frame-white.webp",
    "/pandemon/public/img/frame/frame-yellow.webp",
    "/pandemon/public/img/frame/logo-pandemon.webp",

    "/pandemon/public/img/global-button/button-forage.webp",
    "/pandemon/public/img/global-button/button-forage-active.webp",
    "/pandemon/public/img/global-button/button-quest.webp",
    "/pandemon/public/img/global-button/button-quest-active.webp",
    "/pandemon/public/img/global-button/button-rest.webp",
    "/pandemon/public/img/global-button/button-rest-active.webp",
    "/pandemon/public/img/global-button/button-train.webp",
    "/pandemon/public/img/global-button/button-train-active.webp",

    "/pandemon/public/img/global-expression/expression-confident.webp",
    "/pandemon/public/img/global-expression/expression-critical.webp",
    "/pandemon/public/img/global-expression/expression-disappointed.webp",
    "/pandemon/public/img/global-expression/expression-excited.webp",
    "/pandemon/public/img/global-expression/expression-happy.webp",
    "/pandemon/public/img/global-expression/expression-nervous.webp",
    "/pandemon/public/img/global-expression/expression-sick.webp",
    "/pandemon/public/img/global-expression/expression-surprised.webp",
    "/pandemon/public/img/global-expression/expression-tired.webp",

    "/pandemon/public/img/global-menu/foraging-centaurfruits.webp",
    "/pandemon/public/img/global-menu/foraging-dragonleaf.webp",
    "/pandemon/public/img/global-menu/foraging-elfroot.webp",
    "/pandemon/public/img/global-menu/foraging-elvenmushroom.webp",
    "/pandemon/public/img/global-menu/foraging-fairynectar.webp",
    "/pandemon/public/img/global-menu/foraging-magicalberries.webp",
    "/pandemon/public/img/global-menu/foraging-moonflower.webp",
    "/pandemon/public/img/global-menu/foraging-pixiehoney.webp",
    "/pandemon/public/img/global-menu/rest-sleeping.webp",
    "/pandemon/public/img/global-menu/training-aquatic.webp",
    "/pandemon/public/img/global-menu/training-art.webp",
    "/pandemon/public/img/global-menu/training-endurance.webp",
    "/pandemon/public/img/global-menu/training-magery.webp",
    "/pandemon/public/img/global-menu/training-meditation.webp",
    "/pandemon/public/img/global-menu/training-outdoor.webp",
    "/pandemon/public/img/global-menu/training-play.webp",
    "/pandemon/public/img/global-menu/training-speed.webp",

    // Questing
    "/pandemon/public/img/global-quest/face-bobo.webp",
    "/pandemon/public/img/global-quest/face-pupu.webp",
    "/pandemon/public/img/global-quest/quest1-unicorn.webp",
    "/pandemon/public/img/global-quest/quest2-pixie.webp",
    "/pandemon/public/img/global-quest/quest3-puzzlecave.webp",
    "/pandemon/public/img/global-quest/quest-bobo.webp",
    "/pandemon/public/img/global-quest/quest-default.webp",
    "/pandemon/public/img/global-quest/quest-pupu.webp",

    // Habitat
    "/pandemon/public/img/pet-habitat/habitat-alpine.webp",
    "/pandemon/public/img/pet-habitat/habitat-autumnal.webp",
    "/pandemon/public/img/pet-habitat/habitat-blossom.webp",
    "/pandemon/public/img/pet-habitat/habitat-cave.webp",
    "/pandemon/public/img/pet-habitat/habitat-coastal.webp",
    "/pandemon/public/img/pet-habitat/habitat-coral.webp",
    "/pandemon/public/img/pet-habitat/habitat-dessert.webp",
    "/pandemon/public/img/pet-habitat/habitat-glacier.webp",
    "/pandemon/public/img/pet-habitat/habitat-graveyard.webp",
    "/pandemon/public/img/pet-habitat/habitat-heaven.webp",
    "/pandemon/public/img/pet-habitat/habitat-hell.webp",
    "/pandemon/public/img/pet-habitat/habitat-meadow.webp",
    "/pandemon/public/img/pet-habitat/habitat-plain.webp",
    "/pandemon/public/img/pet-habitat/habitat-rainforest.webp",
    "/pandemon/public/img/pet-habitat/habitat-swamp.webp",
    "/pandemon/public/img/pet-habitat/habitat-tundra.webp",
    "/pandemon/public/img/pet-habitat/habitat-village.webp",
    "/pandemon/public/img/pet-habitat/habitat-volcano.webp",

    // Menu
    "/pandemon/public/img/pet-menu/petmenu-action.webp",
    "/pandemon/public/img/pet-menu/petmenu-action-active.webp",
    "/pandemon/public/img/pet-menu/petmenu-action-breeding.webp",
    "/pandemon/public/img/pet-menu/petmenu-action-healing.webp",
    "/pandemon/public/img/pet-menu/petmenu-action-vacation.webp",
    "/pandemon/public/img/pet-menu/petmenu-actionbtn-breeding.webp",
    "/pandemon/public/img/pet-menu/petmenu-actionbtn-healing.webp",
    "/pandemon/public/img/pet-menu/petmenu-actionbtn-vacation.webp",
    "/pandemon/public/img/pet-menu/petmenu-health.webp",
    "/pandemon/public/img/pet-menu/petmenu-health-active.webp",
    "/pandemon/public/img/pet-menu/petmenu-profile.webp",
    "/pandemon/public/img/pet-menu/petmenu-profile-active.webp",
    "/pandemon/public/img/pet-menu/petmenu-stats.webp",
    "/pandemon/public/img/pet-menu/petmenu-stats-active.webp",

    // portraits
    "/pandemon/public/img/pet-portrait/pet-air-1-avidra-face.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-avidra.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-gryphius-face.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-gryphius.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-valkyrix-face.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-valkyrix.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-windrifter-face.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-windrifter.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-zephyrus-face.webp",
    "/pandemon/public/img/pet-portrait/pet-air-1-zephyrus.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-frostfang-face.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-frostfang.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-icefudge-face.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-icefudge.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-muffin-face.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-muffin.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-tootsie-face.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-tootsie.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-whisk-face.webp",
    "/pandemon/public/img/pet-portrait/pet-cold-1-whisk.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-darkmaw-face.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-darkmaw.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-desolator-face.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-desolator.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-doomgloom-face.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-doomgloom.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-grimshade-face.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-grimshade.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-shadeprowler-face.webp",
    "/pandemon/public/img/pet-portrait/pet-darkness-1-shadeprowler.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-avenas-face.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-avenas.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-bellflower-face.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-bellflower.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-fir-face.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-fir.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-gravel-face.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-gravel.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-loam-face.webp",
    "/pandemon/public/img/pet-portrait/pet-earth-1-loam.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-cootie-face.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-cootie.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-dynamo-face.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-dynamo.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-flashbang-face.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-flashbang.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-jolteon-face.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-jolteon.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-voltara-face.webp",
    "/pandemon/public/img/pet-portrait/pet-electricity-1-voltara.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-ashen-face.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-ashen.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-burner-face.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-burner.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-flareon-face.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-flareon.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-ignite-face.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-ignite.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-knurl-face.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-1-knurl.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-2-valentine-face.webp",
    "/pandemon/public/img/pet-portrait/pet-fire-2-valentine.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-arabella-face.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-arabella.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-rosalind-face.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-rosalind.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-seraphina-face.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-seraphina.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-valentina-face.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-valentina.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-vivienne-face.webp",
    "/pandemon/public/img/pet-portrait/pet-light-1-vivienne.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-ferrous-face.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-ferrous.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-metalcore-face.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-metalcore.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-sapphire-face.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-sapphire.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-silt-face.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-silt.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-steelix-face.webp",
    "/pandemon/public/img/pet-portrait/pet-metal-1-steelix.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-bryony-face.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-bryony.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-leafsong-face.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-leafsong.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-lupine-face.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-lupine.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-sylph-face.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-sylph.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-thorn-face.webp",
    "/pandemon/public/img/pet-portrait/pet-plant-1-thorn.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-finley-face.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-finley.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-kelpie-face.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-kelpie.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-lily-face.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-lily.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-nixie-face.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-nixie.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-pearlina-face.webp",
    "/pandemon/public/img/pet-portrait/pet-water-1-pearlina.webp",

    // selector
    "/pandemon/public/img/pet-selector/pagination-downarrow.webp",
    "/pandemon/public/img/pet-selector/pagination-uparrow.webp",
    "/pandemon/public/img/pet-selector/petslot-active.webp",
    "/pandemon/public/img/pet-selector/petslot-inactive.webp",
    "/pandemon/public/img/pet-selector/selector-black.webp",
    "/pandemon/public/img/pet-selector/selector-blue.webp",
    "/pandemon/public/img/pet-selector/selector-brown.webp",
    "/pandemon/public/img/pet-selector/selector-green.webp",
    "/pandemon/public/img/pet-selector/selector-purple.webp",
    "/pandemon/public/img/pet-selector/selector-red.webp",
    "/pandemon/public/img/pet-selector/selector-silver.webp",
    "/pandemon/public/img/pet-selector/selector-skyblue.webp",
    "/pandemon/public/img/pet-selector/selector-white.webp",
    "/pandemon/public/img/pet-selector/selector-yellow.webp",
];






// Use the installation event to pre-cache all initial resources.
self.addEventListener('install', event => {
    event.waitUntil((async () => {
        const cache = await caches.open(CACHE_NAME);
        await cache.addAll(CACHE_BASE_URLS);
    })());
});

self.addEventListener('fetch', event => {
    event.respondWith((async () => {
        const cache = await caches.open(CACHE_NAME);

        // Get the resource from the cache.
        const cachedResponse = await cache.match(event.request);
        if (cachedResponse) {
            return cachedResponse;
        }
        else {
            try {
                // If the resource was not in the cache, try the network.
                const fetchResponse = await fetch(event.request);

                // Save the resource in the cache and return it.
                await cache.put(event.request, fetchResponse.clone());
                return fetchResponse;
            }
            catch (e) {
                // The network failed.
            }
        }
    })());
});