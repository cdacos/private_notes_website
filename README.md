# Simplistic Private Notes

Online markdown notes for personal use.

A brutally simplistic implementation.

Literally hacked together in PHP.

## Dockerised

```
docker-compose up -V --force-recreate
docker-compose up -d

docker exec -it private_notes_website_web_1 bash
docker exec -it private_notes_website_php_1 bash
```

## Create / Verify Password Hash

```sh
./create_password_hash.sh test
./verify_password_hash.sh test '$2y$10$xjvsSHuRRdYipNWZG6NVpuRUuX8hA0YnI8b/UmbOkr.5SXKrUKMuK'
```

## Create config.ini

```ini
password_hash=$2y$10$xjvsSHuRRdYipNWZG6NVpuRUuX8hA0YnI8b/UmbOkr.5SXKrUKMuK
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
