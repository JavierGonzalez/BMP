# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES

---

#### BMP is a Hashpower Voting System for Bitcoin Global Adoption
- [x] 100% on-chain, verifiable, simple.
- [x] Multi-blockchain SHA-256 hashpower merged.
- [x] Hardware-wallet auth.
- [x] Real-time chat.
- [x] Voting with multiple points and options.
- [x] Rectifiable votes (when open votings).
- [x] Nick change.
- [x] Open-source.

#### [bmp.virtualpol.com](https://bmp.virtualpol.com)

<br />

[BMP](https://bmp.virtualpol.com) is a voting system, completely on-chain, verifiable, replicable and driven by hashpower. A robust and expandable base system. Merge all Bitcoin SHA-256 hashpower. Expanding the vision of Satoshi Nakamoto [whitepaper](https://www.bitcoin.com/bitcoin.pdf).

BMP is a [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) web system connected to a multiple Bitcoin client -via RPC- to read blocks and transactions. Blockchain data is processed [with this PHP](https://github.com/JavierGonzalez/BMP/blob/master/autoload/bmp.php) in three SQL tables: **[Blocks](https://bmp.virtualpol.com/info/blocks)**, **[Miners](https://bmp.virtualpol.com/info/miners)** and **[Actions](https://bmp.virtualpol.com/info/actions)**.


Actions are stored in Bitcoin Cash (BCH) because is fast, cheap and stable. 

Actions without hashpower are ignored. Miners power (%) changes with each block. Actions power never changes.

Actions are composed in JavaScript and broadcast with [Trezor Connect](https://github.com/trezor/connect/blob/develop/docs/methods/composeTransaction.md) (more hardware wallets in future).

BMP does not store private keys and the database is public information.

More in **[BMP Protocol](https://bmp.virtualpol.com/protocol)** and the BMP paper in [English](https://virtualpol.com/BMP_EN.pdf), [Chinese](https://virtualpol.com/BMP_CN.pdf) and [Spanish](https://virtualpol.com/BMP_ES.pdf).


#### Requirements to participate

1. Your address in a coinbase output in the last `2,016` blocks of BTC, BCH or BSV.
2. Trezor hardware wallet.


#### How to make manual actions

* Standard transaction in BCH.
* Target address in coinbase VOUT in the last 2016 blocks of BTC, BCH and/or BSV.
* Target address in TX_PREV VOUT (Any index).
* Target address in VOUT INDEX=0.
* OP_RETURN payload in VOUT INDEX=1 according to [BMP Protocol](https://bmp.virtualpol.com/protocol) (Prefix = 9d).

The BMP facilitates the OP_RETURN `hex`.

Examples: [chat](https://blockchair.com/bitcoin-cash/transaction/91162d0670c72fca6622d117e4d6b4149a3855de780295e852e471504b937c14), [vote](https://blockchair.com/bitcoin-cash/transaction/2c4219ce4533759a5886839d03494420e92c5add807c010c4b507b347b3b0e21).


#### Hashpower signaling

1. **power_by_value** 
By default, BMP calculates the hashpower percentage of each output address with the coinbase `value`. This makes it compatible with all blocks. With P2Pool, even the smallest miner can participate, right now.

2. **power_by_opreturn**
In order not to interfere with mining operations, there is a second method that allows to signal hashpower quotas in one or more addresses in coinbase OP_RETURN output. This ignores the value and allows the delegation of hashpower with simplicity.

In this way, with simplicity, miners can delegate hashpower in other people to participate.


#### Requirements to deploy

1. LAMP web server (GNU/Linux, Apache, MySQL, PHP)
2. Bitcoin BCH client, with `-txindex`
3. Bitcoin BTC client
4. Bitcoin BSV client


#### Tested environment

* x86_64 GNU/Linux CentOS 7.6
* PHP 7.4
* MariaDB 5.5
* MySQL 5
* Firefox 67
* Chrome 74
* Trezor One (Limited OP_RETURN size, but functional)
* Trezor Model T
* Bitcoin Unlimited 1.7.0
* Bitcoin ABC 0.20
* Bitcoin Core 0.18
* Bitcoin SV 1.0.1 (docker)
* P2Pool 16.0

#### How to deploy

1. Put the BMP code in the `www` httpd public directory.
2. Configure RPC and SQL access by renaming `autoload/_password.php`.
3. Wait Bitcoin clients sync (BTC, BCH and BSV).
4. Execute `scheme.sql` in a new SQL database.
5. Set a `crontab` every minute with: `curl https://bmp.domain.com/update`.
6. Wait BMP synchronization.

#### Known problems

* Better and more consistent voting system.
* Clearer verifiability.
* Sync in the right block sequence order.
* IRC-like classic attacks.
* More hardware wallets support.
* Internationalization.
* Automatic testing.
* Logo.
* Absolute power corrupts absolutely.

---

[Javier González González](https://twitter.com/JavierGonzalez)<br />gonzo@virtualpol.com<br />BMP Architect
