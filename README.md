# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES

----

## Why



> Any needed rules and incentives can be enforced with this consensus mechanism.

Extract from [Bitcoin: A Peer-to-Peer Electronic Cash System](https://www.bitcoin.com/bitcoin.pdf) by Satoshi Nakamoto (2008-10).
<br />


> If freedom is the why,  Bitcoin is the how.

Tweet by [Roger Ver](https://twitter.com/rogerkver/status/649991677721972736) (2015-10-02).
<br />

> As a new form of executive power, it is likely that in the near future a virtual and transparent
Bitcoin Mining Parliament (BMP) will be established. There each participant can have voice
and vote in proportion to their percentage of demonstrable exahases per second.

Extract from [Miners are the executive power of Bitcoin](https://virtualpol.com/Miners_are_the_executive_power_of_Bitcoin_EN.pdf) by Javier González González (2017-10-31).
<br />


> Currently, the Bitcoin miners estimate consensus with inadequate coordination.
> 
> This causes contentious hardforks that divide the blockchain, fracture the community, create
confusion and damage adoption. Miners can take responsibility, better than anyone else, for
preventing the risk of such events happening again.
>
> In the process of technological development, often crossroads arise with two valid but
incompatible solutions in the same blockchain. Therefore, technological development
requires decision-making.
>
> The human tendency to become entangled in conflict is a predictable pattern. With multiple
development teams competing, confrontation is only a matter of time. To resolve this, miners
must assume their executive role.
>
> Moreover, in a technological race, the acceleration vector is a decisive factor that makes the
difference. Global adoption will be conquered by the blockchain capable of evolving
technologically at a faster rate.
>
> For a successful global adoption to be possible, Bitcoin miners must coordinate effectively.

Extract from [The Bitcoin Mining Parliament](https://virtualpol.com/BMP_EN.pdf) by Javier González González (2018-06-15).
<br />

> We need stop the regular hard fork of Bitcoin Cash. We need stable Bitcoin protocol specification, We need multiple implementation. There should not be dev decide but miner vote.

Tweet by [Haipo Yang](https://twitter.com/yhaiyang/status/1027914585607626752) (2018-08-10).
<br />

> We need a decision making process for changing and improving the protocol.

!!!!!!!!!!!!!!!! Specification by Jihan Wu (2018-08-30).
<br />

> No matter the outcome, this war will display the power and influence of the hashrate and this would potentially put weight on the importance of hashrate in the ecosystem. This lays the ground of using hashrate as the deciding factor for future Bitcoin splits. BTC, BCH, BSV and other coins which have same consensus algorithm and yet splits will eventually be unified.

Extract from [ABC vs BSV Hash War (Part III)](https://medium.com/@jiangzhuoer/abc-vs-bsv-hash-war-part-iii-the-war-of-the-hash-power-45fef8010467) by Jiang Zhuoer (2018-11-14).


## How

Voting with hashpower -to discover consensus- in the safest voting system known by mankind.

[BMP](https://bmp.virtualpol.com) is a [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) system completely on-chain, verifiable and replicable.

BMP is connected to a BCH client by RPC to read blocks and transactions. 

On-chain data is transformed with PHP in 3 SQL tables: **[blocks](https://bmp.virtualpol.com/info/blocks)**, **[miners](https://bmp.virtualpol.com/info/miners)** and **[actions](https://bmp.virtualpol.com/info/actions)**.

Actions are composed in JavaScript and broadcast with the Trezor API (soon more hardware wallets).

BMP does not store any private key. The entire BMP database is public information.

More in **[BMP Protocol](https://bmp.virtualpol.com/protocol)** and BMP paper in [Chinese](https://virtualpol.com/BMP_CN.pdf), [English](https://virtualpol.com/BMP_EN.pdf) and [Spanish](https://virtualpol.com/BMP_ES.pdf).


## What

#### https://bmp.virtualpol.com

<br />

### Requirements to participate

1. Your address inside a coinbase output in the last `2016` BCH blocks.
2. Trezor.

### Requirements to deploy

1. Bitcoin ABC client with `-index`
2. GNU/Linux
3. Apache
4. MariaDB or MySQL database
5. PHP

### Tested environment

* x86_64 SSD
* CentOS 7.6 
* Bitcoin ABC 0.19.7
* PHP 7.1
* MariaDB 5.5
* Chrome 74
* Trezor Model T 2.1

### How to deploy

1. Put the BMP code in the `www` http directory.
2. Configure RPC and SQL access by creating `autoload/_password.php`.
3. Execute `scheme.sql` in a new database.
4. Configure a `crontab` every minute with: `curl http://localhost/update`.
5. Wait for synchronization.

### Known problems

* OP_RETURN size too small because Trezor hardware limits (?).
* More hardware wallets support.
* Chat moderation.
* Asian characters don't work.
* Internationalization.
* Much more features.
* Absolute power corrupts absolutely.

---------

[Javier González González](https://www.linkedin.com/in/javiergonzalezgonzalez/)<br />BMP Architect