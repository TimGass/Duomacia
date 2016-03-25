web:
  name: duomacia
  shared_writable_dirs:
    - storage/cache
    - storage/database
    - storage/logs
    - storage/sessions
    - storage/views
    - storage/work
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
    - "rm -f storage/cache/*"
    - "rm -f storage/views/*"
  after_build:
    - "chmod +x deploy.sh"
    - "./deploy.sh"
