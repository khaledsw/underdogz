<?php

add_action('init', 'of_options');

if (!function_exists('of_options')) {
    function of_options()
    {
        global $wp_registered_sidebars;
        $sidebar_options[] = 'None';
        $sidebars = $wp_registered_sidebars;// sidebar_generator::get_sidebars();
        //var_dump($sidebars);
        if (is_array($sidebars) && !empty($sidebars)) {
            foreach ($sidebars as $sidebar) {
                $sidebar_options[] = $sidebar['name'];
            }
        }

        //Access the WordPress Categories via an Array
        $of_categories = array();
        $of_categories_obj = get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
        }
        $categories_tmp = array_unshift($of_categories, "Select a category:");

        //Access the WordPress Pages via an Array
        $of_pages = array();
        $of_pages_obj = get_pages('sort_column=post_parent,menu_order');
        foreach ($of_pages_obj as $of_page) {
            $of_pages[$of_page->ID] = $of_page->post_name;
        }
        $of_pages_tmp = array_unshift($of_pages, "Select a page:");

        //Testing
        $of_options_select = array("one", "two", "three", "four", "five");
        $of_options_radio = array("one" => "One", "two" => "Two", "three" => "Three", "four" => "Four", "five" => "Five");

        //Sample Homepage blocks for the layout manager (sorter)
        $of_options_homepage_blocks = array
        (
            "disabled" => array(
                "placebo" => "placebo", //REQUIRED!
                "block_one" => "Block One",
                "block_two" => "Block Two",
                "block_three" => "Block Three",
            ),
            "enabled" => array(
                "placebo" => "placebo", //REQUIRED!
                "block_four" => "Block Four",
            ),
        );


        //Stylesheets Reader
        $alt_stylesheet_path = LAYOUT_PATH;
        $alt_stylesheets = array();

        if (is_dir($alt_stylesheet_path)) {
            if ($alt_stylesheet_dir = opendir($alt_stylesheet_path)) {
                while (($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false) {
                    if (stristr($alt_stylesheet_file, ".css") !== false) {
                        $alt_stylesheets[] = $alt_stylesheet_file;
                    }
                }
            }
        }


        //Background Images Reader
        $bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
        $bg_images_url = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
        $bg_images = array();

        if (is_dir($bg_images_path)) {
            if ($bg_images_dir = opendir($bg_images_path)) {
                while (($bg_images_file = readdir($bg_images_dir)) !== false) {
                    if (stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                        natsort($bg_images); //Sorts the array into a natural order
                        $bg_images[] = $bg_images_url . $bg_images_file;
                    }
                }
            }
        }


        /*-----------------------------------------------------------------------------------*/
        /* TO DO: Add options/functions that use these */
        /*-----------------------------------------------------------------------------------*/

        //More Options
        $uploads_arr = wp_upload_dir();
        $all_uploads_path = $uploads_arr['path'];
        $all_uploads = get_option('of_uploads');
        $other_entries = array("Select a number:", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19");
        $body_repeat = array("no-repeat", "repeat-x", "repeat-y", "repeat");
        $body_pos = array("top left", "top center", "top right", "center left", "center center", "center right", "bottom left", "bottom center", "bottom right");

        // Image Alignment radio box
        $of_options_thumb_align = array("alignleft" => "Left", "alignright" => "Right", "aligncenter" => "Center");

        // Image Links to Options
        $of_options_image_link_to = array("image" => "The Image", "post" => "The Post");

        $font_sizes = array(
			'' => 'Select size',
			'10' => '10',
			'11' => '11',
			'12' => '12',
			'13' => '13',
			'14' => '14',
			'15' => '15',
			'16' => '16',
			'17' => '17',
			'18' => '18',
			'19' => '19',
			'20' => '20',
			'21' => '21',
			'22' => '22',
			'23' => '23',
			'24' => '24',
			'25' => '25',
			'26' => '26',
			'27' => '27',
			'28' => '28',
			'29' => '29',
			'30' => '30',
			'31' => '31',
			'32' => '32',
			'33' => '33',
			'34' => '34',
			'35' => '35',
			'36' => '36',
			'37' => '37',
			'38' => '38',
			'39' => '39',
			'40' => '40',
			'41' => '41',
			'42' => '42',
			'43' => '43',
			'44' => '44',
			'45' => '45',
			'46' => '46',
			'47' => '47',
			'48' => '48',
			'49' => '49',
			'50' => '50',
		);

		$google_fonts = array(
			"" => "Select Font",
			"ABeeZee" => "ABeeZee",
			"Abel" => "Abel",
			"Abril Fatface" => "Abril Fatface",
			"Aclonica" => "Aclonica",
			"Acme" => "Acme",
			"Actor" => "Actor",
			"Adamina" => "Adamina",
			"Advent Pro" => "Advent Pro",
			"Aguafina Script" => "Aguafina Script",
			"Akronim" => "Akronim",
			"Aladin" => "Aladin",
			"Aldrich" => "Aldrich",
			"Alef" => "Alef",
			"Alegreya" => "Alegreya",
			"Alegreya SC" => "Alegreya SC",
			"Alegreya Sans" => "Alegreya Sans",
			"Alegreya Sans SC" => "Alegreya Sans SC",
			"Alex Brush" => "Alex Brush",
			"Alfa Slab One" => "Alfa Slab One",
			"Alice" => "Alice",
			"Alike" => "Alike",
			"Alike Angular" => "Alike Angular",
			"Allan" => "Allan",
			"Allerta" => "Allerta",
			"Allerta Stencil" => "Allerta Stencil",
			"Allura" => "Allura",
			"Almendra" => "Almendra",
			"Almendra Display" => "Almendra Display",
			"Almendra SC" => "Almendra SC",
			"Amarante" => "Amarante",
			"Amaranth" => "Amaranth",
			"Amatic SC" => "Amatic SC",
			"Amethysta" => "Amethysta",
			"Anaheim" => "Anaheim",
			"Andada" => "Andada",
			"Andika" => "Andika",
			"Angkor" => "Angkor",
			"Annie Use Your Telescope" => "Annie Use Your Telescope",
			"Anonymous Pro" => "Anonymous Pro",
			"Antic" => "Antic",
			"Antic Didone" => "Antic Didone",
			"Antic Slab" => "Antic Slab",
			"Anton" => "Anton",
			"Arapey" => "Arapey",
			"Arbutus" => "Arbutus",
			"Arbutus Slab" => "Arbutus Slab",
			"Architects Daughter" => "Architects Daughter",
			"Archivo Black" => "Archivo Black",
			"Archivo Narrow" => "Archivo Narrow",
			"Arimo" => "Arimo",
			"Arizonia" => "Arizonia",
			"Armata" => "Armata",
			"Artifika" => "Artifika",
			"Arvo" => "Arvo",
			"Asap" => "Asap",
			"Asset" => "Asset",
			"Astloch" => "Astloch",
			"Asul" => "Asul",
			"Atomic Age" => "Atomic Age",
			"Aubrey" => "Aubrey",
			"Audiowide" => "Audiowide",
			"Autour One" => "Autour One",
			"Average" => "Average",
			"Average Sans" => "Average Sans",
			"Averia Gruesa Libre" => "Averia Gruesa Libre",
			"Averia Libre" => "Averia Libre",
			"Averia Sans Libre" => "Averia Sans Libre",
			"Averia Serif Libre" => "Averia Serif Libre",
			"Bad Script" => "Bad Script",
			"Balthazar" => "Balthazar",
			"Bangers" => "Bangers",
			"Basic" => "Basic",
			"Battambang" => "Battambang",
			"Baumans" => "Baumans",
			"Bayon" => "Bayon",
			"Belgrano" => "Belgrano",
			"Belleza" => "Belleza",
			"BenchNine" => "BenchNine",
			"Bentham" => "Bentham",
			"Berkshire Swash" => "Berkshire Swash",
			"Bevan" => "Bevan",
			"Bigelow Rules" => "Bigelow Rules",
			"Bigshot One" => "Bigshot One",
			"Bilbo" => "Bilbo",
			"Bilbo Swash Caps" => "Bilbo Swash Caps",
			"Bitter" => "Bitter",
			"Black Ops One" => "Black Ops One",
			"Bokor" => "Bokor",
			"Bonbon" => "Bonbon",
			"Boogaloo" => "Boogaloo",
			"Bowlby One" => "Bowlby One",
			"Bowlby One SC" => "Bowlby One SC",
			"Brawler" => "Brawler",
			"Bree Serif" => "Bree Serif",
			"Bubblegum Sans" => "Bubblegum Sans",
			"Bubbler One" => "Bubbler One",
			"Buda" => "Buda",
			"Buenard" => "Buenard",
			"Butcherman" => "Butcherman",
			"Butterfly Kids" => "Butterfly Kids",
			"Cabin" => "Cabin",
			"Cabin Condensed" => "Cabin Condensed",
			"Cabin Sketch" => "Cabin Sketch",
			"Caesar Dressing" => "Caesar Dressing",
			"Cagliostro" => "Cagliostro",
			"Calligraffitti" => "Calligraffitti",
			"Cambo" => "Cambo",
			"Candal" => "Candal",
			"Cantarell" => "Cantarell",
			"Cantata One" => "Cantata One",
			"Cantora One" => "Cantora One",
			"Capriola" => "Capriola",
			"Cardo" => "Cardo",
			"Carme" => "Carme",
			"Carrois Gothic" => "Carrois Gothic",
			"Carrois Gothic SC" => "Carrois Gothic SC",
			"Carter One" => "Carter One",
			"Caudex" => "Caudex",
			"Cedarville Cursive" => "Cedarville Cursive",
			"Ceviche One" => "Ceviche One",
			"Changa One" => "Changa One",
			"Chango" => "Chango",
			"Chau Philomene One" => "Chau Philomene One",
			"Chela One" => "Chela One",
			"Chelsea Market" => "Chelsea Market",
			"Chenla" => "Chenla",
			"Cherry Cream Soda" => "Cherry Cream Soda",
			"Cherry Swash" => "Cherry Swash",
			"Chewy" => "Chewy",
			"Chicle" => "Chicle",
			"Chivo" => "Chivo",
			"Cinzel" => "Cinzel",
			"Cinzel Decorative" => "Cinzel Decorative",
			"Clicker Script" => "Clicker Script",
			"Coda" => "Coda",
			"Coda Caption" => "Coda Caption",
			"Codystar" => "Codystar",
			"Combo" => "Combo",
			"Comfortaa" => "Comfortaa",
			"Coming Soon" => "Coming Soon",
			"Concert One" => "Concert One",
			"Condiment" => "Condiment",
			"Content" => "Content",
			"Contrail One" => "Contrail One",
			"Convergence" => "Convergence",
			"Cookie" => "Cookie",
			"Copse" => "Copse",
			"Corben" => "Corben",
			"Courgette" => "Courgette",
			"Cousine" => "Cousine",
			"Coustard" => "Coustard",
			"Covered By Your Grace" => "Covered By Your Grace",
			"Crafty Girls" => "Crafty Girls",
			"Creepster" => "Creepster",
			"Crete Round" => "Crete Round",
			"Crimson Text" => "Crimson Text",
			"Croissant One" => "Croissant One",
			"Crushed" => "Crushed",
			"Cuprum" => "Cuprum",
			"Cutive" => "Cutive",
			"Cutive Mono" => "Cutive Mono",
			"Damion" => "Damion",
			"Dancing Script" => "Dancing Script",
			"Dangrek" => "Dangrek",
			"Dawning of a New Day" => "Dawning of a New Day",
			"Days One" => "Days One",
			"Delius" => "Delius",
			"Delius Swash Caps" => "Delius Swash Caps",
			"Delius Unicase" => "Delius Unicase",
			"Della Respira" => "Della Respira",
			"Denk One" => "Denk One",
			"Devonshire" => "Devonshire",
			"Didact Gothic" => "Didact Gothic",
			"Diplomata" => "Diplomata",
			"Diplomata SC" => "Diplomata SC",
			"Domine" => "Domine",
			"Donegal One" => "Donegal One",
			"Doppio One" => "Doppio One",
			"Dorsa" => "Dorsa",
			"Dosis" => "Dosis",
			"Dr Sugiyama" => "Dr Sugiyama",
			"Droid Sans" => "Droid Sans",
			"Droid Sans Mono" => "Droid Sans Mono",
			"Droid Serif" => "Droid Serif",
			"Duru Sans" => "Duru Sans",
			"Dynalight" => "Dynalight",
			"EB Garamond" => "EB Garamond",
			"Eagle Lake" => "Eagle Lake",
			"Eater" => "Eater",
			"Economica" => "Economica",
			"Electrolize" => "Electrolize",
			"Elsie" => "Elsie",
			"Elsie Swash Caps" => "Elsie Swash Caps",
			"Emblema One" => "Emblema One",
			"Emilys Candy" => "Emilys Candy",
			"Engagement" => "Engagement",
			"Englebert" => "Englebert",
			"Enriqueta" => "Enriqueta",
			"Erica One" => "Erica One",
			"Esteban" => "Esteban",
			"Euphoria Script" => "Euphoria Script",
			"Ewert" => "Ewert",
			"Exo" => "Exo",
			"Exo 2" => "Exo 2",
			"Expletus Sans" => "Expletus Sans",
			"Fanwood Text" => "Fanwood Text",
			"Fascinate" => "Fascinate",
			"Fascinate Inline" => "Fascinate Inline",
			"Faster One" => "Faster One",
			"Fasthand" => "Fasthand",
			"Fauna One" => "Fauna One",
			"Federant" => "Federant",
			"Federo" => "Federo",
			"Felipa" => "Felipa",
			"Fenix" => "Fenix",
			"Finger Paint" => "Finger Paint",
			"Fjalla One" => "Fjalla One",
			"Fjord One" => "Fjord One",
			"Flamenco" => "Flamenco",
			"Flavors" => "Flavors",
			"Fondamento" => "Fondamento",
			"Fontdiner Swanky" => "Fontdiner Swanky",
			"Forum" => "Forum",
			"Francois One" => "Francois One",
			"Freckle Face" => "Freckle Face",
			"Fredericka the Great" => "Fredericka the Great",
			"Fredoka One" => "Fredoka One",
			"Freehand" => "Freehand",
			"Fresca" => "Fresca",
			"Frijole" => "Frijole",
			"Fruktur" => "Fruktur",
			"Fugaz One" => "Fugaz One",
			"GFS Didot" => "GFS Didot",
			"GFS Neohellenic" => "GFS Neohellenic",
			"Gabriela" => "Gabriela",
			"Gafata" => "Gafata",
			"Galdeano" => "Galdeano",
			"Galindo" => "Galindo",
			"Gentium Basic" => "Gentium Basic",
			"Gentium Book Basic" => "Gentium Book Basic",
			"Geo" => "Geo",
			"Geostar" => "Geostar",
			"Geostar Fill" => "Geostar Fill",
			"Germania One" => "Germania One",
			"Gilda Display" => "Gilda Display",
			"Give You Glory" => "Give You Glory",
			"Glass Antiqua" => "Glass Antiqua",
			"Glegoo" => "Glegoo",
			"Gloria Hallelujah" => "Gloria Hallelujah",
			"Goblin One" => "Goblin One",
			"Gochi Hand" => "Gochi Hand",
			"Gorditas" => "Gorditas",
			"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
			"Graduate" => "Graduate",
			"Grand Hotel" => "Grand Hotel",
			"Gravitas One" => "Gravitas One",
			"Great Vibes" => "Great Vibes",
			"Griffy" => "Griffy",
			"Gruppo" => "Gruppo",
			"Gudea" => "Gudea",
			"Habibi" => "Habibi",
			"Hammersmith One" => "Hammersmith One",
			"Hanalei" => "Hanalei",
			"Hanalei Fill" => "Hanalei Fill",
			"Handlee" => "Handlee",
			"Hanuman" => "Hanuman",
			"Happy Monkey" => "Happy Monkey",
			"Headland One" => "Headland One",
			"Henny Penny" => "Henny Penny",
			"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
			"Holtwood One SC" => "Holtwood One SC",
			"Homemade Apple" => "Homemade Apple",
			"Homenaje" => "Homenaje",
			"IM Fell DW Pica" => "IM Fell DW Pica",
			"IM Fell DW Pica SC" => "IM Fell DW Pica SC",
			"IM Fell Double Pica" => "IM Fell Double Pica",
			"IM Fell Double Pica SC" => "IM Fell Double Pica SC",
			"IM Fell English" => "IM Fell English",
			"IM Fell English SC" => "IM Fell English SC",
			"IM Fell French Canon" => "IM Fell French Canon",
			"IM Fell French Canon SC" => "IM Fell French Canon SC",
			"IM Fell Great Primer" => "IM Fell Great Primer",
			"IM Fell Great Primer SC" => "IM Fell Great Primer SC",
			"Iceberg" => "Iceberg",
			"Iceland" => "Iceland",
			"Imprima" => "Imprima",
			"Inconsolata" => "Inconsolata",
			"Inder" => "Inder",
			"Indie Flower" => "Indie Flower",
			"Inika" => "Inika",
			"Irish Grover" => "Irish Grover",
			"Istok Web" => "Istok Web",
			"Italiana" => "Italiana",
			"Italianno" => "Italianno",
			"Jacques Francois" => "Jacques Francois",
			"Jacques Francois Shadow" => "Jacques Francois Shadow",
			"Jim Nightshade" => "Jim Nightshade",
			"Jockey One" => "Jockey One",
			"Jolly Lodger" => "Jolly Lodger",
			"Josefin Sans" => "Josefin Sans",
			"Josefin Slab" => "Josefin Slab",
			"Joti One" => "Joti One",
			"Judson" => "Judson",
			"Julee" => "Julee",
			"Julius Sans One" => "Julius Sans One",
			"Junge" => "Junge",
			"Jura" => "Jura",
			"Just Another Hand" => "Just Another Hand",
			"Just Me Again Down Here" => "Just Me Again Down Here",
			"Kameron" => "Kameron",
			"Kantumruy" => "Kantumruy",
			"Karla" => "Karla",
			"Kaushan Script" => "Kaushan Script",
			"Kavoon" => "Kavoon",
			"Kdam Thmor" => "Kdam Thmor",
			"Keania One" => "Keania One",
			"Kelly Slab" => "Kelly Slab",
			"Kenia" => "Kenia",
			"Khmer" => "Khmer",
			"Kite One" => "Kite One",
			"Knewave" => "Knewave",
			"Kotta One" => "Kotta One",
			"Koulen" => "Koulen",
			"Kranky" => "Kranky",
			"Kreon" => "Kreon",
			"Kristi" => "Kristi",
			"Krona One" => "Krona One",
			"La Belle Aurore" => "La Belle Aurore",
			"Lancelot" => "Lancelot",
			"Lato" => "Lato",
			"League Script" => "League Script",
			"Leckerli One" => "Leckerli One",
			"Ledger" => "Ledger",
			"Lekton" => "Lekton",
			"Lemon" => "Lemon",
			"Libre Baskerville" => "Libre Baskerville",
			"Life Savers" => "Life Savers",
			"Lilita One" => "Lilita One",
			"Lily Script One" => "Lily Script One",
			"Limelight" => "Limelight",
			"Linden Hill" => "Linden Hill",
			"Lobster" => "Lobster",
			"Lobster Two" => "Lobster Two",
			"Londrina Outline" => "Londrina Outline",
			"Londrina Shadow" => "Londrina Shadow",
			"Londrina Sketch" => "Londrina Sketch",
			"Londrina Solid" => "Londrina Solid",
			"Lora" => "Lora",
			"Love Ya Like A Sister" => "Love Ya Like A Sister",
			"Loved by the King" => "Loved by the King",
			"Lovers Quarrel" => "Lovers Quarrel",
			"Luckiest Guy" => "Luckiest Guy",
			"Lusitana" => "Lusitana",
			"Lustria" => "Lustria",
			"Macondo" => "Macondo",
			"Macondo Swash Caps" => "Macondo Swash Caps",
			"Magra" => "Magra",
			"Maiden Orange" => "Maiden Orange",
			"Mako" => "Mako",
			"Marcellus" => "Marcellus",
			"Marcellus SC" => "Marcellus SC",
			"Marck Script" => "Marck Script",
			"Margarine" => "Margarine",
			"Marko One" => "Marko One",
			"Marmelad" => "Marmelad",
			"Marvel" => "Marvel",
			"Mate" => "Mate",
			"Mate SC" => "Mate SC",
			"Maven Pro" => "Maven Pro",
			"McLaren" => "McLaren",
			"Meddon" => "Meddon",
			"MedievalSharp" => "MedievalSharp",
			"Medula One" => "Medula One",
			"Megrim" => "Megrim",
			"Meie Script" => "Meie Script",
			"Merienda" => "Merienda",
			"Merienda One" => "Merienda One",
			"Merriweather" => "Merriweather",
			"Merriweather Sans" => "Merriweather Sans",
			"Metal" => "Metal",
			"Metal Mania" => "Metal Mania",
			"Metamorphous" => "Metamorphous",
			"Metrophobic" => "Metrophobic",
			"Michroma" => "Michroma",
			"Milonga" => "Milonga",
			"Miltonian" => "Miltonian",
			"Miltonian Tattoo" => "Miltonian Tattoo",
			"Miniver" => "Miniver",
			"Miss Fajardose" => "Miss Fajardose",
			"Modern Antiqua" => "Modern Antiqua",
			"Molengo" => "Molengo",
			"Molle" => "Molle",
			"Monda" => "Monda",
			"Monofett" => "Monofett",
			"Monoton" => "Monoton",
			"Monsieur La Doulaise" => "Monsieur La Doulaise",
			"Montaga" => "Montaga",
			"Montez" => "Montez",
			"Montserrat" => "Montserrat",
			"Montserrat Alternates" => "Montserrat Alternates",
			"Montserrat Subrayada" => "Montserrat Subrayada",
			"Moul" => "Moul",
			"Moulpali" => "Moulpali",
			"Mountains of Christmas" => "Mountains of Christmas",
			"Mouse Memoirs" => "Mouse Memoirs",
			"Mr Bedfort" => "Mr Bedfort",
			"Mr Dafoe" => "Mr Dafoe",
			"Mr De Haviland" => "Mr De Haviland",
			"Mrs Saint Delafield" => "Mrs Saint Delafield",
			"Mrs Sheppards" => "Mrs Sheppards",
			"Muli" => "Muli",
			"Mystery Quest" => "Mystery Quest",
			"Neucha" => "Neucha",
			"Neuton" => "Neuton",
			"New Rocker" => "New Rocker",
			"News Cycle" => "News Cycle",
			"Niconne" => "Niconne",
			"Nixie One" => "Nixie One",
			"Nobile" => "Nobile",
			"Nokora" => "Nokora",
			"Norican" => "Norican",
			"Nosifer" => "Nosifer",
			"Nothing You Could Do" => "Nothing You Could Do",
			"Noticia Text" => "Noticia Text",
			"Noto Sans" => "Noto Sans",
			"Noto Serif" => "Noto Serif",
			"Nova Cut" => "Nova Cut",
			"Nova Flat" => "Nova Flat",
			"Nova Mono" => "Nova Mono",
			"Nova Oval" => "Nova Oval",
			"Nova Round" => "Nova Round",
			"Nova Script" => "Nova Script",
			"Nova Slim" => "Nova Slim",
			"Nova Square" => "Nova Square",
			"Numans" => "Numans",
			"Nunito" => "Nunito",
			"Odor Mean Chey" => "Odor Mean Chey",
			"Offside" => "Offside",
			"Old Standard TT" => "Old Standard TT",
			"Oldenburg" => "Oldenburg",
			"Oleo Script" => "Oleo Script",
			"Oleo Script Swash Caps" => "Oleo Script Swash Caps",
			"Open Sans" => "Open Sans",
			"Open Sans Condensed" => "Open Sans Condensed",
			"Oranienbaum" => "Oranienbaum",
			"Orbitron" => "Orbitron",
			"Oregano" => "Oregano",
			"Orienta" => "Orienta",
			"Original Surfer" => "Original Surfer",
			"Oswald" => "Oswald",
			"Over the Rainbow" => "Over the Rainbow",
			"Overlock" => "Overlock",
			"Overlock SC" => "Overlock SC",
			"Ovo" => "Ovo",
			"Oxygen" => "Oxygen",
			"Oxygen Mono" => "Oxygen Mono",
			"PT Mono" => "PT Mono",
			"PT Sans" => "PT Sans",
			"PT Sans Caption" => "PT Sans Caption",
			"PT Sans Narrow" => "PT Sans Narrow",
			"PT Serif" => "PT Serif",
			"PT Serif Caption" => "PT Serif Caption",
			"Pacifico" => "Pacifico",
			"Paprika" => "Paprika",
			"Parisienne" => "Parisienne",
			"Passero One" => "Passero One",
			"Passion One" => "Passion One",
			"Pathway Gothic One" => "Pathway Gothic One",
			"Patrick Hand" => "Patrick Hand",
			"Patrick Hand SC" => "Patrick Hand SC",
			"Patua One" => "Patua One",
			"Paytone One" => "Paytone One",
			"Peralta" => "Peralta",
			"Permanent Marker" => "Permanent Marker",
			"Petit Formal Script" => "Petit Formal Script",
			"Petrona" => "Petrona",
			"Philosopher" => "Philosopher",
			"Piedra" => "Piedra",
			"Pinyon Script" => "Pinyon Script",
			"Pirata One" => "Pirata One",
			"Plaster" => "Plaster",
			"Play" => "Play",
			"Playball" => "Playball",
			"Playfair Display" => "Playfair Display",
			"Playfair Display SC" => "Playfair Display SC",
			"Podkova" => "Podkova",
			"Poiret One" => "Poiret One",
			"Poller One" => "Poller One",
			"Poly" => "Poly",
			"Pompiere" => "Pompiere",
			"Pontano Sans" => "Pontano Sans",
			"Port Lligat Sans" => "Port Lligat Sans",
			"Port Lligat Slab" => "Port Lligat Slab",
			"Prata" => "Prata",
			"Preahvihear" => "Preahvihear",
			"Press Start 2P" => "Press Start 2P",
			"Princess Sofia" => "Princess Sofia",
			"Prociono" => "Prociono",
			"Prosto One" => "Prosto One",
			"Puritan" => "Puritan",
			"Purple Purse" => "Purple Purse",
			"Quando" => "Quando",
			"Quantico" => "Quantico",
			"Quattrocento" => "Quattrocento",
			"Quattrocento Sans" => "Quattrocento Sans",
			"Questrial" => "Questrial",
			"Quicksand" => "Quicksand",
			"Quintessential" => "Quintessential",
			"Qwigley" => "Qwigley",
			"Racing Sans One" => "Racing Sans One",
			"Radley" => "Radley",
			"Raleway" => "Raleway",
			"Raleway Dots" => "Raleway Dots",
			"Rambla" => "Rambla",
			"Rammetto One" => "Rammetto One",
			"Ranchers" => "Ranchers",
			"Rancho" => "Rancho",
			"Rationale" => "Rationale",
			"Redressed" => "Redressed",
			"Reenie Beanie" => "Reenie Beanie",
			"Revalia" => "Revalia",
			"Ribeye" => "Ribeye",
			"Ribeye Marrow" => "Ribeye Marrow",
			"Righteous" => "Righteous",
			"Risque" => "Risque",
			"Roboto" => "Roboto",
			"Roboto Condensed" => "Roboto Condensed",
			"Roboto Slab" => "Roboto Slab",
			"Rochester" => "Rochester",
			"Rock Salt" => "Rock Salt",
			"Rokkitt" => "Rokkitt",
			"Romanesco" => "Romanesco",
			"Ropa Sans" => "Ropa Sans",
			"Rosario" => "Rosario",
			"Rosarivo" => "Rosarivo",
			"Rouge Script" => "Rouge Script",
			"Rubik Mono One" => "Rubik Mono One",
			"Rubik One" => "Rubik One",
			"Ruda" => "Ruda",
			"Rufina" => "Rufina",
			"Ruge Boogie" => "Ruge Boogie",
			"Ruluko" => "Ruluko",
			"Rum Raisin" => "Rum Raisin",
			"Ruslan Display" => "Ruslan Display",
			"Russo One" => "Russo One",
			"Ruthie" => "Ruthie",
			"Rye" => "Rye",
			"Sacramento" => "Sacramento",
			"Sail" => "Sail",
			"Salsa" => "Salsa",
			"Sanchez" => "Sanchez",
			"Sancreek" => "Sancreek",
			"Sansita One" => "Sansita One",
			"Sarina" => "Sarina",
			"Satisfy" => "Satisfy",
			"Scada" => "Scada",
			"Schoolbell" => "Schoolbell",
			"Seaweed Script" => "Seaweed Script",
			"Sevillana" => "Sevillana",
			"Seymour One" => "Seymour One",
			"Shadows Into Light" => "Shadows Into Light",
			"Shadows Into Light Two" => "Shadows Into Light Two",
			"Shanti" => "Shanti",
			"Share" => "Share",
			"Share Tech" => "Share Tech",
			"Share Tech Mono" => "Share Tech Mono",
			"Shojumaru" => "Shojumaru",
			"Short Stack" => "Short Stack",
			"Siemreap" => "Siemreap",
			"Sigmar One" => "Sigmar One",
			"Signika" => "Signika",
			"Signika Negative" => "Signika Negative",
			"Simonetta" => "Simonetta",
			"Sintony" => "Sintony",
			"Sirin Stencil" => "Sirin Stencil",
			"Six Caps" => "Six Caps",
			"Skranji" => "Skranji",
			"Slackey" => "Slackey",
			"Smokum" => "Smokum",
			"Smythe" => "Smythe",
			"Sniglet" => "Sniglet",
			"Snippet" => "Snippet",
			"Snowburst One" => "Snowburst One",
			"Sofadi One" => "Sofadi One",
			"Sofia" => "Sofia",
			"Sonsie One" => "Sonsie One",
			"Sorts Mill Goudy" => "Sorts Mill Goudy",
			"Source Code Pro" => "Source Code Pro",
			"Source Sans Pro" => "Source Sans Pro",
			"Special Elite" => "Special Elite",
			"Spicy Rice" => "Spicy Rice",
			"Spinnaker" => "Spinnaker",
			"Spirax" => "Spirax",
			"Squada One" => "Squada One",
			"Stalemate" => "Stalemate",
			"Stalinist One" => "Stalinist One",
			"Stardos Stencil" => "Stardos Stencil",
			"Stint Ultra Condensed" => "Stint Ultra Condensed",
			"Stint Ultra Expanded" => "Stint Ultra Expanded",
			"Stoke" => "Stoke",
			"Strait" => "Strait",
			"Sue Ellen Francisco" => "Sue Ellen Francisco",
			"Sunshiney" => "Sunshiney",
			"Supermercado One" => "Supermercado One",
			"Suwannaphum" => "Suwannaphum",
			"Swanky and Moo Moo" => "Swanky and Moo Moo",
			"Syncopate" => "Syncopate",
			"Tangerine" => "Tangerine",
			"Taprom" => "Taprom",
			"Tauri" => "Tauri",
			"Telex" => "Telex",
			"Tenor Sans" => "Tenor Sans",
			"Text Me One" => "Text Me One",
			"The Girl Next Door" => "The Girl Next Door",
			"Tienne" => "Tienne",
			"Tinos" => "Tinos",
			"Titan One" => "Titan One",
			"Titillium Web" => "Titillium Web",
			"Trade Winds" => "Trade Winds",
			"Trocchi" => "Trocchi",
			"Trochut" => "Trochut",
			"Trykker" => "Trykker",
			"Tulpen One" => "Tulpen One",
			"Ubuntu" => "Ubuntu",
			"Ubuntu Condensed" => "Ubuntu Condensed",
			"Ubuntu Mono" => "Ubuntu Mono",
			"Ultra" => "Ultra",
			"Uncial Antiqua" => "Uncial Antiqua",
			"Underdog" => "Underdog",
			"Unica One" => "Unica One",
			"UnifrakturCook" => "UnifrakturCook",
			"UnifrakturMaguntia" => "UnifrakturMaguntia",
			"Unkempt" => "Unkempt",
			"Unlock" => "Unlock",
			"Unna" => "Unna",
			"VT323" => "VT323",
			"Vampiro One" => "Vampiro One",
			"Varela" => "Varela",
			"Varela Round" => "Varela Round",
			"Vast Shadow" => "Vast Shadow",
			"Vibur" => "Vibur",
			"Vidaloka" => "Vidaloka",
			"Viga" => "Viga",
			"Voces" => "Voces",
			"Volkhov" => "Volkhov",
			"Vollkorn" => "Vollkorn",
			"Voltaire" => "Voltaire",
			"Waiting for the Sunrise" => "Waiting for the Sunrise",
			"Wallpoet" => "Wallpoet",
			"Walter Turncoat" => "Walter Turncoat",
			"Warnes" => "Warnes",
			"Wellfleet" => "Wellfleet",
			"Wendy One" => "Wendy One",
			"Wire One" => "Wire One",
			"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
			"Yellowtail" => "Yellowtail",
			"Yeseva One" => "Yeseva One",
			"Yesteryear" => "Yesteryear",
			"Zeyada" => "Zeyada",
		);
        /*-----------------------------------------------------------------------------------*/
        /* The Options Array */
        /*-----------------------------------------------------------------------------------*/

// Set the Options Array
        global $of_options;
        $of_options = array();

// GENERAL SETTING
        $of_options[] = array("name" => "General setting",
            "type" => "heading"
        );


        $of_options[] = array("name" => "Favicon",
            "desc" => "You can put the url of an ico image that will represent your website's favicon (16px x 16px).",
            "id" => "favicon",
            "std" => "",
            "type" => "upload");
			$of_options[] = array("name" => "Retina support:",
            "desc" => "Each time an image is uploaded, a higher quality version is created and stored with @2x added to the filename in the media upload folder. These @2x images will be loaded with high-resolution screens.",
            "id" => "retina_support",
            "std" => 0,
            "type" => "checkbox");

		$of_options[] = array("name" => "Typography",
            "desc" => "",
            "id" => "typography",
            "std" => "<h3>Typography</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
		$of_options[] = array( "name" => __("Select Body Font Family", "gmswebdesign"),
			"desc" => __("Select a font family for body text", "gmswebdesign"),
			"id" => "gf_body",
			"std" => "Montserrat",
			"type" => "select",
			"options" => $google_fonts);
        $of_options[] = array( "name" => __("Select Menu Font", "gmswebdesign"),
			"desc" => __("Select a font family for navigation", "gmswebdesign"),
			"id" => "gf_nav",
			"std" => "",
			"type" => "select",
			"options" => $google_fonts);	
		$of_options[] = array( "name" => __("Select Headings Font", "gmswebdesign"),
			"desc" => __("Select a font family for headings", "gmswebdesign"),
			"id" => "f_headings",
			"std" => "",
			"type" => "select",
			"options" => $google_fonts);
		$of_options[] = array( "name" => __("Google Font Settings", "gmswebdesign"),
			"desc" => __("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load.", "gmswebdesign"),
			"id" => "gf_settings",
			"std" => "400,700",
			"type" => "text");
		$of_options[] = array( "name" => __("Default Font Size", "gmswebdesign"),
			"desc" => __("In pixels, default is 12", "gmswebdesign"),
			"id" => "f_size",
			"std" => "12",
			"type" => "select",
			"options" => $font_sizes);
		$of_options[] = array( "name" => __("Default Font Line Height", "gmswebdesign"),
			"desc" => __("In pixels, default is 24", "gmswebdesign"),
			"id" => "f_lineheight",
			"std" => "24",
			"type" => "select",
			"options" => $font_sizes);			
        $of_options[] = array(
            "position" => "end",
            "type" => "accordion");			
			
		$of_options[] = array("name" => "Layout",
            "type" => "heading"
        );


			
		$of_options[] = array("name" => "Show page heading",
            "desc" => "Check this box to show or hide page heading",
            "id" => "show_page_heading",
            "std" => 1,
            "type" => "checkbox");
		$of_options[] = array("name" => "Breadcrumbs Enable:",
            "desc" => "Check to display the breadcrumbs in general. Uncheck to hide them.",
            "id" => "breadcrumb",
            "std" => 1,
            "type" => "checkbox");
			
		$of_options[] = array("name" => "Sidebar Position",
            "desc" => "Select slide bar position",
            "id" => "sidebar_position",
            "std" => "right",
            "type" => "select",
            "options" => array(
                'none' => 'Without Sidebar',
                'right' => 'Right',
                'left' => 'Left',
                'bottom' => 'Bottom'
            ));
			
		
        $of_options[] = array("name" => "Layout",
            "desc" => "Select boxed or wide layout.",
            "id" => "body_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                'boxed' => 'Boxed',
                'wide' => 'Wide',
            ));

        $of_options[] = array("name" => "Boxed Mode Only",
            "desc" => "",
            "id" => "boxed_mode_only",
            "std" => "<h3>Page Background options (Only work in boxed mode)</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $of_options[] = array("name" => "Background Image For Outer Areas In Boxed Mode",
            "desc" => "Please choose an image or insert an image url to use for the background.",
            "id" => "bg_image",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $of_options[] = array("name" => "Full Background Image",
            "desc" => "Check this box to have the background image display at 100% in width and height and scale according to the browser size.",
            "id" => "bg_full",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => "Background Repeat",
            "desc" => "Choose how the background image repeats.",
            "id" => "bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

        $of_options[] = array("name" => "Background Color",
            "desc" => "Select a background color.",
            "id" => "bg_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array(
            "position" => "end",
            "type" => "accordion");	
		
        // COLOR PRESETS
        $of_options[] = array("name" => "Color presets",
            "type" => "heading"
        );

        $of_options[] = array("name" => "Primary Color",
            "desc" => "Controls several items, ex: link hovers, highlights, and more.",
            "id" => "primary_color",
            "std" => "#ec3642",
            "type" => "color");
		$of_options[] = array("name" => "Theme style",
            "id" => "theme_style",
            "std" => "dark",
            "type" => "select",
            "options" => array(
                'dark' => 'Dark',
                'light' => 'Light'
            ));
		
        $of_options[] = array("name" => "Color Scheme",
            "desc" => "",
            "id" => "color_scheme_bg",
            "std" => "<h3>Background Colors</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $of_options[] = array("name" => "Header Background Color",
            "desc" => "Select a color for the header background.",
            "id" => "header_bg_color",
            "std" => "",
            "type" => "color");
        $of_options[] = array("name" => "Header Top Background Color",
            "desc" => "Controls the background color of the top header section used in Header style 2.",
            "id" => "header_top_bg_color",
            "std" => "",
            "type" => "color");
        $of_options[] = array("name" => "Header Border Color",
            "desc" => "Select a color for the header border.",
            "id" => "header_bd_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Content Background Color",
            "desc" => "Controls the background color of the main content area.",
            "id" => "content_bg_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Footer Background Color",
            "desc" => "Select a color for the footer background.",
            "id" => "footer_bg_color",
            "std" => "",
            "type" => "color");
        $of_options[] = array("name" => "Footer Border Color",
            "desc" => "Select a color for the footer border.",
            "id" => "footer_border_color",
            "std" => "",
            "type" => "color");
        $of_options[] = array("name" => "Footer Back-to-top Background",
            "desc" => "Select a color for the Back-to-top Background.",
            "id" => "footer_bg_btt",
            "std" => "",
            "type" => "color");


        $of_options[] = array(
            "position" => "end",
            "type" => "accordion");
        $of_options[] = array("name" => "Color Scheme",
            "desc" => "",
            "id" => "color_scheme_font",
            "std" => "<h3>Font Colors</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $of_options[] = array("name" => "Body Text Color",
            "desc" => "Controls the text color of body font.",
            "id" => "body_text_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Link Color",
            "desc" => "Controls the color of all text links as well as the '>' in certain areas.",
            "id" => "link_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Header Font Color",
            "desc" => "Controls the text color of the header font.",
            "id" => "header_text_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Header Link Color",
            "desc" => "Controls the text color of the header link font.",
            "id" => "header_link_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Page Title Font Color",
            "desc" => "Controls the text color of the page title font.",
            "id" => "page_title_color",
            "std" => "",
            "type" => "color");
        $of_options[] = array("name" => "Breadcrumbs Text Color",
            "desc" => "Controls the text color of the breadcrumb font.",
            "id" => "breadcrumbs_text_color",
            "std" => "",
            "type" => "color");
        $of_options[] = array("name" => "Breadcrumbs Link Color",
            "desc" => "Controls the link color of the breadcrumb font.",
            "id" => "breadcrumbs_link_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Blockquote Color",
            "desc" => "Controls the color of blockquote.",
            "id" => "blockquote_color",
            "std" => "",
            "type" => "color");

        $of_options[] = array("name" => "Footer Headings Color",
            "desc" => "Controls the text color of the footer heading font.",
            "id" => "footer_headings_color",
            "std" => "#dcdcdc",
            "type" => "color");

        $of_options[] = array("name" => "Footer Font Color",
            "desc" => "Controls the text color of the footer font.",
            "id" => "footer_text_color",
            "std" => "#989898",
            "type" => "color");

        $of_options[] = array("name" => "Footer Link Color",
            "desc" => "Controls the text color of the footer link font.",
            "id" => "footer_link_color",
            "std" => "#989898",
            "type" => "color");

        $of_options[] = array("name" => "Button Text Color",
            "desc" => "Controls the text color of buttons.",
            "id" => "button_text_color",
            "std" => "#ffffff",
            "type" => "color");
        $of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        //HEADER OPTIONS
        $of_options[] = array("name" => "Header Options",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Header Info",
            "desc" => "",
            "id" => "header_info_content_options",
            "std" => "<h3>Header Content Options</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $of_options[] = array("name" => "Select a Header Layout",
            "desc" => "",
            "id" => "header_layout",
            "std" => "",
            "type" => "images",
            "options" => array(
                "" => get_template_directory_uri() . "/headers/previews/default.jpg",
                "v1" => get_template_directory_uri() . "/headers/previews/v1.jpg",
                "v2" => get_template_directory_uri() . "/headers/previews/v2.jpg",
                "v3" => get_template_directory_uri() . "/headers/previews/v3.jpg",
                "v4" => get_template_directory_uri() . "/headers/previews/v4.jpg"
            ));
        $of_options[] = array("name" => "Sticky Header",
            "desc" => "Check to enable a fixed header when scrolling, uncheck to disable.",
            "id" => "header_sticky",
            "std" => '1',
            "type" => "checkbox");

        $of_options[] = array("name" => "Show quick access",
            "desc" => "Check to show quick access icons",
            "id" => "show_quick_access",
            "std" => '1',
            "type" => "checkbox");

        $of_options[] = array("name" => "Background Image For Header Area",
            "desc" => "Please choose an image or insert an image url to use for the header background.",
            "id" => "header_bg_image",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $of_options[] = array("name" => "100% Background Image",
            "desc" => "Check this box to have the header background image display at 100% in width and height and scale according to the browser size.",
            "id" => "header_bg_full",
            "std" => '',
            "type" => "checkbox");


        $of_options[] = array("name" => "Background Repeat",
            "desc" => "Choose how the background image repeats.",
            "id" => "header_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

        $of_options[] = array("name" => "Contact Info",
            "desc" => "Text will display in the Contact Info section of your top header v2.",
            "id" => "contactinfo",
            "std" => "Room 1214  #187 Tay Son Building, Dong Da Distr Ha Noi, Vietnam \nCall us:  (0123) 456 7893",
            "type" => "textarea");


        $of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        $of_options[] = array("name" => "Header Info",
            "desc" => "",
            "id" => "header_info_logo_options",
            "std" => "<h3>Logo Options</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $of_options[] = array("name" => "Logo",
            "desc" => "Please choose an image file for your logo.",
            "id" => "logo",
            "std" => get_template_directory_uri() . "/images/logo.png",
            "mod" => "",
            "type" => "media");

        $of_options[] = array("name" => "Store Logo",
            "desc" => "Please choose an image file for your logo in Store page.",
            "id" => "store-logo",
            "std" => get_template_directory_uri()  . "/images/logo-store.png",
            "mod" => "",
            "type" => "media");
		$of_options[] = array("name" => "Logo margin",
            "desc" => "Default values is '30px 10px'",
            "id" => "logo_margin",
            "std" => "",
            "type" => "text");
        $of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        $of_options[] = array("name" => "Header Info",
            "desc" => "",
            "id" => "header_info_page_title_options",
            "std" => "<h3>Page Title Bar Options</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $of_options[] = array("name" => "Page Title Bar Height",
            "desc" => "In pixels, ex: 10px",
            "id" => "page_title_height",
            "std" => "194px",
            "type" => "text");

        $of_options[] = array("name" => "Page Title Bar Background",
            "desc" => "Please choose an image or insert an image url to use for the page title bar background.",
            "id" => "page_title_bg",
            "std" => '',
            "mod" => "",
            "type" => "media");

        $of_options[] = array("name" => "Full Background Image",
            "desc" => "Check this box to have the page title bar background image display at 100% in width and height and scale according to the browser size.",
            "id" => "page_title_bg_full",
            "std" => 0,
            "type" => "checkbox");
        $of_options[] = array("name" => "Background Repeat",
            "desc" => "Choose how the background image repeats.",
            "id" => "page_title_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

        $of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        // FOOTER OPTIONS
        $of_options[] = array("name" => "Footer options",
            "type" => "heading"
        );
		$of_options[] = array("name" => "Footer style",
            "desc" => "Select the layout for footer area.",
            "id" => "footer_option",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                '' => 'Default',
                'footer-2' => 'Footer Store'
            ));
	
        $of_options[] = array("name" => "Footer Widgets",
            "desc" => "Check the box to display footer widgets.",
            "id" => "footer_widgets",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Background Image For Footer Area",
            "desc" => "Please choose an image or insert an image url to use for the footer widget area background.",
            "id" => "footer_bg_image",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $of_options[] = array("name" => "Full Background Image",
            "desc" => "Check this box to have the footer background image display at 100% in width and height and scale according to the browser size.",
            "id" => "footer_bg_full",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => "Background Repeat",
            "desc" => "Choose how the background image repeats.",
            "id" => "footer_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

        $of_options[] = array("name" => "Back to top button",
            "desc" => "Select the checkbox to display Back to top button",
            "id" => "backtotop-button",
            "std" => 1,
            "type" => "checkbox");

// SHOP OPTIONS
        $of_options[] = array("name" => "Shop options",
            "type" => "heading");

        $of_options[] = array("name" => "Show Woocommerce Cart Icon in Top Navigation",
            "desc" => "Check the box to show the Cart icon & Cart widget, uncheck to disable.",
            "id" => "woocommerce_cart_top_nav",
            "std" => 1,
            "type" => "checkbox");
        $of_options[] = array("name" => "Show Quick View Button",
            "desc" => "Check the box to show the quick view button on product image.",
            "id" => "woocommerce_quickview",
            "std" => 1,
            "type" => "checkbox");
        $of_options[] = array("name" => "Quick View Effect",
            "desc" => "Select effect of the quick view box.",
            "id" => "woocommerce_quickview_effect",
            "std" => 'fadein',
            "type" => "select",
            "options" => array(
                'fadein' => 'Fadein',
                'slide' => 'Slide',
                'newspaper' => 'Newspaper',
                'fall' => 'Fall',
                'sidefall' => 'Side Fall',
                'blur' => 'Blur',
                'flip' => 'Flip',
                'sign' => 'Sign',
                'superscaled' => 'Super Scaled',
                'slit' => 'Slit',
                'rotate' => 'Rotate',
                'letmein' => 'Letmein',
                'makeway' => 'Makeway',
                'slip' => 'Slip'
            ));
        $of_options[] = array("name" => "Product Listing Layout",
            "desc" => "Select the layout for product listing page. Please logout to clean the old session",
            "id" => "product_listing_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                'grid' => 'Grid',
                'row' => 'Row'
            ));
		 $of_options[] = array("name" => "Troubleshooting",
            "desc" => "Woocommerce jquery cookie fix<br> Read more: <a href='http://docs.woothemes.com/document/jquery-cookie-fails-to-load/'>jquery-cookie-fails-to-load</a>",
            "id" => "fix_woo_jquerycookie",
            "std" => 0,
            "type" => "checkbox");
		
        $of_options[] = array("name" => "Blog",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Blog Listing",
            "desc" => "",
            "id" => "blog_single_post",
            "std" => "<h3>Blog Listing</h3>",
            "icon" => true,
            "type" => "info");
        $of_options[] = array("name" => "Show Author Info Box",
            "desc" => "Check the box to display the author info box in each post.",
            "id" => "author_info_listing",
            "std" => 1,
            "type" => "checkbox");
        $of_options[] = array("name" => "Post Category Title",
            "desc" => "Check the box to display the post category title in each post.",
            "id" => "blog_category_title_listing",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Blog Single Post",
            "desc" => "",
            "id" => "blog_single_post",
            "std" => "<h3>Blog Single Post</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $of_options[] = array("name" => "Featured Image on Single Post Page",
            "desc" => "Check the box to display featured images on single post pages.",
            "id" => "featured_images_single",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Post Title",
            "desc" => "Check the box to display the post title that goes below the featured images.",
            "id" => "blog_post_title",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Post Category Title",
            "desc" => "Check the box to display the post category title that goes below the featured images.",
            "id" => "blog_category_title",
            "std" => 1,
            "type" => "checkbox");
		
		$of_options[] = array("name" => "Post Created Date",
            "desc" => "Check the box to display the post created date that goes below the title.",
            "id" => "blog_show_date",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => "Tag Cloud",
            "desc" => "Check the box to display the tag cloud box.",
            "id" => "post_tags",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Author Info Box",
            "desc" => "Check the box to display the author info box below posts.",
            "id" => "author_info",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Related Posts",
            "desc" => "Check the box to display related posts.",
            "id" => "related_posts",
            "std" => 1,
            "type" => "checkbox");
        $of_options[] = array("name" => "Social Sharing Box",
            "desc" => "Check the box to display the social sharing box.",
            "id" => "social_sharing_box",
            "std" => 1,
            "type" => "checkbox");
/*
        $of_options[] = array("name" => "Social Link",
            "desc" => "",
            "id" => "social_link",
            "std" => "<h3>Social Link</h3>",
            "icon" => false,
            "type" => "info");

        $of_options[] = array("name" => "Facebook",
            "desc" => "Enter your Facebook link.",
            "id" => "facebook_link",
            "std" => "https://facebook.com/balloonthemes",
            "type" => "text");

        $of_options[] = array("name" => "Twitter",
            "desc" => "Enter your Twitter link.",
            "id" => "twitter_link",
            "std" => "https://twitter.com/balloonthemes",
            "type" => "text");

        $of_options[] = array("name" => "Youtube",
            "desc" => "Enter your Youtube channel link.",
            "id" => "youtube_link",
            "std" => "http://www.youtube.com/user/balloonthemes",
            "type" => "text");

        $of_options[] = array("name" => "Flickr",
            "desc" => "Enter your Flickr link.",
            "id" => "flickr_link",
            "std" => "https://www.flickr.com/photos/balloonthemes",
            "type" => "text");

        $of_options[] = array("name" => "RSS",
            "desc" => "Enter your RSS link.",
            "id" => "rss_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Google+",
            "desc" => "Enter your Google+ link.",
            "id" => "google_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "LinkedIn",
            "desc" => "Enter your LinkedIn link.",
            "id" => "linkedin_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Instagram",
            "desc" => "Enter your instagram link.",
            "id" => "instagram_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Vimeo",
            "desc" => "Enter your Vimeo link.",
            "id" => "vimeo_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Pinterest",
            "desc" => "Enter your Pinterest link.",
            "id" => "pinterest_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Tumblr",
            "desc" => "Enter your Tumblr link.",
            "id" => "tumblr_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Dribbble",
            "desc" => "Enter your Dribbble link.",
            "id" => "dribbble_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Weibo",
            "desc" => "Enter your Weibo link.",
            "id" => "weibo_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Dropbox",
            "desc" => "Enter your Dropbox link.",
            "id" => "dropbox_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Skype",
            "desc" => "Enter your Skype account.",
            "id" => "skype_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Playstore",
            "desc" => "Enter your Playstore link.",
            "id" => "android_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Appstore",
            "desc" => "Enter your Appstore link.",
            "id" => "appstore_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Email",
            "desc" => "Enter your Email address.",
            "id" => "email_link",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => "Github",
            "desc" => "Enter your Github link.",
            "id" => "github_link",
            "std" => "",
            "type" => "text");
*/
		$of_options[] = array(
            "position" => "end",
            "type" => "accordion");
			
        $of_options[] = array("name" => "Social Media",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Social Sharing",
            "desc" => "",
            "id" => "social_sharing",
            "std" => "<h3>Social Sharing</h3>",
            "icon" => false,
            "type" => "info");

        $of_options[] = array("name" => "Facebook",
            "desc" => "Check the box to show the facebook sharing icon in blog, woocommerce and course detail page.",
            "id" => "sharing_facebook",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Twitter",
            "desc" => "Check the box to show the twitter sharing icon in blog, woocommerce and course detail page.",
            "id" => "sharing_twitter",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "LinkedIn",
            "desc" => "Check the box to show the linkedin sharing icon in blog, woocommerce and course detail page.",
            "id" => "sharing_linkedin",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Google Plus",
            "desc" => "Check the box to show the g+ sharing icon in blog, woocommerce and course detail page.",
            "id" => "sharing_google",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Tumblr",
            "desc" => "Check the box to show the tumblr sharing icon in blog, woocommerce and course detail page.",
            "id" => "sharing_tumblr",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Pinterest",
            "desc" => "Check the box to show the pinterest sharing icon in blog, woocommerce and course detail page.",
            "id" => "sharing_pinterest",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => "Email",
            "desc" => "Check the box to show the email sharing icon in blog, woocommerce and course detail page.",
            "id" => "sharing_email",
            "std" => 1,
            "type" => "checkbox");



// BACKUP OPTIONS
        $of_options[] = array("name" => "Backup Options",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Backup and Restore Options",
            "id" => "of_backup",
            "std" => "",
            "type" => "backup",
            "desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
        );

        $of_options[] = array("name" => "Transfer Theme Options Data",
            "id" => "of_transfer",
            "std" => "",
            "type" => "transfer",
            "desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
        );
// Maintenance Mode
        $of_options[] = array("name" => "Maintenance",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Enable Maintenance Mode?",
            "desc" => "This option requires a Under Construction/ Maintenance page for redirection bellow.",
            "id" => "maintenance_mode",
            "std" => 0,
            "type" => "checkbox");
        $pages = get_pages();
        $options = array();
        $options[''] = 'Select a page';
        foreach($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }

        $of_options[] = array( "name" => __("Redirect page", "gmswebdesign"),
            "desc" => __("Using this page to display maintenance mode info for visitors", "gmswebdesign"),
            "id" => "maintenance_page",
            "std" => "",
            "type" => "select",
            "options" => $options);
        $of_options[] = array("name" => "Exclude IP Addresses",
            "desc" => "Enter your IP Addresses you don't want to be affected. Separated by newline",
            "id" => "exclude_ips",
            "std" => "",
            "type" => "textarea");
        $of_options[] = array("name" => "Exclude URLs",
            "desc" => "Enter your URLs you don't want to be affected. Separated by newline",
            "id" => "exclude_urls",
            "std" => "",
            "type" => "textarea");



    }//End function: of_options()
}//End chack if function exists: of_options()
?>