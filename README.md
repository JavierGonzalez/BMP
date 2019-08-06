# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES

---

###### A Hashpower Voting System for Bitcoin Global Adoption.

## Why

> Any needed rules and incentives can be enforced with this consensus mechanism.

Last sentence of [Bitcoin: A Peer-to-Peer Electronic Cash System](https://www.bitcoin.com/bitcoin.pdf) by Satoshi Nakamoto (2008-10)
<br />


> If freedom is the why,  Bitcoin is the how.

Tweet by [Roger Ver](https://twitter.com/rogerkver/status/649991677721972736) (2015-10-02)
<br />

> As a new form of executive power, it is likely that in the near future a virtual and transparent Bitcoin Mining Parliament (BMP) will be established. There each participant can have voice and vote in proportion to their percentage of demonstrable exahases per second.

Extract from [Miners are the executive power of Bitcoin](https://virtualpol.com/Miners_are_the_executive_power_of_Bitcoin_EN.pdf) by Javier González González (2017-10-31)
<br />

> Currently, the Bitcoin miners estimate consensus with inadequate coordination.
> 
> This causes contentious hardforks that divide the blockchain, fracture the community, create confusion and damage adoption. Miners can take responsibility, better than anyone else, for preventing the risk of such events happening again.
>
> In the process of technological development, often crossroads arise with two valid but incompatible solutions in the same blockchain. Therefore, technological development requires decision-making.
>
> The human tendency to become entangled in conflict is a predictable pattern. With multiple development teams competing, confrontation is only a matter of time. To resolve this, miners must assume their executive role.
>
> Moreover, in a technological race, the acceleration vector is a decisive factor that makes the difference. Global adoption will be conquered by the blockchain capable of evolving technologically at a faster rate.
>
> For a successful global adoption to be possible, Bitcoin miners must coordinate effectively.

Extract from [The Bitcoin Mining Parliament](https://virtualpol.com/BMP_EN.pdf) by Javier González González (2018-06-15)
<br />

> We need stop the regular hard fork of Bitcoin Cash. We need stable Bitcoin protocol specification, We need multiple implementation. There should not be dev decide but miner vote.

Tweet by [Haipo Yang](https://twitter.com/yhaiyang/status/1027914585607626752) (2018-08-10)
<br />

> Yes, miners decide. It’s best you take a lead role in talking with devs, companies and users so you make sure you make the right decision. It will also help to sponsor the right teams, after all, you’re the one that’s getting paid for sustaining the ecosystem.

Tweet by [Olivier Janssens](https://twitter.com/olivierjanss/status/1028016342379757569) (2018-08-10)
<br />


>We need a decision making process for changing and improving the protocol.

Specification by Jihan Wu (2018-08-30)
<br />


> No matter the outcome, this war will display the power and influence of the hashrate and this would potentially put weight on the importance of hashrate in the ecosystem. This lays the ground of using hashrate as the deciding factor for future Bitcoin splits. BTC, BCH, BSV and other coins which have same consensus algorithm and yet splits will eventually be unified.

Extract from [ABC vs BSV Hash War (Part III)](https://medium.com/@jiangzhuoer/abc-vs-bsv-hash-war-part-iii-the-war-of-the-hash-power-45fef8010467) by Jiang Zhuoer (2018-11-14)
<br />


## How

Talking and voting with hashpower -to discover consensus- in the most secure voting system known.


## What

#### [bmp.virtualpol.com](https://bmp.virtualpol.com)

<br />

[BMP](https://bmp.virtualpol.com) is a [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) web system, completely on-chain, verifiable, replicable and driven by hashpower.

BMP works connected to a Bitcoin Cash client by RPC to read blocks and transactions. 
Blockchain data is transformed [with this PHP](https://github.com/JavierGonzalez/BMP/blob/master/autoload/bmp.php) in 3 SQL tables: **[Blocks](https://bmp.virtualpol.com/info/blocks)**, **[Miners](https://bmp.virtualpol.com/info/miners)** and **[Actions](https://bmp.virtualpol.com/info/actions)**.


Actions without hashpower are ignored. Miners power changes with each block. Actions power never changes.

Actions are composed in JavaScript and broadcast with [Trezor Connect](https://github.com/trezor/connect/blob/develop/docs/methods/composeTransaction.md) (more hardware wallets in future).

BMP does not store private keys. The entire BMP database is public information.

More in **[BMP Protocol](https://bmp.virtualpol.com/protocol)** and paper in [Chinese](https://virtualpol.com/BMP_CN.pdf), [English](https://virtualpol.com/BMP_EN.pdf) and [Spanish](https://virtualpol.com/BMP_ES.pdf).


#### Features

* Hardware-wallet authentication.
* Real-time chat with hashpower.
* Nick change.
* Voting with multiple config, points and options.
* Votes with hashpower.
* Rectifiable votes (in open voting).
* 100% verifiable on-chain.


#### Requirements to participate

1. Your address in a coinbase output in the last `2,016` blocks of BCH.
2. Trezor hardware wallet.


#### Hashpower signaling

1. **power_by_value** 
By default, BMP calculates the hashpower percentage of each output address with the coinbase `value`. This makes it compatible with all blocks and with P2Pool even the smallest miner can participate right now.

2. **power_by_opreturn**
In order not to interfere with mining operations, there is a second method that allows to signal hashpower quotas in one or more addresses in coinbase OP_RETURN output. This ignores the value and allows the delegation of hashpower with simplicity.

In this way, miners can easily delegate hashpower to anyone else.


#### Requirements to deploy

1. Bitcoin ABC client, with `-txindex`
2. GNU/Linux
3. Apache
4. MariaDB database
5. PHP

#### Tested environment

* x86_64 NVME
* GNU/Linux CentOS 7.6
* PHP 7.3
* MariaDB 5.5
* MySQL 5
* Firefox 67
* Chrome 74
* Trezor One
* Bitcoin ABC 0.19.10
* Bitcoin Core 0.18.0
* Bitcoin SV 0.2.1

#### How to deploy

1. Put the BMP code in the `www` httpd public directory.
2. Configure RPC and SQL access by renaming `autoload/_password.php`.
3. Execute `scheme.sql` in a new SQL database.
4. Set a `crontab` every minute with: `curl https://bmp.domain.com/update`.
5. Wait synchronization.

#### Known problems

* Logo.
* OP_RETURN size too small because Trezor hardware limits (?).
* More hardware wallets support.
* IRC-like classic attacks.
* Internationalization.
* 0-conf latency (+5 sec).
* Absolute power corrupts absolutely.

---

[Javier González González](https://twitter.com/JavierGonzalez)<br />gonzo@virtualpol.com<br />BMP Architect