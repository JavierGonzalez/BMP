### 2020-08-18 [BMP 0.4.2](https://github.com/JavierGonzalez/BMP)
* BMP `BLOCK_WINDOW` changed from `2,016` to `4,032` blocks. Decided by [this voting](https://bmp.virtualpol.com/voting/67302f9a415ac5956403720793b92055a0b63342ee6848c65083e4a21ff88008).
* PHP framework refact (Maxsim 0.5.2).
* Multiple optimizations.
* External verification with links to "blockchair.com" explorer.
* Default vote name changed from `NULL` to `NEUTRAL`.
* New `type_voting` added: `Decisive in BMP` (majority not required to be valid).
* pools.json updated.
* Minor fixes.


### 2020-06-28 [BMP 0.4.1](https://github.com/JavierGonzalez/BMP/commit/742348f1b404fe53bf2812061a2017aec960173f)
* New framework, major version.
* Optimizations.
* pools.json updated.
* Minor fixes.


### 2020-05-10 [BMP 0.4.0](https://github.com/JavierGonzalez/BMP/tree/9865b620abbaec2988bae742df27fef6cbd22bb8)
* Full-consistent hashpower voting (production-ready!).
* Inmutable votes when voting status is `closed`.
* Votes can be filtered by blockchain in every voting.
* Voting type selector: Informative, Decisive 51%, Decisive 66%.
* OP_RETURN preview in every action, to facilitate manual actions.
* Efficiency improvements.


### 2020-02-13 [BMP 0.3.0](https://github.com/JavierGonzalez/BMP/tree/0e5001b6e8e8d35a1a2d036a93cb6d4a3f8e25b9)
* [Video DEMO 1](https://www.youtube.com/watch?v=6ZBe5wl1Uas).
* Trezor Model T compatibility.
* Bugs fixed.


### 2019-08-26 [BMP 0.2.0](https://github.com/JavierGonzalez/BMP/tree/533d7d20dba5313cefaa761ef3801c8799b77962)
* Multi-blockchain implementation (BTC+BCH+BSV).
* Performance improvements.
* Bugs fixed.


### 2019-06-28 [BMP 0.1.0](https://github.com/JavierGonzalez/BMP/tree/b0720643b294c13d2305f92ee49759136414478f)
* Maxsim PHP framework.
* Miners hashpower calculation by value.
* Miners hashpower calculation by op_return (not tested).
* Chat.
* Voting system.
* Miner parameter: nick.
* Tested with P2Pool.
* [Announcement](https://twitter.com/JavierGonzalez/status/1144613230872014848).
* BMP Architect: Javier González González <gonzo@virtualpol.com>