<?php

class Gemstone {
    /**
     * Get list of curated gemstone acquisitions
     * 
     * @return array
     */
    public static function getCuratedAcquisitions() {
        return [
            [
                'id' => 1,
                'title' => 'Ceylon Blue Sapphire',
                'origin' => 'Sri Lanka',
                'carats' => '8.12 ct',
                'cut' => 'Cushion Cut',
                'status' => 'UPON REQUEST',
                'image' => 'ceylon-blue-sapphire.jpg',
                'description' => 'Unheated, certified royal blue sapphire exhibiting flawless clarity and mesmerizing color saturation.',
                'price_tier' => 'Investment Grade'
            ],
            [
                'id' => 2,
                'title' => 'Padparadscha Sapphire',
                'origin' => 'Sri Lanka',
                'carats' => '5.24 ct',
                'cut' => 'Radiant Cut',
                'status' => 'PRIVATE SALE',
                'image' => 'padparadscha-sapphire.jpg',
                'description' => 'A magnificent blend of lotus blossom pink and sunset orange, possessing rare natural purity.',
                'price_tier' => 'Exclusive'
            ],
            [
                'id' => 3,
                'title' => 'Ratnapura Ruby',
                'origin' => 'Sri Lanka',
                'carats' => '4.85 ct',
                'cut' => 'Natural Rough / Polished',
                'status' => 'INQUIRE',
                'image' => 'ratnapura-ruby.jpg',
                'description' => 'A pristine pigeon blood ruby from the legendary mines of Ratnapura. Unrivaled fluorescence.',
                'price_tier' => 'Museum Specimen'
            ],
            [
                'id' => 4,
                'title' => 'Kashmir Velvet Sapphire',
                'origin' => 'Kashmir',
                'carats' => '10.50 ct',
                'cut' => 'Emerald Cut',
                'status' => 'RESERVED',
                'image' => 'kashmir-sapphire.jpg',
                'description' => 'Legendary cornflower blue velvet sapphire with historical provenance and GIA monograph.',
                'price_tier' => 'Heritage Collection'
            ],
            [
                'id' => 5,
                'title' => 'Muzo Emerald Flawless',
                'origin' => 'Colombia',
                'carats' => '7.35 ct',
                'cut' => 'Octagonal Step Cut',
                'status' => 'UPON REQUEST',
                'image' => 'muzo-emerald.jpg',
                'description' => 'An exceptionally clean Colombian emerald with vibrant bluish-green glow and no oil enhancement.',
                'price_tier' => 'Investment Grade'
            ],
            [
                'id' => 6,
                'title' => 'Golconda Type IIa Diamond',
                'origin' => 'Golconda, India',
                'carats' => '12.08 ct',
                'cut' => 'Antique Pear',
                'status' => 'PRIVATE SALE',
                'image' => 'golconda-diamond.jpg',
                'description' => 'Flawless D-color Type IIa diamond of historical importance, exhibiting the characteristic limpid transparency.',
                'price_tier' => 'Private Vault'
            ]
        ];
    }

    /**
     * Get a specific gemstone by ID
     * 
     * @param int $id
     * @return array
     */
    public static function getById($id) {
        $gems = self::getCuratedAcquisitions();
        foreach ($gems as $gem) {
            if ($gem['id'] == $id) {
                return $gem;
            }
        }
        return $gems[0];
    }
}
