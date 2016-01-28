<?php
/**
 * @packege Borya
 * @version 1.0
 */
/*
Plugin Name: renderAptPage
Plugin URI: http://www.localhost
Description: renderAptPage
Armstrong: My plugin
Author: Borya Mogila
Version: 1.0
Author URI: http://www.localhost
*/
include 'simple_html_dom.php';

function conf_renderAptPage (){

    add_options_page('Настройки поиска аптеки', 'аптека', 8, 'apteka_config', 'config_apteka');

}

function config_apteka(){

    echo '<h2>Виберіть назву сторінки для виводу пошуку препарату</h2>';

    add_option('mogila_pageName','');

    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=apteka_config&amp;updated=true">
        <p><input type="text" name="apteka_pageName" value="' . get_option('mogila_pageName') . '"/>
        <p><input type="submit" name="saveAptConf" value="Зберегти"></p>
        </form>';

    if(isset($_POST['saveAptConf'])){

        $mogila_pageName = $_POST['apteka_pageName'];

        update_option('mogila_pageName', $mogila_pageName);

    }


}

function con ($content){

    if(is_page(get_option('mogila_pageName'))){

        echo '<form method="get">
        <p><input type="text" name="medcine"/>
        <p><input type="submit" value="Пошук"></p>
        </form>';

        if(!empty($_GET['medcine'])){

            $search = $_GET['medcine'];

            $data = file_get_html('http://apteka.ru/search/?q=' . $search . '&order=products%2Cmaterials&vendor=&shop=');

            if($data->find('article.item')){

                foreach($data->find('article.catalog-item') as $a){

                    echo '<p class="medcine_name">' . $a->find('.h2-style', 0)->plaintext .
                         ' <span class="cost">' . $a->find('.price', 0)->plaintext . '</span><br>
                         <span class="describe">' . $a->find('p.substances', 0)->plaintext . '</span></p>';

                }
            } else {

                echo 'Такого препарата не найдено';

            }
        }
    }
    return $content;

}
add_action('admin_menu', 'conf_renderAptPage');

add_filter('the_content','con');

