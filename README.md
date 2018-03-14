# Blockchain implementation in PHP

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg)](https://php.net/)
[![Build Status](https://travis-ci.org/akondas/php-blockchain.svg?branch=master)](https://travis-ci.org/akondas/php-blockchain)
[![License](https://poser.pugx.org/akondas/php-blockchain/license.svg)](https://packagist.org/packages/akondas/php-blockchain)

Clean code approach to blockchain technology. Learn blockchain by reading source code.

## Roadmap

 - [x] Block structure and hashing
 - [x] Genesis block
 - [x] Storing and validate Blockchain
 - [x] Proof of Work with difficulty (missing consensus on the difficulty)
 - [X] Communicating with other nodes & controlling the node (based on ReactPHP)
 - [ ] Simple persistence layer 
 - [ ] Going serverless with AWS Lambda (experiment)
 - [ ] Start working on KondasCoin [akondas/coin](https://github.com/akondas/coin) :rocket: (Transactions, Wallet, Transaction relaying, Maybe some UI)

## Node

To start the node:

```
bin/node
```

Default web server port is 8080 but you can change it with `--http-port` param:

```
bin/node --http-port=9090
```

Default p2p server port is 3030 but you can change it with `--p2p-port` param:

```
bin/node --p2p-port=2020
```

## API

To control node you can use simple (pseudo) REST API:

**[GET] /blocks**
Response (list of all blocks):
```
[{"index":0,"hash":"8b31c9ec8c2df21968aca3edd2bda8fc77ed45b0b3bc8bc39fa27d5c795bc829","previousHash":"","createdAt":"2018-02-23 23:59:59","data":"PHP is awesome!","difficulty":0,"nonce":0}]
```

**[POST] /mine**
Request (raw):
```
Data to mine (any string).
```
Response (mined block):
```
{"index":1,"hash":"a6eba6325a677802536337dc83268e524ffae5dc7db0950c98ff970846118f80","previousHash":"8b31c9ec8c2df21968aca3edd2bda8fc77ed45b0b3bc8bc39fa27d5c795bc829","createdAt":"2018-03-13 22:37:07","data":"Something goof","difficulty":0,"nonce":0}
```

**[GET] /peers**
Response (list of all connected peers):
```
[{"host":"127.0.0.1","port":3131}]
```

**[POST] /peers/add**
Request (json with peer):
```
{"host":"127.0.0.1", "port":"3131"}
```
Response: 204 (empty)


## Tests

To run test suite:

```
composer tests
```

## Coding standards

Checkers and fixers are in `coding-standard.neon`. To run:

```
composer fix-cs
```

## License

php-blockchain is released under the MIT Licence. See the bundled LICENSE file for details.

## Author

Arkadiusz Kondas (@ArkadiuszKondas)
