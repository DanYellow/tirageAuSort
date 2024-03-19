<?php

namespace App\EnumTypes;

enum AwardCategory: string {
    case Jury = 'jury';
    case Public = 'public';
}