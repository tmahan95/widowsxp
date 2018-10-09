<?php

namespace WidowsXP;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
	//
	protected $fillable = ['date', 'uname', 'compname', 'ipaddress', 'os_version', 'os_build', 'bios_version', 'bios_date', 'model', 'serial'];
	protected $dates = ['deleted_at'];
}
