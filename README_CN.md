# 比特币挖矿议会

本决议为开源工具，不对第三方采取的行动负责。


<p align="center">
<img src="https://github.com/JavierGonzalez/BMP/blob/master/static/logos/main_full.png?raw=true" width="400" height="400" alt="BMP logo" />
</p>


## 为什么要成立比特币挖矿议会？

比特币挖矿议会(BMP)是一份协议和算力投票系统，去中心化、链上化、开源、可验证、易用、简单、可扩展、自愿参与、中立、抗外界干扰。 

BMP在比特币现金内部的分歧中不选边站队。BMP是一个中立的协议，工作中使用链上数据。它和比特币现金区块链一样安全。

BMP是一份链上的比特币现金治理协议，借助此份协议，矿工们能够协调行动，从而为比特币现金生态系统带来更大的确定性。矿工，以及他们的任何委托代理人都可以使用他们的算力进行对话和投票，只为在前期共识阶段扩展了中本聪共识。 

BMP赋予比特币现金区块最后28天的矿工们完美的信噪比，能让更多人听到矿工们的声音。BMP可以作为比特币现金治理的重要工具，减少分叉、内斗和纠纷。

<br />

## BMP 特性
- 去中心化，链上，可验证

- 硬件钱包认证

- 实时聊天。

- 可选择多条SHA-256链，合并算力。

- 投票（多点/选项、可纠错投票、区块链过滤、评论）。

- BMP可以准确计算出单个矿工的算力（不仅仅是矿池）。

BMP是一个[LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle))网页系统，（通过RPC）连接到一个或多个比特币客户端读取区块和交易数据。借助这段[PHP代码](https://github.com/JavierGonzalez/BMP/blob/master/+bmp/bmp.php)，BMP可在三个SQL缓存表中处理区块链数据。这三个表分别是：区块、矿工和动作。

动作存储在比特币现金（BCH）中，因为BCH快速、便宜、稳定。

没有算力的动作会被忽略。每个区块，矿工的算力（算力百分比）都会变动一次。动作算力保持不变。

动作由JavaScript编写，并通过Trezor Connect进行广播。未来会支持更多的硬件钱包。

BMP不存储私钥，本地数据库只包含公开信息。

更多详情，请参看 [BMP 协议](https://bmp.virtualpol.com/protocol) 和 [BMP 论文 EN](https://virtualpol.com/BMP_EN.pdf) | [中文](https://virtualpol.com/BMP_CN.pdf) | [ES](https://virtualpol.com/BMP_ES.pdf).

<br />

### 参与要求

1. 您的地址可在您当前挖矿币种的最后`4,032`个区块爆块输出里面找到，BCH。

2. 推荐使用：Trezor硬件钱包（使用一个新账户，账户里只需要预存少量手续费即可）

<br  />

### 算力信号

- **power_by_value** 
 默认情况下，BMP会计算每个输出地址与power_by_value的算力百分比。如此，它才能与所有比特币区块兼容。此参数与所有区块兼容。

- **power_by_opreturn** 
 为了不影响正常挖矿，使用第二种方法，矿工们可在一个或多个地址中用爆块的OP_RETURN输出信号。 这样可以忽略值，并允许完全的算力委托，简单明了。 

通过BMP，矿工可以将任意比例的算力委托给其他人，方便他们参与。通过这种方式，矿工可以以流畅和负责任的方式单独地委托算力，也可撤销委托。



## 如何操作

### 1）如何用Trezor硬件钱包参与？

1. 访问BMP服务器。例如：https://BMP.virtualpol.com

2. 确认您的地址（传统格式）已包含在[/info/miners](https://bmp.virtualpol.com/info/miners)中。

3. 插入您的Trezor硬件钱包USB接口。

4. 点击右上角的黄色按钮登录，并接受。

5. 在Trezor网络基础设施中会打开一个弹出窗口。选择接受，并从您的地址中选择一个账户。如果弹出窗口没有打开，那么请关闭您的广告拦截器或类似的程序，它们会阻止弹出窗口。

6. 然后，BMP会显示你的登录地址（右上角）。

7. 您现在可以参与了！您可以在聊天窗中打字，创建一个投票活动或进行投票。



### 2) 如何手动创建动作

- 每一个矿工动作都是BCH的标准交易。

- BCH动作使用`Memo.cash`样式。

- 矿工的地址可在您当前挖矿币种的最后`4,032` 个区块爆块输出里面找到 BCH。

- 矿工的地址必须是TX_PREV VOUT格式 (任意索引).

- 矿工的地址必须在VOUT中，索引=0。

- OP_RETURN 负载在 VOUT中 index=1. 

- OP_RETURN 前缀: `0x9d`.

- OP_RETURN遵守BMP协议。*BMP web**有利于 `OP_RETURN hex`**。*

一些动作例子：聊天，投票。

### 3）如何用P2Pool发出算力信号。

推荐使用P2Pool, 即使体量很小的矿工，现在也可以参与。

这个去中心化的矿池通过在爆块交易输出中包含矿工的地址的方式，来奖励所有参与的矿工。而这些信息就是BMP所需要的所有信息，即使是最小的矿工也能参与其中。

1. 在P2Pool的节点上正常挖矿。例如：`stratum+tcp://p2pool.imaginary.cash:9348`。

2. 用户就是您的地址（传统格式）。

3. 以上就是所有内容！ 

当P2Pool爆出一个新的区块时，所有的BMP服务器都会识别并计算出与你的地址相关的算力，你就可以参与其中。这里使用power_by_value发出算力信号。



### 4) 如何使用 `power_by_opreturn` 委托算力

如果你可以单独爆块（您是一个矿池或大矿工），你可以将任意百分比的算力委托给一个或多个地址，而不改变价值（区块奖励）。这样，您可以在任何复杂的系统中应用BMP协议，而不干扰挖矿操作。

举个例子，假设我们想用下面的方式来分配区块的算力。

- 委托20%的算力至以下地址：`1AAtD721LQekC6ncHbAp4ScKxSwR7fFeYT`
- 委托80%的算力至以下地址：`1AioJWvdeQq8ddzgz4mvywoBjfrqVQsD1s`

1. 在区块模板中包含这个十六进制代码，在爆块交易里的两个OP_RETURN输出中，

- `0x9d000007d031414174443732314c51656b43366e63486241703453634b78537752376646655954`
- `0x9d00001f403141696f4a5776646551713864647a677a346d7679776f426a667271565173443173`


2. 在新爆块之后，检查[/info/miners](https://bmp.virtualpol.com/info/miners), 并验证地址，检查是否显示了成比例的算力值。

- `0x` 表示之后的代码是十六进制。

- `9d` 是BMP协议的前缀。第一个 `OP_RETURN` 字节。 

- `00` 是 `power_by_opreturn` 算力信号模式的标识符（针对该块）。

- `0007d0` 在十进制中代表 `2000`，意味着 `20.00%` 的算力。

- `31414174443732314c51656b43366e63486241703453634b78537752376646655954` 是传统格式的地址，使用 `bin2hex()` 编码。

此功能尚未在主网上测试。请发邮件至 `gonzo@virtualpol.com`，或使用Github issues，寻求支持。



### 5) 如何部署您自己的BMP服务器

1. 将BMP代码放入www httpd公共目录中。

2. 创建一个MySQL数据库，执行 `scheme.sql`

3. 将文件 `+passwords.ini.template` 重新命名为 `+passwords.ini`

4. 配置RPC和SQL访问。

5. 等待比特币客户端更新。

6. 每分钟设置一个crontab，执行：`curl https://bmp.your-domain.com/update`

7. 等待BMP同步（约16小时）。检查进度：`/stats`

要求：

- 网络服务器(GNU/Linux, Apache, MySQL, PHP)。

- +1 TB可用空间和+8 GB内存。

- 比特币现金BCH客户端，带-txindex。

<br />



## 常见问题

### 1）BMP背后的意图是什么？

- 在共识前阶段扩大"中本聪共识"。 

- 更精确地发掘中本聪共识，不仅仅是通过区块信号，也要通过聊天和投票。

- 促进中本聪共识的协调。

- 赋能矿工，实现比特币白皮书的愿景，让比特币在全球范围内得到应用，让世界更加自由。



### 2) BMP如何运作？

BMP是一个协议，一个链上系统和一个网络接口。它倾听比特币区块信息，根据爆块信号计算出每个BCH地址的精确比例的算力。这些动作的工作方式就像一个去中心化的现代社交网络（如memo.cash），并具有矿工聊天和投票功能。



### 3) 如何排除非BCH-256矿机？

BMP活动很容易被区块链过滤，或者只能连接到BCH得区块链。此外，BMP用户算力得确切比例是根据过去4,032个区块--之前的28天计算出来的。因此，矿工在参与BMP之前，必须做出算力展示。

### 4）BMP预共识过程是否具有约束力？

如今，BMP在共识前阶段扩展了"中本聪共识"。通过BMP，矿工们可以完美得信噪比协调行动（中本聪共识）。BMP提供了一个以前不存在的沟通渠道。这样，它为区块链增加了巨大的价值。 

未来可以在节点中实现BMP协议，例如在共识阶段执行预设参数的设置。



### 5）这与矿工发布公开声明有什么不同？

两者有很多不同之处，包括以下几点：

- 通过BMP，你可以"毫无疑问"地验证与每个动作相关联的算力的数量。

- 所有得BMP动作都“永久地”上传至链上。

- 借助BMP，矿工们可以用算力进行交谈和投票，具有现代社交网络的舒适性和深度，包括实时聊天和投票。

- 通过BMP，所有矿工都可参与，即使体量最小的矿工。不仅仅是矿池。

- BMP还允许向任何BCH地址委托任意百分比的算力。

这些都是BMP首次推出的重大创新，对区块链发展有重大影响。



### 6）BMP要解决的根本问题是什么？

根本问题主要是政治问题：一伙人必须事先达成一致，然后共同行动，而没有一个中央权威。 
 

这是一个政治问题，最初只能通过对话和外交来解决。 
 

在达成共识之前就存在着预共识。它首先发生。只有当预先共识存在时，才能达成共识。

### 7）什么是授权，如何增加价值？

有一些操作，可以将自己的算力的一定比例分配到不同的地址，用于BMP聊天和投票功能。BMP会准确地尊重矿工的这种自愿决定。这要归功于BMP的首次实现。

### 8) 与基金会相比，BMP的优势是什么？

可以将BMP看作是一个"股东会"，也可以是一个基金会。它将是一个运行在区块链上的基金会，因此不会被摧毁，长期稳定。

### 9) 我不是矿工，我如何才能支持BMP，鼓励矿工们参与使用BMP？

阅读以下信息，了解更多情况。广泛分享这些信息。鼓励矿工参与。

<br />


## 测试环境

- x86_64 GNU/Linux CentOS 7.8
- PHP 8
- MariaDB 5.5
- MySQL 5
- 火狐 67
- Chrome 74
- Bitcoin Unlimited 1.9.0
- P2Pool 17.0
- Trezor 钱包T型 （推荐）
- Trezor One(因为OP_RETURN大小有限，所以只支持部分功能)。

## 已知问题

- 当链重组式进行更新。
- 汉化
- 更多硬件钱包支持。
- 类IRC经典聊天攻击。
- 自动测试。
- 正式规格。
- 绝对的权力带来绝对的腐败。

## 更多信息

- [Why Bitcoin Cash Needs the BMP?](https://read.cash/@JavierGonzalez/why-bitcoin-cash-need-the-bmp-1a6ab975)
- [为什么比特币现金需要BMP系统?](https://read.cash/@JavierGonzalez/bmp-6bc8ea63)
- [¿Por qué Bitcoin Cash necesita el BMP?](https://read.cash/@JavierGonzalez/por-que-bitcoin-cash-necesita-el-bmp-e6a746a3)
- [https://twitter.com/askthebmp](https://twitter.com/askthebmp)
- [https://read.cash/@AskTheBMP](https://read.cash/@AskTheBMP)
- [Code Github](https://github.com/JavierGonzalez/BMP)

[Javier González González <br  /> 哈维尔·冈萨雷斯·冈萨雷斯](https://twitter.com/JavierGonzalez)<br />
gonzo@virtualpol.com<br />
BMP 架构师