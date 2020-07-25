
REM Get Composer
cd bin/
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e5325b19b381bfd88ce90a5ddb7823406b2a38cff6bb704b0acc289a09c8128d4a8ce2bbafcd1fcbdc38666422fe2806') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

REM Get PHP documentor.
php -r "file_put_contents('phpdoc.phar', file_get_contents('https://phpdoc.org/phpDocumentor.phar'));"
ECHO "PHPDocumentor download completed..."

REM Move back to root
cd ..

echo "Removing old packages.."
rmdir /S /Q vendor

ECHO "Installing composer packages..."
php composer.phar install
ECHO "Completed composer setup..."

echo "Clearing old code documents.."
rmdir /S /Q Build/Docs

ECHO "Start Code documentation generation..."
php bin/phpdoc.phar
ECHO "Completed composer setup..."
