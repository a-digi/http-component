<?php

declare(strict_types=1);

namespace AriAva\Http\Response;

enum ResponseStatusEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
}
