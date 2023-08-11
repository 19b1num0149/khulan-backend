# Community App-г Docker дээрх ажиллуулах дараалал

## Windows -> PowerShell ашиглаарай; Linux -> Terminal

### Docker-compose file-ийг ажиллуулж Image үүсгэнэ
```bash
docker-compose up -d
```
### exec -it коммандаар Community App backend folder буюу ./var/www руу хандаж орно
```bash
docker exec -it community-app /bin/bash
```
### Laravel сангуудаа install хийнэ.
```bash
composer install
```
### .env.example -г хуулж шинээр .env файл үүсгэнэ.
```bash
cp .env.example .env
```
### Laravel project -н давтагдашгүй unique key үүсгэж байгаа.
```bash
php artisan key:generate
```
