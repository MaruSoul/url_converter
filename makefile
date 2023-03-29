start:
	docker-compose up -d
stop:
	docker-compose stop
down:
	docker-compose down
open-code:
	code .
to-workspace:
	docker exec -it "php_pro_2" /bin/bash
rebuild:
	docker-compose up --build -d
