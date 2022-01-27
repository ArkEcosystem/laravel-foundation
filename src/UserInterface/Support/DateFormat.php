<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support;

enum DateFormat: string
{
    case DATE = 'd M Y';

    case TIME = 'd M Y H:i:s';

    case TIME_SHORT = 'd M Y H:i';

    case TIME_PARENTHESES = 'd M Y (H:i:s)';

    case DATE_JS = 'D MMM YYYY';

    case TIME_JS = 'D MMM YYYY HH:mm:ss';

    case TIME_SHORT_JS = 'D MMM YYYY HH:mm';

    case TIME_PARENTHESES_JS = 'D MMM YYYY (HH:mm:ss)';
}
