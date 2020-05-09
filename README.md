# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES

---

#### BMP is a Hashpower Voting System
- [x] Decentralized.
- [x] On-chain, verifiable, simple.
- [x] Multi-blockchain SHA-256 hashpower merged.
- [x] Hardware-wallet auth.
- [x] Real-time chat.
- [x] Hashpower voting (multiple points/options, rectifiable votes, by blockchain, comments).

#### [https://BMP.virtualpol.com](https://bmp.virtualpol.com)

<br />

[BMP](https://bmp.virtualpol.com) is a voting system, completely on-chain, verifiable, replicable and simple. A sophisticated expandable base system. BMP can calculate the exact hashpower of each individual miner. Merging all Bitcoin SHA-256 hashpower. Extending the Satoshi Nakamoto [Whitepaper](https://www.bitcoin.com/bitcoin.pdf).

BMP is a [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) web system, connected to a one or multiple Bitcoin client -via RPC- to read blocks and transactions. Blockchain data is processed with [this PHP code](https://github.com/JavierGonzalez/BMP/blob/master/autoload/bmp.php) in three SQL tables: **[Blocks](https://bmp.virtualpol.com/info/blocks)**, **[Miners](https://bmp.virtualpol.com/info/miners)** and **[Actions](https://bmp.virtualpol.com/info/actions)**.


Actions are stored in Bitcoin Cash (BCH) because is fast, cheap and stable. 

Actions without hashpower are ignored. Miners power (% of HP) changes with each block. Actions power never changes.

Actions are composed in JavaScript and broadcast with [Trezor Connect](https://github.com/trezor/connect/blob/develop/docs/methods/composeTransaction.md) (more hardware wallets in future).

BMP does not store private keys and the local database is public information (for fast cache only).

More details in the **[BMP Protocol](https://bmp.virtualpol.com/protocol)** and the [BMP paper](https://virtualpol.com/BMP_EN.pdf) ([CN](https://virtualpol.com/BMP_CN.pdf), [ES](https://virtualpol.com/BMP_ES.pdf)).


#### Requirements to participate

1. Your address in a coinbase output in the last `2,016` blocks of BTC, BCH or BSV.
2. Trezor hardware-wallet (recommended).


#### How to make manual actions

* Each miner action is a Standard Transaction in BCH.
* Miner address must be in coinbase VOUT in the last `2016 blocks` of BTC, BCH and/or BSV.
* Miner address in TX_PREV VOUT (Any index).
* Miner address in VOUT index=0.
* OP_RETURN payload in VOUT index=1. 
* OP_RETURN prefix: `0x9d`.
* OP_RETURN respecting [BMP Protocol](https://bmp.virtualpol.com/protocol).


The BMP facilitates the OP_RETURN `hex` via web.

Examples of actions: [chat](https://blockchair.com/bitcoin-cash/transaction/91162d0670c72fca6622d117e4d6b4149a3855de780295e852e471504b937c14), [vote](https://blockchair.com/bitcoin-cash/transaction/2c4219ce4533759a5886839d03494420e92c5add807c010c4b507b347b3b0e21).


#### How signal hashpower

1. **power_by_value** 
By default, BMP calculates the hashpower percentage of each output address with the coinbase `value`. This makes it compatible with all Bitcoin blocks. With P2Pool, even the smallest miner can participate right now.

2. **power_by_opreturn**
In order not to interfere with mining operations, this second method allows to signal hashpower in one or multiple addresses with coinbase OP_RETURN output. This ignores `value`, and allows full hashpower delegation, with simplicity.

With the BMP, miners can delegate arbitrary percentages of hashpower in other people to participate.


#### How to deploy your own BMP server

**Requirements:**
* Web server (GNU/Linux, Apache, MySQL, PHP, crontab)
* ~1 TB free space and ~4 GB RAM.
* Bitcoin BCH client, with `-txindex`
* Bitcoin BTC client
* Bitcoin BSV client


**Deployment:**

1. Put the BMP code in the `www` httpd public directory.
2. Configure RPC and SQL access by renaming: `autoload/_password.php`
3. Execute `scheme.sql` in a new SQL database.
4. Bitcoin clients must be up-to-date.
5. Set a `crontab` every minute with: `curl https://bmp.domain.com/update`
6. Wait BMP synchronization (24~48h).


**Tested environment:**

* x86_64 GNU/Linux CentOS 7.8
* PHP 7.4
* MariaDB 5.5
* MySQL 5
* Firefox 67
* Chrome 74
* Bitcoin Unlimited 1.8.0
* Bitcoin Core 0.19
* Bitcoin SV 1.0.1 (docker)
* P2Pool 17.0
* Trezor Model T (recomended)
* Trezor One (OP_RETURN limited, partially functional)


#### Known problems

* Formal specification.
* Blockchains synchronization time sequence order.
* IRC-like classic attacks in chat.
* More hardware wallets support.
* Internationalization.
* Automatic testing.
* Logo.
* Absolute power corrupts absolutely.

---

[Javier González González](https://twitter.com/JavierGonzalez)<br />gonzo@virtualpol.com<br />BMP Architect
