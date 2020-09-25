#比特币挖矿议会（The Bitcoin Mining Parliament，简称为BMP）

这是一个开源工具，不需要第三方为使用爱工具负责

<p align="center">
<img src="https://github.com/JavierGonzalez/BMP/blob/master/static/logos/main_full.png?raw=true" width="400" height="400" alt="BMP logo" />
</p>


##为什么选择比特币矿业议会?

[比特币矿业议会](https://bmp.virtualpol.com) （BMP）是一个协议和以哈希算力（hashpower）为基础的投票系统，它是去中心化、链上、开源、可验证、易于使用、简单、可扩展、自愿、抵抗外部干扰和中立的。

在比特币现金的内部分歧中，BMP不会偏袒任何一方。BMP是一种与链上数据一起工作的中立协议。它和比特币现金区块链一样安全。

BMP是一个链上的比特币现金管理协议，它能够使矿工们协调他们的行动，从而给BCH生态系统带来更大的安全性和确定性。矿工们和任何受委托的代理都可以使用自己手中的算力进行讨论和投票，在共识前阶段对[中本聪共识（Nakamoto Consensus）](https://bmp.virtualpol.com/bitcoin.pdf)进行扩展。

BMP使过去28天内挖出BCH区块的矿工们能够以完美的方式让自己的声音被更多的人听到。BMP可以作为比特币现金治理的重要工具，从而减少分叉、内斗和纠纷等事件发生的可能性。

##  BMP的特性
* 去中心化、链上、可验证。
* 硬件钱包身份验证。
* 实时聊天。
* 可选多区块链SHA-256 哈希算力整合。
* 投票(多投/多选项，可纠正误投，区块链过滤，评论)
* BMP可以精确计算每台矿机的哈希算力(而不仅仅只是矿池)。

BMP是一个[LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) web系统，它可以连接到一个或多个比特币客户端(通过RPC)来读取区块和交易。区块链数据被[这个PHP代码](https://github.com/JavierGonzalez/BMP/blob/master/+bmp/bmp.php)处理在三个SQL缓存表中:[Blocks](https://bmp.virtualpol.com/info/blocks)， [Miners](https://bmp.virtualpol.com/info/miners)和[Actions](https://bmp.virtualpol.com/info/actions)。

Actions被存储在比特币现金(BCH)中，因为它快速、廉价并稳定。
没有哈希速率的操Actions将被忽略。矿机的算力(哈希速率的百分比)会随区块的变化而变化。但算力的Action永不改变。

Action用JavaScript来编写，并通过 `Trezor Connect` 进行广播。未来会有更多的硬件钱包开放BMP功能。

BMP不存储私钥，本地数据库只包含公共信息。

更多细节可在[BMP协议](https://bmp.virtualpol.com/protocol)和[BMP paper EN](https://virtualpol.com/BMP_CN.pdf) | [ZH](https://virtualpol.com/BMP_CN.pdf) | [ES](https://virtualpol.com/BMP_ES.pdf)中获得。


###参与要求

1. 您的地址在coinbase输出中，位于您正在挖的加密货币的最后‘4032个区块’中，可以是BTC、BCH或BSV。
2. 推荐使用Trezor硬件钱包。使用一个新的Trezor帐户(有支付交易费用的钱)。

BMP分别为BCH、BTC和BSV工作。

###如何手动创建Action

如果您没有Trezor硬件钱包，您可以创建手动交易。

* 每个矿机操作都是BCH中的标准事务(transaction)。
* BMP操作使用<a href="https://memo.cash" target="_blank">Memo.cash</a>风格。
* 无论是BTC、BCH还是BSV，矿工的地址必须在您正在挖矿并希望参与的加密货币的最后`4032块`的coinbase VOUT中。
* 矿机的地址必须在TX_PREV VOUT(任何索引)。
* 矿机的地址必须在VOUT索引=0。
* OP_RETURN有效负载在VOUT的index=1。
* OP_RETURN前缀: `0x9d`。
* OP_RETURN尊重[BMP协议](https://bmp.virtualpol.com/protocol)。

BMP通过web简化了 `OP_RETURN hex`（十六进制）。

下面是一些手动操作的例子:
-  [聊天](https://blockchair.com/bitcoin-cash/transaction/91162d0670c72fca6622d117e4d6b4149a3855de780295e852e471504b937c14)
[投票](https://blockchair.com/bitcoin-cash/transaction/2c4219ce4533759a5886839d03494420e92c5add807c010c4b507b347b3b0e21)


###信号和哈希算力委托

1. **`power_by_value`** 
默认情况下，BMP使用coinbase `value` 计算每个输出地址的哈希算力所占的百分比。这使得它与所有的比特币区块兼容。有了 `P2Pool`，即使最小的矿工现在也可以参与进来。

2. **`power_by_opreturn`**
为了不影响挖矿操作，第二种方法允许在一个或多个地址中使用coinbase OP_RETURN输出哈希算力 coinbase 信号。这忽略了 `value`，并允许完全的哈希算力委托，而且很简单。

3. **`power_by_action`**
正在发展中。为了获得整体的灵活性，BMP将允许使用非coinbase BMP协议操作将哈希算力的百分比委托给一个或多个地址。同样，它允许您修改或撤销哈希算力的委托，并立即生效。

使用BMP，挖矿人员可以将任意百分比的哈希算力委托给其他人参与。这样，矿工们可以以更灵活和更负责的方式独自、并且可撤销地指定代表。

###如何部署自己的BMP服务器

#### 要求

* Web服务器(GNU/Linux, Apache, MySQL, PHP)。
* +1 TB空闲空间和+8 GB RAM。
* 比特币BCH客户端，带有 `-txindex`。
* 比特币比特币客户端，带有 `-txindex` 可选。
* 比特币BSV客户端，带有 `-txindex` 可选。

#### 部署

1. 将BMP代码放到 `www` httpd公共目录中。
2. 在一个新的MySQL数据库中执行`scheme.sql`。
3. 重新向`+passwords.ini`中命名。
4. 配置RPC和SQL访问。
5. 等到比特币客户是最新的。
6. 每分钟设置一个 `crontab` 执行: `curl https://bmp.your-domain.com/update`
7. 等待BMP同步(~24h)。检查进度: `/stats`

#### 测试环境

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
* Trezor Model T(推荐)。
* Trezor One(部分功能，因为OP_RETURN大小有限)。

###已知问题

* 区块链同步时间。
* 链上重组更新。
* 汉语和西班牙语国际化。
* 更多的硬件钱包支持。
* 类似IRC的经典聊天攻击。
* 正式规范。
* 自动测试。
* 绝对权力绝对腐败。


##常见问题解答

#### BMP背后的意图是什么?

* 在共识达成前阶段扩大中本聪共识。
* 为了更准确地发现中本共识，不仅可以通过block信号，还可以通过聊天和投票。
* 促进协调中本共识。
* 让矿工们实现比特币白皮书的愿景，实现全球采用和更自由世界。

#### BMP是如何工作的?

BMP是一个协议、一个链上系统和一个web接口。它监听比特币区块，根据coinbase信号计算每个BCH地址的精确比例哈速率。这些就像一个去中心化的现代社交网络(比如[memo.cash](https://memo.cash))，允许矿工聊天和投票。

#### 如何排除非BCH SHA256矿工?

BMP活动很容易被区块链过滤或仅连接到BCH区块链。此外，BMP用户的精确比例哈希幂是根据最近的4,032块计算的，也就是前28天。因此，矿工在参与BMP之前必须在游戏中演示皮肤。

#### BMP预先达成共识的过程是否具有约束力?

今天，BMP将中本共识扩展到共识前阶段。BMP允许矿工以完美的方式协调他们的行动(中本聪共识)。BMP提供了一个以前不存在的通信通道。通过这种方式，它增加了巨大的价值。

未来可以在节点中实现BMP协议，例如在consensus阶段执行预定义参数的设置。

#### 这和矿工发表公开声明有什么不同?

有很多不同之处，包括以下几点

* 使用BMP，您可以“毫无疑问地”验证与每个操作关联的哈希算力的多少。
* 所有BMP的action在链上签名都是“永久的”。
* BMP允许矿工们用现代社交网络的舒适和深度通过哈希算力进行谈话和投票，包括通过实时聊天和投票。
* BMP允许所有矿工（即使是最小的矿工）参与，不仅仅是矿池。
* BMP还允许任意百分比的哈希速率委托给任何BCH地址。

这些都是BMP首次引入的重大创新，可以产生重大影响。

#### BMP试图解决的根本问题是什么?

根本问题主要是一个政治问题:一群人必须事先达成共识，然后共同行动，而不存在一个中央权威。

这是一个政治问题，最初只能通过对话和外交解决。

预先共识存在于共识之前。它发生。只有预先共识存在，真正的共识才能发生。

#### 什么是委托，它如何增加价值?

有一些操作允许将您自己的哈希速率的一定百分比分配给不同的地址，以便在BMP聊天和投票功能中使用。BMP尊重矿工的自愿决定。多亏有了BMP，这才使这些第一次成为可能。


#### 这和一个基金会比起来有何么不同?

BMP可以被视为一个“股东大会”或一个基金会。但这将是一个链上的基础，因此，它是坚不可摧并且长期稳定存在的。

以民族国家许可为例的基础要服从国家法律、法律程序和人类的政治活动。它们可能被法律腐蚀。但是BMP只认可工作量证明。与比特币现金区块链本身一样，BMP对传统中间人(如民族国家)的干预也持抵制态度。


#### 我如何作为一个非矿工信号支持BMP并鼓励矿工使用它?

通过阅读下面的信息来提醒自己。广泛分享这些信息。鼓励矿工参与。


##更多信息
* [Why Bitcoin Cash Needs the BMP?](https://read.cash/@JavierGonzalez/why-bitcoin-cash-need-the-bmp-1a6ab975)
* [为什么比特币现金需要BMP系统?](https://read.cash/@JavierGonzalez/bmp-6bc8ea63)
* [¿Por qué Bitcoin Cash necesita el BMP?](https://read.cash/@JavierGonzalez/por-que-bitcoin-cash-necesita-el-bmp-e6a746a3)
* [https://twitter.com/askthebmp](https://twitter.com/askthebmp)
* [https://read.cash/@AskTheBMP](https://read.cash/@AskTheBMP)


[哈维尔·冈萨雷斯·冈萨雷斯](https://twitter.com/JavierGonzalez)<br />
gonzo@virtualpol.com<br />
BMP Architect