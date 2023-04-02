create-project:
	docker exec -t symfony-rest-api.php git config --global --add safe.directory /var/www/html
	docker exec -t symfony-rest-api.php git config --global user.email "marekwitkowski89@gmail.com"
	docker exec -t symfony-rest-api.php git config --global user.name "Marek Witkowski"
	docker exec -t symfony-rest-api.php symfony new ./ --version="6.2.*"
	docker exec -t symfony-rest-api.php rm /var/www/html/.gitignore
	docker exec -t symfony-rest-api.php rm -rf /var/www/html/.git
	docker exec -t symfony-rest-api.php composer require --dev symfony/maker-bundle

stop:
	docker kill $(docker ps -q)

cmd:
	docker exec -t symfony-rest-api.php $(cmd)
