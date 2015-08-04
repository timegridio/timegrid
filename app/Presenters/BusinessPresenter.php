<?php

namespace App\Presenters;

use App\Business;

class BusinessPresenter extends \Robbo\Presenter\Presenter
{
    /**
     * get Facebook Profile Public Picture
     *
     * @param  string $type Type of picture to print
     * @return string       HTML code to render img with facebook picture
     */
    public function getFacebookImg($type = 'square')
    {
        if(!$this->social_facebook)
        {
            return "<img class=\"img-thumbnail\" src=\"//placehold.it/100x100\"/>";
        }
        $r = parse_url($this->social_facebook);
        if($r['path'] == '/profile.php')
        {
            parse_str($r['query'], $parts);
            $UID = $parts['id'];
        }
        else
        {
            $UID = trim($r['path'],'/');
        }
        $url = "http://graph.facebook.com/$UID/picture?type=$type";
        return "<img class=\"img-thumbnail media-object\" src='$url' />";
    }

    /**
     * get Google Static Map img
     *
     * @param  integer $zoom Zoom Level
     * @return string        HTML code to render img with map
     */
    public function getStaticMap($zoom = 15)
    {
        $data = array('center'         => $this->postal_address,
                      'zoom'           => intval($zoom),
                      'scale'          =>'2',
                      'size'           =>'180x100',
                      'maptype'        =>'roadmap',
                      'format'         =>'gif',
                      'visual_refresh' =>'true');

        $src = 'http://maps.googleapis.com/maps/api/staticmap?' . http_build_query($data, '', '&amp;');
        return "<img class=\"img-responsive img-thumbnail center-block\" src=\"$src\"/>";
    }

    /**
     * get Industry Icon
     *
     * @return string        HTML code to render img with icon
     */
    public function getIndustryIcon()
    {
        $src = asset('/img/industries/'.$this->category()->first()->slug.'.png');
        return "<img class=\"img-responsive center-block\" src=\"$src\"/>";
    }
}
