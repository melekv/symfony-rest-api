create-project:
	docker exec -t symfony-rest-api.php symfony new ./ --version="6.2.*"
	docker exec -t symfony-rest-api.php chown -R 1000:www-data /var/www/html
	docker exec -t symfony-rest-api.php rm /var/www/html/.gitignore
	docker exec -t symfony-rest-api.php rm -rf /var/www/html/.git

stop:
	docker kill $(docker ps -q)

cmd:
	docker exec -t symfony-rest-api.php $(cmd)
