<?php
function formatUptime($uptime)
{
	// Pisahkan nilai uptime menjadi bagian-bagian (d, h, m, s)
	preg_match('/(\d+d)?(\d+h)?(\d+m)?(\d+s)?/', $uptime, $matches);

	// Ambil nilai masing-masing bagian
	$days = isset($matches[1]) ? intval(substr($matches[1], 0, -1)) : 0;
	$hours = isset($matches[2]) ? intval(substr($matches[2], 0, -1)) : 0;
	$minutes = isset($matches[3]) ? intval(substr($matches[3], 0, -1)) : 0;
	$seconds = isset($matches[4]) ? intval(substr($matches[4], 0, -1)) : 0;

	// Ubah format menjadi "1d 00:00:00"
	$formattedUptime = sprintf('%dd %02d:%02d:%02d', $days, $hours, $minutes, $seconds);

	return $formattedUptime;
}
