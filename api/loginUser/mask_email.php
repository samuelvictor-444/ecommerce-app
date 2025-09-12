<?php 
declare(strict_types=1);
function maskUserEmail ( string $userEmail): string {
       [$name, $domain] = explode("@", $userEmail);
       $maskName = substr($name, 0 , 3). str_repeat('*', max(0, strlen($name) - 3));
       
       return $maskName . "@" . $domain;
}