build:
	gcc ./priv_esc/login.c -o login -O0 -Wl,-eentry
	strip -s -K _start ./login
	docker-compose build 
run:
	docker-compose up -d
stop:
	docker-compose stop
delete:
	docker-compose down


