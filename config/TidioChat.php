<?php

/**
 * Configure your TidioChat key getting it from the admin panel of TidioChat:
 * https://www.tidiochat.com/panel#!content-integration
 *
 * EXAMPLE:
 * <script src="//code.tidio.co/yx0hvipyomp12mpd7y0jbbji2mmr03iy.js"></script>
 *
 * Your key is the 32 characters long name of the js script file
 */

return [
    'key' => env('TIDIO_KEY', '')
];
