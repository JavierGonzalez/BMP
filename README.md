# The Bitcoin Mining Parliament

THIS IS AN OPEN-SOURCE TOOL WITH NO RESPONSIBILITY FOR ACTIONS TAKEN BY THIRD PARTIES


<p align="center">
<img src="https://github.com/JavierGonzalez/BMP/blob/master/static/logos/main_full.png?raw=true" width="400" height="400" alt="BMP logo" />
</p>



## Why the Bitcoin Mining Parliament?

The [Bitcoin Mining Parliament](https://bmp.virtualpol.com) (BMP) is a protocol and hashpower voting system, decentralized, on-chain, open-source, verifiable, easy to use, simple, extensible, voluntary, neutral and resistant to outside interference. 

The BMP takes no sides in internal Bitcoin Cash disagreements. The BMP is a neutral protocol that works with on-chain data. It is as secure as the Bitcoin Cash blockchain.

The BMP is an on-chain Bitcoin Cash governance protocol that enables miners to coordinate their actions, and thus bring greater certainty to the BCH ecosystem. Miners, and any delegated agents, can talk and vote with their hashpower, simply extending the [Nakamoto Consensus](https://bmp.virtualpol.com/bitcoin.pdf) in a pre-consensus phase. 

The BMP empowers the miners of the last 28 days of BCH blocks to make themselves heard, with a perfect signal to noise ratio. The BMP can serve as an important tool for Bitcoin Cash governance, reducing forking, infighting and disputes.

<br  />

## BMP Features
- Decentralized, on-chain, verifiable.
- Hardware-wallet authentication.
- Real-time chat.
- Optional multi-blockchain SHA-256 hashpower merging.
- Voting (multiple points/options, rectifiable votes, filter by blockchain, comments).
- BMP can calculate the exact hashpower of each individual miner (not just pools).

BMP is a [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) web system, connected to a one or more Bitcoin clients (via RPC) to read blocks and transactions. Blockchain data is processed with [this PHP code](https://github.com/JavierGonzalez/BMP/blob/master/+bmp/bmp.php) in three SQL cache tables: [Blocks](https://bmp.virtualpol.com/info/blocks), [Miners](https://bmp.virtualpol.com/info/miners) and [Actions](https://bmp.virtualpol.com/info/actions).

Actions are stored in Bitcoin Cash (BCH) because it is fast, cheap and stable.

Actions without hashpower are ignored. Miners power (% of hashpower) changes with each block. Actions power never changes.

Actions are composed in JavaScript and broadcast with `Trezor Connect`. More hardware wallets will be available in the future.

BMP does not store private keys and the local database only contains public information.

More details are available in the [BMP Protocol](https://bmp.virtualpol.com/protocol) and the [BMP paper EN](https://virtualpol.com/BMP_EN.pdf) | [ZH](https://virtualpol.com/BMP_CN.pdf) | [ES](https://virtualpol.com/BMP_ES.pdf).

<br  />

### Requirements to participate

1. Your address is inside a coinbase output in the last `4,032 blocks` of Bitcoin Cash (BCH).
2. Recommended: Trezor hardware wallet (Use a new account, with fund for fees only).

<br  />

### Hashpower signaling

- **`power_by_value`** 
By default, the BMP calculates the proportional hashpower percentage of each output address with the coinbase `value`. This makes it compatible with all Bitcoin blocks. This is compatible with all blocks.

- **`power_by_opreturn`**
In order not to interfere with mining operations, this second method allows hashpower coinbase signal in one or multiple addresses with coinbase OP_RETURN output. This ignores `value`, and allows full hashpower delegation, with simplicity.


- **`power_by_action`**
In development. For total flexibility, BMP will allow delegation of a % of hashpower to one or many addresses with a non-coinbase BMP protocol action. In the same way, it will allow you to modify or revoke that hashpower delegation with immediate effect from the next block.

With the BMP, miners can delegate arbitrary percentages of hashpower to other people to participate. In this way, miners can individually and revocably designate representatives in a fluid and accountable manner.

<br  />

## HOW-TO


### 1) How to participate with a Trezor hardware wallet

1. Access a [BMP server](https://bmp.virtualpol.com). For example: `https://BMP.virtualpol.com`
2. Confirm that your address (legacy format) is included in [/info/miners](https://bmp.virtualpol.com/info/miners).
3. Plug in your [Trezor](http://trezor.io/) by USB.
4. Click on the yellow `Login` button (top right) and accept.
5. A popup will open in the Trezor web infrastructure. Accept and select the account from your address. If the popup does not open, then disable your ad blocker or similar programs that can prevent pop-ups.
6. Then, the BMP will show your logged-in address (top right).
7. You are ready to participate! You can write in the chat, create a vote or vote.


### 2) How to create actions manually

* Each miner action is a standard transaction in BCH.
* BMP actions use the <a href="https://memo.cash" target="_blank">Memo.cash</a> style.
* The miner’s address must be in the coinbase VOUT in one of the last `4,032 blocks` of Bitcoin Cash (BCH).
* The miner’s address must be in the TX_PREV VOUT (Any index).
* The miner’s address must be in VOUT index=0.
* OP_RETURN payload in VOUT index=1. 
* OP_RETURN prefix: `0x9d`.
* OP_RETURN respecting [BMP Protocol](https://bmp.virtualpol.com/protocol). BMP web facilitates the `OP_RETURN hex`.

Some examples of actions: [chat](https://blockchair.com/bitcoin-cash/transaction/91162d0670c72fca6622d117e4d6b4149a3855de780295e852e471504b937c14), [vote](https://blockchair.com/bitcoin-cash/transaction/2c4219ce4533759a5886839d03494420e92c5add807c010c4b507b347b3b0e21).


### 3) How to signal hashpower with P2Pool

With P2Pool, even the smallest miner can participate right now.

This decentralized pool rewards all participating miners by including their addresses in the coinbase transaction output. And this information is all the BMP needs to enable even the smallest miners to participate.

1. Start mining on a P2Pool node normally. For example: `stratum+tcp://p2pool.imaginary.cash:9348`
2. The user is your address (legacy format).
3. That is all! 

When P2Pool makes a new block, all BMP servers will recognize and calculate the hashpower associated with your address and you can participate. This uses the `power_by_value` hashpower signal method.


### 4) How to delegate hashpower with `power_by_opreturn`

If you can make blocks solo (you are a pool or big miner) you can delegate arbitrary percentages of hashpower to one or more addresses, without altering the `value` (block reward). This allows the implementation of the [BMP protocol](https://bmp.virtualpol.com/protocol) in any sophisticated system, without interfering with the mining operation.

As an example, let's suppose that we want to assign the hashpower of our blocks in the following way:
- 20% of hashpower to address: 1AAtD721LQekC6ncHbAp4ScKxSwR7fFeYT
- 80% of hashpower to address: 1AioJWvdeQq8ddzgz4mvywoBjfrqVQsD1s

1. Include in the `block template` this hexadecimal codes, in two OP_RETURN outputs, inside the coinbase transaction:
	- `0x9d000007d031414174443732314c51656b43366e63486241703453634b78537752376646655954`
	- `0x9d00001f403141696f4a5776646551713864647a677a346d7679776f426a667271565173443173`
2. After a new block, check [/info/miners](https://bmp.virtualpol.com/info/miners) and verify that the addresses appear in with their proportional hashpower.

- `0x` Indicates that the code below is hexadecimal.
- `9d` It is the [BMP protocol](https://bmp.virtualpol.com/protocol) prefix. First OP_RETURN byte. 
- `00` Is the identifier of the `power_by_opreturn` hashpower signal mode (for that block).
- `0007d0` in decimal represents `2000` which in means `20.00%` of hashpower.
- `31414174443732314c51656b43366e63486241703453634b78537752376646655954` is the address, in legacy format, coded with `bin2hex()`.

This functionality has not been tested on mainet. Please write to gonzo@virtualpol.com or use the Github issues for support.


### 5) How to deploy your own BMP server

1. Put the BMP code in the `www` httpd public directory.
2. Execute `scheme.sql` in a new MySQL database.
3. Re-name the file `+passwords.ini.template` in to `+passwords.ini`.
4. Configure RPC and SQL access.
5. Wait until the Bitcoin clients are up-to-date.
6. Set a `crontab` every minute executing: `curl https://bmp.your-domain.com/update`
7. Wait for the BMP synchronization (~16h). Check progress in: `/stats`

Requirements:
* Web server (GNU/Linux, Apache, MySQL, PHP).
* +1 TB free space and +8 GB RAM.
* Bitcoin BCH client, with `-txindex`.

<br  />

## FAQ

### 1) What is the intention behind the BMP?

- To extend Nakamoto Consensus in pre-consensus phase. 
- To discover Nakamoto Consensus more precisely, not just via block signals but also via chat and polling.
- To facilitate coordination of Nakamoto Consensus.
- To empower miners to realize the Bitcoin whitepaper vision for global adoption and a freer world.

### 2) How does the BMP work?

The BMP is a protocol, an on-chain system and a web interface. It listens to Bitcoin blocks to calculate the exact proportional hashpower of each BCH address, according to the coinbase signal. The actions work like a decentralized modern social network (like [memo.cash](https://memo.cash)), and permit miners to chat and vote in polls.

### 3) How are non-BCH SHA256 miners excluded?

BMP activity is easily filtered by blockchain or connected to BCH blockchain only. Further, the exact proportional hashpower of a BMP user is calculated from the last 4,032 blocks — the preceding 28 days. Therefore, miners must demonstrate skin in the game before participating in the BMP.

### 4) Is the BMP pre-consensus process binding?

Today BMP extends Nakamoto Consensus in a pre-consensus phase. The BMP permits miners to coordinate their actions (Nakamoto Consensus) with a perfect signal-to-noise ratio. The BMP provides a communication channel that did not previously exist. In this way, it adds enormous value. 

In the future, the BMP protocol can be implemented in the nodes, for example, to execute the setting of pre-defined parameters in the consensus phase.

### 5) How is this any different from a miner issuing a public statement?

There are many differences, including the following

- With the BMP, you can verify "beyond all doubt" the amount of hashpower associated with each action.
- All BMP actions are signed on-chain "forever".
- The BMP allows miners to talk and vote with hashpower with the comfort and depth of a modern social network, including via live chat and vote polling.
- The BMP allows all miners to participate, even the smallest ones. Not just pools.
- The BMP also allows the delegation of an arbitrary percentages of hashpower to any BCH address.

These are all significant innovations introduced by the BMP for the first time that can make a difference.

### 6) What is the root problem the BMP is trying to solve?

The root problem is mostly a political one: a group of humans have to agree beforehand, and then act together, without the existence of a central authority.

It is a political problem and the solution initially can only be through dialogue and diplomacy.

Pre-consensus exists before consensus. It happens first. Only when pre-consensus exists, can consensus take place.

### 7) What is delegation and how does that add value?

There are actions that allow a percentage of your own hashpower to be assigned to a different address for use in the BMP chat and voting functions. The BMP respects this voluntary decision of the miner with accuracy. This is possible for the first time thanks to the BMP.


### 8) How does this compare to a foundation?

The BMP can be considered a "shareholder meeting” or a foundation. But it will be an on-chain foundation and, therefore, indestructible and stable in the long-term.


### 9) How can I as a non-miner signal support for the BMP and encourage miners to use it?

Inform yourself by reading the information below. Share this information widely. Encourage miners to participate.


<br  />


## Tested environments

* x86_64 GNU/Linux CentOS 7.8
* PHP 8
* MariaDB 5.5
* MySQL 5
* Firefox 67
* Chrome 74
* Bitcoin Unlimited 1.9.0
* P2Pool 17.0
* Trezor Model T (recomended).
* Trezor One (partially functional because a limited OP_RETURN size).


## Known problems

* Update when chain reorg.
* Chinese internationalization.
* More hardware wallets support.
* IRC-like classic attacks in chat.
* Automatic testing.
* Formal specification.
* Absolute power corrupts absolutely.


## More information
- [Why Bitcoin Cash Needs the BMP?](https://read.cash/@JavierGonzalez/why-bitcoin-cash-need-the-bmp-1a6ab975)
- [为什么比特币现金需要BMP系统?](https://read.cash/@JavierGonzalez/bmp-6bc8ea63)
- [¿Por qué Bitcoin Cash necesita el BMP?](https://read.cash/@JavierGonzalez/por-que-bitcoin-cash-necesita-el-bmp-e6a746a3)
- [https://twitter.com/askthebmp](https://twitter.com/askthebmp)
- [https://read.cash/@AskTheBMP](https://read.cash/@AskTheBMP)
- [Code Github](https://github.com/JavierGonzalez/BMP)


[Javier González González](https://twitter.com/JavierGonzalez)<br />
gonzo@virtualpol.com<br />
BMP Architect
