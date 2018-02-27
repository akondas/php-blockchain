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
 - [ ] Communicating with other nodes & controlling the node (based on ReactPHP)
 - [ ] Start working on KondasCoin [akondas/coin](https://github.com/akondas/coin) :rocket: (Transactions, Wallet, Transaction relaying, Maybe some UI)

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
