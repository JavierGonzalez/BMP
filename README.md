# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES.

------

## Why

Extract from [Bitcoin: A Peer-to-Peer Electronic Cash System](https://www.bitcoin.com/bitcoin.pdf) by Satoshi Nakamoto (2008-10):

> Any needed rules and incentives can be enforced with this consensus mechanism.

Tweet by [Roger Ver](https://twitter.com/rogerkver/status/649991677721972736) (2015-10-02):

> If freedom is the why,  Bitcoin is the how.

Extract from [Miners are the executive power of Bitcoin](https://virtualpol.com/Miners_are_the_executive_power_of_Bitcoin_EN.pdf) by Javier González González (2017-10-31):

> As a new form of executive power, it is likely that in the near future a virtual and transparent
Bitcoin Mining Parliament (BMP) will be established. There each participant can have voice
and vote in proportion to their percentage of demonstrable exahases per second.

Extract from [The Bitcoin Mining Parliament](https://virtualpol.com/BMP_EN.pdf) by Javier González González (2018-06-15):

> Currently, the Bitcoin miners estimate consensus with inadequate coordination.

> This causes contentious hardforks that divide the blockchain, fracture the community, create
confusion and damage adoption. Miners can take responsibility, better than anyone else, for
preventing the risk of such events happening again.

> In the process of technological development, often crossroads arise with two valid but
incompatible solutions in the same blockchain. Therefore, technological development
requires decision-making.

> The human tendency to become entangled in conflict is a predictable pattern. With multiple
development teams competing, confrontation is only a matter of time. To resolve this, miners
must assume their executive role.

> Moreover, in a technological race, the acceleration vector is a decisive factor that makes the
difference. Global adoption will be conquered by the blockchain capable of evolving
technologically at a faster rate.

> For a successful global adoption to be possible, Bitcoin miners must coordinate effectively.

Tweet by [Haipo Yang](https://twitter.com/yhaiyang/status/1027914585607626752) (2018-08-10):

> We need stop the regular hard fork of Bitcoin Cash. We need stable Bitcoin protocol specificatoon, We need multiple implementation. There should not be dev decide but miner vote.

Text by Jihan Wu (2018-08-30):

> We need a decision making process for changing and improving the protocol.

Extract from [ABC vs BSV Hash War (Part III)](https://medium.com/@jiangzhuoer/abc-vs-bsv-hash-war-part-iii-the-war-of-the-hash-power-45fef8010467) by Jiang Zhuoer (2018-11-14):

> No matter the outcome, this war will display the power and influence of the hashrate and this would potentially put weight on the importance of hashrate in the ecosystem. This lays the ground of using hashrate as the deciding factor for future Bitcoin splits. BTC, BCH, BSV and other coins which have same consensus algorithm and yet splits will eventually be unified.


## How

Voting with hashpower.

Bitcoin is the safest voting system known.

BMP is a LAMP system (Linux, Apache, MySQL and PHP) completely on-chain.

BMP connects to a Bitcoin Cash client by RPC, to read blocks and transactions. 

The on-chain information is transformed with PHP in 3 tables: blocks, miners and actions.

Actions are composed in JavaScript and send with the Trezor API.

Actions without hashpower are ignored.

See more in: [**BMP Protocol**](https://bmp.virtualpol.com/protocol) and BMP paper in [English](https://virtualpol.com/BMP_EN.pdf), [Chinese](https://virtualpol.com/BMP_CN.pdf) and [Spanish](https://virtualpol.com/BMP_ES.pdf).

## What

**https://bmp.virtualpol.com**

### Requirements for use

* Your address situated in a coinbase output in the last 2016 BCH blocks (hashpower required).
* Trezor.

### Requirements to deploy

...

### How to deploy

...

### Known problems

...

---------

Javier González González

BMP Architect
