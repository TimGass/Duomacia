web1:
  name: duomacia
  shared_writable_dirs:
    - app/storage/cache
    - app/storage/database
    - app/storage/logs
    - app/storage/sessions
    - app/storage/views
    - app/storage/work
  document_root: /public
  php_version: 5.4.14
  php_extensions:
    - pdo_mysql
    - mcrypt
    - curl
    - zip
  before_deploy:
    - "php artisan cache:clear"
    - "php artisan dump-autoload"
  after_deploy:
    - "rm -f app/storage/cache/*"
    - "rm -f app/storage/views/*"
  after_build:
    - "chmod +x deploy.sh"
    - "./deploy.sh"
