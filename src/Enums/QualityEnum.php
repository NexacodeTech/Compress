<?php

namespace NexacodeTech\Compress\Enums;

enum QualityEnum: int
{
    case LOW = 20;
    case MEDIUM = 40;
    case HIGH = 60;
    case VERY_HIGH = 80;
    case MAXIMUM = 100;
}
