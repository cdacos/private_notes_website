#!/bin/sh
php -r "echo \"$1\n\";"
php -r "if (password_verify(\"$1\", '$2')) { echo \"Success\"; } else { echo \"Fail\"; } echo \"\n\";"
