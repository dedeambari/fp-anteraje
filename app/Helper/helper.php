<?php

use Illuminate\Support\Carbon;

if (!function_exists('generateNoResi')) {
	function generateNoResi()
	{
		$prefix = 'RESI';
		$date = Carbon::now()->format('ymd');
		$time = Carbon::now()->format('Hisv');
		$rand = Str::upper(Str::random(4));
		return "{$prefix}-{$date}-{$time}-{$rand}";
	}
}


if (!function_exists('format_rupiah')) {
	function format_rupiah($value, $default = '-')
	{
		if (is_null($value) || $value == 0) {
			return $default;
		}

		return 'Rp. ' . number_format($value, 0, ',', '.');
	}
}

if (!function_exists('exceptCollect')) {
	function exceptCollect($value, $except)
	{
		// pastikan $except berupa array
		$except = is_array($except) ? $except : [$except];

		return collect($value->toArray())->except($except)->toArray();
	}
}
