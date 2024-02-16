<?php

$plainPassword = 'test';

$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

echo $hashedPassword . "\n";

echo var_dump(password_verify($plainPassword, $hashedPassword));