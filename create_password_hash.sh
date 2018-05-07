#!/bin/sh
php -r "echo password_hash(\"$1\", PASSWORD_BCRYPT); echo \"\n\";"
