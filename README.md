# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES

## Why the Bitcoin Mining Parliament?

The [Bitcoin Mining Parliament](https://bmp.virtualpol.com) (BMP) is a protocol and hashpower voting system, decentralized, on-chain, open-source, verifiable, easy to use, simple, extensible, voluntary, resistant to outside interference and neutral. 

The BMP takes no sides in internal Bitcoin Cash disagreements. The BMP is a neutral protocol, non-political, that works with on-chain data. It is as secure as the Bitcoin Cash blockchain.

The BMP is an on-chain Bitcoin Cash governance protocol that enables miners to coordinate their actions, and thus bring greater certainty to the BCH ecosystem. Miners, and any delegated agents, can talk and vote with their hashpower, simply extending the [Nakamoto Consensus](https://bmp.virtualpol.com/bitcoin.pdf) in a pre-consensus phase. 

The BMP empowers the miners of the last 28 days of BCH blocks to make themselves heard, with a perfect signal to noise ratio. The BMP can serve as an important tool for Bitcoin Cash governance, reducing forking, infighting and disputes.

## BMP Features
- Decentralized, on-chain, verifiable.
- Hardware-wallet authentication.
- Real-time chat.
- Optional multi-blockchain SHA-256 hashpower merged.
- Voting (multiple points/options, rectifiable votes, filter by blockchain, comments).
- BMP can calculate the exact hashpower of each individual miner (not just pools).

BMP is a [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) web system, connected to a one or more Bitcoin clients (via RPC) to read blocks and transactions. Blockchain data is processed with [this PHP code](https://github.com/JavierGonzalez/BMP/blob/master/*bmp/bmp.php) in three SQL cache tables: [Blocks](https://bmp.virtualpol.com/info/blocks), [Miners](https://bmp.virtualpol.com/info/miners) and [Actions](https://bmp.virtualpol.com/info/actions).

Actions are stored in Bitcoin Cash (BCH) because it is fast, cheap and stable.

Actions without hashpower are ignored. Miners power (% of hashpower) changes with each block. Actions power never changes.

Actions are composed in JavaScript and broadcast with [Trezor Connect](https://github.com/trezor/connect/blob/develop/docs/methods/composeTransaction.md). More hardware wallets will be available in the future.

BMP does not store private keys and the local database only contains public information.

More details are available in the [BMP Protocol](https://bmp.virtualpol.com/protocol) and the [BMP paper EN](https://virtualpol.com/BMP_EN.pdf) | [ZH](https://virtualpol.com/BMP_CN.pdf) | [ES](https://virtualpol.com/BMP_ES.pdf).

### Requirements to Participate

1. Your address is inside a coinbase output in the last `4,032 blocks` of the coin you are mining, be it BTC, BCH or BSV.
2. Trezor hardware wallet (recommended). Use a new Trezor account (with fund for fees only).

The BMP works separately for BCH, BTC and BSV. 

### How to Create Actions Manually

If you do not have a Trezor hardware wallet, you can create manual transactions.

* Each miner action is a standard transaction in BCH.
* BMP actions uses <a href="https://memo.cash" target="_blank">Memo.cash</a> style.
* The miner’s address must be in the coinbase VOUT in one the last `4,032 blocks` of the coin you are mining and wish to participate in, be it BTC, BCH or BSV.
* The miner’s address must be in the TX_PREV VOUT (Any index).
* The miner’s address must be in VOUT index=0.
* OP_RETURN payload in VOUT index=1. 
* OP_RETURN prefix: `0x9d`.
* OP_RETURN respecting [BMP Protocol](https://bmp.virtualpol.com/protocol).

The BMP facilitates the OP_RETURN `hex` via web.

Here are some examples of manual actions:
- [chat](https://blockchair.com/bitcoin-cash/transaction/91162d0670c72fca6622d117e4d6b4149a3855de780295e852e471504b937c14)
- [vote](https://blockchair.com/bitcoin-cash/transaction/2c4219ce4533759a5886839d03494420e92c5add807c010c4b507b347b3b0e21)

### Signal and hashpower delegation

1. **power_by_value** 
By default, the BMP calculates the hashpower percentage of each output address with the coinbase `value`. This makes it compatible with all Bitcoin blocks. With P2Pool, even the smallest miner can participate right now.

2. **power_by_opreturn**
In order not to interfere with mining operations, this second method allows hashpower coinbase signal in one or multiple addresses with coinbase OP_RETURN output. This ignores `value`, and allows full hashpower delegation, with simplicity.


3. **power_by_action**
In development. For total flexibility, BMP will allow delegation of a % of hashpower to one or many addresses with a non-coinbase BMP protocol action. In the same way, it will allow you to modify or revoke that hashpower delegation with immediate effect.

With the BMP, miners can delegate arbitrary percentages of hashpower to other people to participate. In this way, miners can individually and revocably designate representatives in a fluid and accountable manner.

### How to Deploy your own BMP Server

#### Requirements

* Web server (GNU/Linux, Apache, MySQL, PHP).
* +1 TB free space and +8 GB RAM.
* Bitcoin BCH client, with `-txindex`.
* Bitcoin BTC client, with `-txindex`, optional.
* Bitcoin BSV client, with `-txindex`, optional.

#### Deployment

1. Put the BMP code in the `www` httpd public directory.
2. Execute `scheme.sql` in a new MySQL database.
3. Re-naming `*passwords.ini.template` in to `*passwords.ini`.
4. Configure RPC and SQL access.
5. Wait until the Bitcoin clients are up-to-date.
6. Set a `crontab` every minute executing: `curl https://bmp.your-domain.com/update`
7. Wait for the BMP synchronization (~24h). 
Check progress in: /stats

#### Tested Environments

* x86_64 GNU/Linux CentOS 7.8
* PHP 7.4
* MariaDB 5.5
* MySQL 5
* Firefox 67
* Chrome 74
* Bitcoin Unlimited 1.9.0
* Bitcoin Core 0.20.0
* Bitcoin SV 1.0.4
* P2Pool 17.0
* Trezor Model T (recomended).
* Trezor One (partially functional because limited OP_RETURN size).

### Known Problems

* Blockchain synchronization by time.
* Update on chain reorg.
* Chinese and Spanish internationalization.
* More hardware wallets support.
* IRC-like classic attacks in chat.
* Formal specification.
* Automatic testing.
* Absolute power corrupts absolutely.

## More Information
- [Why Bitcoin Cash Needs the BMP?](https://read.cash/@JavierGonzalez/why-bitcoin-cash-need-the-bmp-1a6ab975)
- [为什么比特币现金需要BMP系统?](https://read.cash/@JavierGonzalez/bmp-6bc8ea63)
- [¿Por qué Bitcoin Cash necesita el BMP?](https://read.cash/@JavierGonzalez/por-que-bitcoin-cash-necesita-el-bmp-e6a746a3)
- [https://twitter.com/askthebmp](https://twitter.com/askthebmp)
- [https://read.cash/@AskTheBMP](https://read.cash/@AskTheBMP)


[Javier González González](https://twitter.com/JavierGonzalez)
gonzo@virtualpol.com
BMP Architect