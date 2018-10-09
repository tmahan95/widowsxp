<?php

namespace WidowsXP;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable =[ 'date', 'uname', 'compname', 'ipaddress', 'os_version', 'os_build', 'bios_version', 'bios_date', 'model', 'serial'];
}
