<?php

declare(strict_types=1);

namespace AriAva\Http;

enum ContentType: string
{
    case Image = 'image/jpeg';
    case Video = 'video/mp4';
    case Audio = 'audio/mpeg';
    case Text = 'text/plain';
    case HTML = 'text/html';
    case PDF = 'application/pdf';
    case JSON = 'application/json';
    case XML = 'application/xml';
    case JSONP = 'application/javascript';
    case CSS = 'text/css';
    case JS = 'text/javascript';
    case HTML5 = 'application/x-httpd-php';
}
