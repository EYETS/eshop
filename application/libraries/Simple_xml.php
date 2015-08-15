<?php

include "" . APPPATH . "/third_party/_dom.php";
//define('MAX_FILE_SIZE', 9999999);
// by sohaib sleem
class Simple_xml {

    //return xml heirarchy
    function get_rss($rss_link) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $rss_link);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $xml = curl_exec($ch);
        curl_close($ch);

        return $xml;
    }

    function get_content($HtmlLink) {

        $html = @file_get_html($HtmlLink);
        return $html;
    }

    function get_content_for($html, $host, $image, $title) {
        $j_value['full_content'] = "";

        switch ($host) {
            case "elwatannews" :
                $img = str_get_html(str_replace("Small", "Large", $image));
                //$j_value['img'] = $img->find('img', 0)->src;

                foreach ($html->find('meta[name=keywords]') as $e) {
                    $j_value['full_tags'] = $e->content;
                }
                foreach ($html->find('div.main_content_ip p') as $e) {   //elwattn
                 echo   $j_value['full_content'] .= str_replace("التعليقاتسياسة التعليقات", "", strip_tags($e->innertext));
                }
                break;

            case "dostor":


                foreach ($html->find('div.article_image img') as $e) {

                    $j_value['img'] = $host . $e->src;
                }


                //get content
                foreach ($html->find('div.article_text') as $e) {
                    $j_value['full_content'] .= $e->innertext;
                }
                //metatags
                foreach ($html->find('meta[name=keywords]') as $e) {

                    $j_value['full_tags'] = $e->content;
                }


                break;


            case "almasryalyoum":
                $main_img = str_replace("/imagecache/highslide_zoom", "", $image);
                $j_value['img'] = $host . "/" . $main_img;

                foreach ($html->find('div.pane-content p') as $e) {
                  $j_value['full_content'] .= str_replace("المزيد", "", strip_tags($e->innertext));
                }

                foreach ($html->find('meta[name=keywords]') as $e) {

                    $j_value['full_tags'] = $e->content;
                }

                break;

            case "youm7":



                foreach ($html->find('div#newsStoryImg img') as $e) {
                    $j_value['img'] = $e->src;
                }



                foreach ($html->find('div#newsStoryTxt p') as $e) {

                   $full_content = strip_tags($e->innertext);
                    $j_value['full_content'] .= iconv('windows-1256', 'utf-8', $full_content);
                    $j_value['full_tags'] = str_replace(" ", ",", $title);
                }
                break;



            case "alarabiya":

                foreach ($html->find('div.article-body') as $s) {
                    $j_value['full_content'] .= strip_tags($s->innertext);
                }


                foreach ($html->find('div.article_img img') as $d) {

                    $j_value['img'] = $d->src;
                }

                foreach ($html->find('meta[name=keywords]') as $g) {

                    $j_value['full_tags'] = $g->content;
                }


                break;

            case "alwafd":


                foreach ($html->find('div.article_image img') as $d) {

                    $j_value['img'] = $d->src;
                }
                foreach ($html->find('div.item-page p') as $e) {

                    $j_value['full_content'] .= strip_tags($e->innertext);
                }

                foreach ($html->find('meta[name=keywords]') as $e) {

                    $j_value['full_tags'] = htmlentities($e->content);
                }


                break;
            case "elfagr":
                if (is_object($html)) {


                    foreach ($html->find('td#ctl00_ContentPlaceHolder1_maintd img') as $d) {

                        $j_value['img'] = $d->src;
                    }
                    foreach ($html->find('td#ctl00_ContentPlaceHolder1_maintd p[dir="RTL"]') as $d) {

                        $res_p = htmlentities(strip_tags($d->innertext));
                    }
                    foreach ($html->find('td#ctl00_ContentPlaceHolder1_maintd div') as $d) {

                        $res_div = htmlentities(strip_tags($d->innertext));
                    }

                    if ($res_p != null) {
                        $j_value['full_content'] .= $res_p;
                    } else {

                        $j_value['full_content'] .= $res_div;
                    }

                    foreach ($html->find('meta[name=keywords]') as $d) {

                        $j_value['full_tags'] = htmlentities($d->content);
                    }
                }
                break;
        }

        //unset($d);

       
        return $j_value;
    }

}

?>
