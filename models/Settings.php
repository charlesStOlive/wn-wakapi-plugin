<?php

namespace Waka\Wakapi\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'waka_wakapi_settings';
    public $settingsFields = 'fields.yaml';
}