# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES

---

#### BMP features
- [x] Decentralized, on-chain, verifiable.
- [x] Hardware-wallet auth.
- [x] Real-time chat.
- [x] Multi-blockchain SHA-256 hashpower merged.
- [x] Voting (multiple points/options, rectifiable votes, filter by blockchain, comments).

**[BMP](https://bmp.virtualpol.com)** is a protocol and a hashpower voting system, completely on-chain, verifiable, replicable and simple. A sophisticated expandable base system. BMP can calculate the exact hashpower of each individual miner. Extending the Satoshi Nakamoto [Whitepaper](https://bmp.virtualpol.com/bitcoin.pdf).

BMP is a [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) web system, connected to a one or multiple Bitcoin client -via RPC- to read blocks and transactions. Blockchain data is processed with [this PHP code](https://github.com/JavierGonzalez/BMP/blob/master/*bmp/bmp.php) in three SQL tables: **[Blocks](https://bmp.virtualpol.com/info/blocks)**, **[Miners](https://bmp.virtualpol.com/info/miners)** and **[Actions](https://bmp.virtualpol.com/info/actions)**.


Actions are stored in Bitcoin Cash (BCH) because is fast, cheap and stable.

Actions without hashpower are ignored. Miners power (% of HP) changes with each block. Actions power never changes.

Actions are composed in JavaScript and broadcast with [Trezor Connect](https://github.com/trezor/connect/blob/develop/docs/methods/composeTransaction.md) (more hardware wallets in future).

BMP does not store private keys and local database is public information (cache only).

More details in the **[BMP Protocol](https://bmp.virtualpol.com/protocol)** and the [BMP paper](https://virtualpol.com/BMP_EN.pdf).


#### Requirements to participate

1. Your address inside a coinbase output in the last `4,032 blocks` of BTC, BCH or BSV.
2. Trezor hardware-wallet (recommended).


#### How to make manual actions

* Each miner action is a Standard Transaction in BCH.
* Miner address must be in coinbase VOUT in the last `4,032 blocks` of BTC, BCH and/or BSV.
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
* Web server (GNU/Linux, Apache, MySQL, PHP)
* +1 TB free space and +8 GB RAM.
* Bitcoin BCH client, with `-txindex`
* Bitcoin BTC client, with `-txindex`, optional
* Bitcoin BSV client, with `-txindex`, optional


**Deployment:**

1. Put the BMP code in the `www` httpd public directory.
2. Execute `scheme.sql` in a new MySQL database.
3. Configure RPC and SQL access re-naming `*/passwords.php.template` in to `*/passwords.php`
4. Wait Bitcoin clients up-to-date.
5. Set a `crontab` every minute executing: `curl https://bmp.your-domain.com/update`
6. Wait BMP synchronization (~24h). Check progress in: `/stats`


**Tested environment:**

* x86_64 GNU/Linux CentOS 7.8
* PHP 7.4
* MariaDB 5.5
* MySQL 5
* Firefox 67
* Chrome 74
* Bitcoin Unlimited 1.8.0
* Bitcoin Core 0.20.0
* Bitcoin SV 1.0.4
* P2Pool 17.0
* Trezor Model T (recomended)
* Trezor One (partially functional because limited OP_RETURN)


#### Known problems

* Blockchain synchronization by time.
* Update on chain reorg.
* Chineese and Spanish internationalization.
* More hardware wallets support.
* IRC-like classic attacks in chat.
* Formal specification.
* Automatic testing.
* Logo.
* Absolute power corrupts absolutely.

---

[Javier González González](https://twitter.com/JavierGonzalez)<br />gonzo@virtualpol.com<br />BMP Architect
