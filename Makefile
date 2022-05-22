build:
	docker build -t php-blockchain .

shell: build
	docker run -it --rm --name php-blockchain-dev -v $(PWD):/var/app -w /var/app php-blockchain:latest /bin/bash

.PHONY: build shell
