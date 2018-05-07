# Simplistic Private Notes

Online markdown notes for personal use.

A brutally simplistic implementation.

Literally hacked together in PHP.

Note: Instructions are for Debian 8 (Jessie), May 2018.

## Create / Verify Password Hash

```sh
./create_password_hash.sh test
./verify_password_hash.sh test '$2y$10$xjvsSHuRRdYipNWZG6NVpuRUuX8hA0YnI8b/UmbOkr.5SXKrUKMuK'
```

## Manage your notes directory

```sh
sudo -s -u www-data
ssh-keygen
git clone git@github.com:cdacos/my-private-notes.git
```

## Create config.ini

```ini
[notes]
password_hash=$2y$10$xjvsSHuRRdYipNWZG6NVpuRUuX8hA0YnI8b/UmbOkr.5SXKrUKMuK
notes_dir=/var/www/html/my_web_folder/notes
```

## Search uses RipGrep

```sh
curl -LO https://github.com/BurntSushi/ripgrep/releases/download/0.8.1/ripgrep_0.8.1_amd64.deb
sudo dpkg -i ripgrep_0.8.1_amd64.deb
```

## Let's Encrypt

https://certbot.eff.org/lets-encrypt/debianjessie-apache.html

```sh
sudo vim /etc/apt/sources.list
sudo apt-get update
sudo apt-get install python-certbot-apache -t jessie-backports
# Didn't work due to security changes in certbot:
sudo certbot --apache # Boo
# So:
sudo certbot --authenticator webroot --installer apache
```

https://www.ssllabs.com/ssltest/analyze.html?d=notes.example.com&latest
