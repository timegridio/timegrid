<?php

namespace App\Presenters;

use App\Models\Business;
use McCool\LaravelAutoPresenter\BasePresenter;

class BusinessPresenter extends BasePresenter
{
    public function __construct(Business $resource)
    {
        $this->wrappedObject = $resource;
    }

    /**
     * get Facebook Profile Public Picture.
     *
     * @param string $type Type of picture to print
     *
     * @return string HTML code to render img with facebook picture
     */
    public function facebookImg($type = 'square')
    {
        if (!$this->wrappedObject->social_facebook) {
            return '<img class="img-thumbnail" src="//placehold.it/100x100"/>';
        }
        $url = parse_url($this->wrappedObject->social_facebook);

        $userId = trim($url['path'], '/');

        if ($url['path'] == '/profile.php') {
            parse_str($url['query'], $parts);
            $userId = $parts['id'];
        }

        $url = "http://graph.facebook.com/{$userId}/picture?type=$type";

        return "<img class=\"img-thumbnail media-object\" src='$url' />";
    }

    /**
     * get Google Static Map img.
     *
     * @param int $zoom Zoom Level
     *
     * @return string HTML code to render img with map
     */
    public function staticMap($zoom = 15)
    {
        $data = [
            'center'         => $this->wrappedObject->postal_address,
            'zoom'           => intval($zoom),
            'scale'          => '2',
            'size'           => '180x100',
            'maptype'        => 'roadmap',
            'format'         => 'gif',
            'visual_refresh' => 'true', ];

        $src = 'http://maps.googleapis.com/maps/api/staticmap?'.http_build_query($data, '', '&amp;');

        return "<img class=\"img-responsive img-thumbnail center-block\" src=\"$src\"/>";
    }

    /**
     * get Industry Icon.
     *
     * @return string HTML code to render img with icon
     */
    public function industryIcon()
    {
        if (!isset($this->wrappedObject)) {
            return '';
        }

        $src = asset('/img/industries/'.$this->wrappedObject->category->slug.'.png');

        return "<img class=\"img-responsive center-block\" src=\"{$src}\"/>";
    }
}
