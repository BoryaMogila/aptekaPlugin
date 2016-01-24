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

function con ($content){

        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">
        <p><input type="text" name="search"/>
        <p><input type="submit" value="Пошук"></p>
        </form>';
        if(!empty($_POST['search'])){
            $search = $_POST['search'];
            $query = iconv('UTF-8', 'cp1251', $search);
            $textQuery = urlencode($query);
            $data = file_get_html('http://www.piluli.ru/search_result.html?searchback=' . $textQuery . '&search=' . $textQuery);
            if($data->find('.ws-ih')){
                foreach($data->find('.ws-ih') as $a){
                    echo '<p class="medcine_name">' . $a->find('.p_name', 0)->plaintext . '</p><p class="cost">' . $a->find('.price', 0)->plaintext . '</p>';
                }
            } else {
                echo 'Такого препарата не найдено';
            }

            //return $content;
        }
    return $content;
}


add_filter('the_content','con');

