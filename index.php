<?php
require_once 'SmarterMail.php';

$domain = 'domain';
$user = 'username';
$pass = 'Pass';

$domain = 'https://nos-mail.manageyour.host';
$user = 'admin';
$pass = 'T21mC5iUiUeeE1QiVja9FhDYdUOa';

$smartMail = new SmarterMail();
$smartMail->username = $user;
$smartMail->password = $pass;
$smartMail->doamin = $domain;


$domains = $smartMail->get_domains();
echo 'domains:>';
print_r($domains);

$user_emails = $smartMail->get_users($domains[0]);
echo 'users:>';
print_r($user_emails);

$user_count = count($user_emails);
echo 'user count:>';
print_r($user_count);
