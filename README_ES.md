# El Parlamento Minero de Bitcoin

ESTA ES UNA HERRAMIENTA DE CÓDIGO ABIERTO SIN RESPONSABILIDAD POR LAS ACCIONES TOMADAS POR TERCEROS


<p align="center">
<img src="https://github.com/JavierGonzalez/BMP/blob/master/static/logos/main_full.png?raw=true" width="400" height="400" alt="BMP logo" />
</p>








## ¿Por qué el Parlamento Minero de Bitcoin?

El [Parlamento Minero de Bitcoin](https://bmp.virtualpol.com) (BMP) es un protocolo y un sistema de votación con hashpower, descentralizado, en blockchain, de código abierto, verificable, fácil de usar, simple, extensible, voluntario, neutral y resistente a las interferencias externas. 

El BMP no toma partido en los desacuerdos internos de Bitcoin Cash. El BMP es un protocolo neutral que funciona con datos almacenados dentro de la cadena de bloques (on-chain). Es tan seguro como la blockchain de Bitcoin.

El BMP es un protocolo de gobierno de Bitcoin Cash que permite a los mineros coordinar sus acciones, y por tanto aportar una mayor certeza al ecosistema de BCH. Los mineros, y cualquier agente delegado, pueden hablar y votar con su hashpower, simplemente extendiendo el [Consenso de Nakamoto](https://bmp.virtualpol.com/bitcoin.pdf) en una fase de pre-consenso. 

El BMP empodera a los mineros con bloques en los últimos 28 días para comunicarse, con una perfecta relación señal-ruido. El BMP puede servir como una herramienta importante para el gobierno de Bitcoin Cash, reduciendo el riesgo de bifurcación, las luchas internas y las disputas.

<br  />

## Características
- Descentralizado, on-chain, verificable.
- Autenticación mediante hardware-wallet.
- Chat en tiempo real.
- Conectado a multiples blockchains opcionalmente sumando el hashpower SHA-256.
- Votación (múltiples puntos/opciones, votos rectificables, filtro por cadena de bloques, comentarios).
- BMP puede calcular el hashpower exacto de cada minero individual (no sólo de los pools).

BMP es un sistema web [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)), conectado a uno o más clientes de Bitcoin (vía RPC) para leer bloques y transacciones. Los datos de las cadenas de bloques se procesan con [este código PHP](https://github.com/JavierGonzalez/BMP/blob/master/+bmp/bmp.php) en tres tablas de caché SQL: [Bloques](https://bmp.virtualpol.com/info/blocks), [Mineros](https://bmp.virtualpol.com/info/miners) y [Acciones](https://bmp.virtualpol.com/info/actions).

Las acciones se almacenan en Bitcoin Cash (BCH) porque es rápido, barato y estable.

Las acciones sin hashpower son ignoradas. El poder de los mineros (% de hashpower) cambia con cada bloque. El porcentaje de poder de las acciones nunca cambia.

Las acciones se componen en JavaScript y se transmiten con "Trezor Connect". Más hardware-wallets estarán disponibles en el futuro.

BMP no almacena claves privadas y la base de datos local sólo contiene información pública.

Hay más detalles disponibles en el [Protocolo BMP](https://bmp.virtualpol.com/protocol) y en el [documento BMP EN](https://virtualpol.com/BMP_EN.pdf) | [ZH](https://virtualpol.com/BMP_CN.pdf) | [ES](https://virtualpol.com/BMP_ES.pdf).

<br  />

### Requisitos par participar

1. Su dirección está dentro de un output en coinbase en los últimos `4.032 bloques` de Bitcoin Cash (BCH).
2. Recomendado: Billetera de hardware Trezor (Usando una cuenta nueva, con fondos para los fees solamente).

<br  />

### Señalización de hashpower

- **`power_by_value`** 
Por defecto, el BMP calcula el porcentaje de hashpower proporcional de cada dirección a partir del `value` del las salidas `coinbase`. Esto lo hace compatible con todos los bloques de Bitcoin.

- **`power_by_opreturn`**
Con el fin de no interferir en las operaciones de minería, este segundo método permite la señalización de hashpower on una o varias direcciones con salida de coinbase OP_RETURN. Esto ignora el `value`, y permite la delegación del hashpower, con simplicidad.


- **`power_by_action`**
En desarrollo. Para una total flexibilidad, el protocolo BMP permitirá la delegación de un % de hashpower a una o varias direcciones con una acción de protocolo de BMP sin necesidad de estar en `coinbase`. De la misma manera, le permitirá modificar o revocar esa delegación de hashpower con efecto inmediato desde el siguiente bloque.

Con el BMP, los mineros pueden delegar porcentajes arbitrarios de hashpower a otras personas para que participen. De esta manera, los mineros pueden designar individualmente y de forma revocable representantes de manera fluida y responsable.

<br  />

## Cómo hacer


### 1) Cómo participar con una cartera de hardware Trezor

1. Acceda a un [servidor BMP](https://bmp.virtualpol.com). Por ejemplo: `https://BMP.virtualpol.com`
2. Confirme que su dirección (en formato legacy) está incluida en [/info/miners](https://bmp.virtualpol.com/info/miners).
3. Conecte su [Trezor](http://trezor.io/) por USB.
4. Haz clic en el botón amarillo `Login` (arriba a la derecha) y acepta.
5. Se abrirá un popup en la infraestructura web de Trezor. Acepta y selecciona la cuenta de tu dirección. Si el popup no se abre, entonces deshabilite su bloqueador de anuncios o programas similares que puedan cerrar los pop-ups.
6. Luego, el BMP mostrará tu dirección de inicio de sesión (arriba a la derecha).
7. Estás listo para participar! Puedes escribir en el chat, crear un voto o votar.


### 2) Cómo crear acciones manualmente

* Cada acción de los mineros es una transacción estándar en BCH.
* Las acciones del BMP usan el estilo <a href="https://memo.cash" target="_blank">Memo.cash</a>.
* La dirección del minero debe estar en un coinbase VOUT en uno de los últimos `4.032 bloques` de Bitcoin Cash (BCH).
* La dirección del minero debe estar en el TX_PREV VOUT (Cualquier `index`).
* La dirección del minero debe estar en el `index` VOUT=0.
* La carga útil OP_RETURN en el índice VOUT=1. 
* Prefijo OP_RETURN: "0x9d".
* OP_RETURN respetando el [Protocolo BMP](https://bmp.virtualpol.com/protocol). La web de BMP facilita el `OP_RETURN` en hexadecimal.

Algunos ejemplos de acciones: [chat](https://blockchair.com/bitcoin-cash/transaction/91162d0670c72fca6622d117e4d6b4149a3855de780295e852e471504b937c14), [vote](https://blockchair.com/bitcoin-cash/transaction/2c4219ce4533759a5886839d03494420e92c5add807c010c4b507b347b3b0e21).


### 3) Cómo señalizar el hashpower con P2Pool

Con P2Pool, hasta el minero más pequeño puede participar ahora mismo.

Este pool descentralizado recompensa a todos los mineros participantes incluyendo sus direcciones en la salida de la transacción de la base de monedas. Y esta información es todo lo que BMP necesita para que incluso los mineros más pequeños puedan participar.

1. Comienza la minería en un nodo P2Pool normalmente. Por ejemplo: `stratum+tcp://p2pool.imaginary.cash:9348`
2. El usuario es su dirección (formato heredado).
3. Eso es todo. 

Cuando P2Pool hace un nuevo bloque, todos los servidores BMP lo reconocerán y calcularán el hashpower asociado a tu dirección y podrás participar. Esto utiliza el método de la señal de hashpower `power_by_value`.


### 4) Cómo delegar el hashpower con `power_by_opreturn`

Si puedes hacer bloques en solitario (eres un pool o un gran minero) puedes delegar porcentajes arbitrarios de hashpower a una o más direcciones, sin alterar el `value` (recompensa del bloque). Esto permite la implementación del protocolo [BMP](https://bmp.virtualpol.com/protocol) en cualquier sistema sofisticado, sin interferir con la operación minera.

Como ejemplo, supongamos que queremos asignar el hashpower de nuestros bloques de la siguiente manera:
- 20% del hashpower a la dirección: 1AAtD721LQekC6ncHbAp4ScKxSwR7fFeYT
- 80% del hashpower a la dirección: 1AioJWvdeQq8ddzgz4mvywoBjfrqVQsD1s

1. Incluya en la `block template` estos códigos hexadecimales, en dos salidas OP_RETURN, dentro de la transacción de la base de monedas:
	- `0x9d000007d031414174443732314c51656b43366e63486241703453634b78537752376646655954`
	- `0x9d00001f403141696f4a5776646551713864647a677a346d7679776f426a667271565173443173`
2. Después de un nuevo bloque, compruebe [/info/miners](https://bmp.virtualpol.com/info/miners) y verifique que las direcciones aparecen con su hashpower proporcional.

- `0x` Indica que el código siguiente es hexadecimal.
- `9d` Indica el prefijo del protocolo [BMP](https://bmp.virtualpol.com/protocol). Primer byte OP_RETURN. 
- `00` Indica el identificador del modo `power_by_opreturn` de señalalización del hashpower (para ese bloque).
- `0007d0` en decimal representa `2000` que significa `20.00%` de hashpower.
- `31414174443732314c51656b43366e63486241703453634b78537752376646655954` es la dirección, en formato legacy, codificada con `bin2hex()`.

Esta funcionalidad no ha sido probada en el mainet. Por favor, escribe a gonzo@virtualpol.com o utiliza el soporte de Github para contactar.


### 5) Cómo desplegar su propio servidor BMP

1. Ponga el código del BMP en el directorio público `www` httpd.
2. Ejecuta `scheme.sql` en una nueva base de datos MySQL.
3. Renombra el archivo `+passwords.ini.template` a `+passwords.ini`.
4. Configurar el acceso RPC y SQL.
5. Espere hasta que los clientes de Bitcoin estén actualizados.
6. Configurar una `crontab` cada minuto de ejecución: `curl https://bmp.your-domain.com/update`
7. Espere la sincronización del BMP (~16h). Comprobar el progreso en: `/stats`

Requisitos:
* Servidor web (GNU/Linux, Apache, MySQL, PHP).
* +1 TB de espacio libre y +8 GB de RAM.
* Cliente BCH, con `-txindex`.


<br  />


## Preguntas frecuentes


### 1) ¿Cuál es la intención detrás del BMP?

- Extender el Consenso de Nakamoto en la fase de pre-consenso. 
- Descubrir el Consenso de Nakamoto con mayor precisión, no sólo mediante señales de bloques, sino también a través del chat y las votaciones.
- Facilitar la coordinación del Consenso de Nakamoto.
- Permitir a los mineros realizar la visión del libro blanco de Bitcoin para una adopción global y un mundo más libre.


### 2) ¿Cómo funciona el BMP?

El BMP es un protocolo, un sistema "en cadena" y una interfaz web. Escucha los bloques de Bitcoin para calcular la potencia computacional proporcional exacta de cada dirección BCH, de acuerdo con la señal de la base de monedas. Las acciones funcionan como una red social moderna y descentralizada (como [memo.cash](https://memo.cash)), y permiten a los mineros chatear y votar en las encuestas.


### 3) ¿Cómo se excluyen las acciones sin hashpower?

La actividad del BMP se puede filtrar por cadena de bloques o conectar a BCH solamente. Además, el hashpower proporcional exacto de un usuario de BMP se calcula a partir de los últimos 4.032 bloques (los ultimos 28 días). Por lo tanto, los mineros deben demostrar que están en el juego antes de participar en el BMP.


### 4) ¿Es vinculante el proceso de pre-consenso de BMP?

Hoy BMP extiende el Consenso de Nakamoto en una fase de pre-consenso. El BMP permite a los mineros coordinar sus acciones (Consenso de Nakamoto) con una perfecta relación señal-ruido. La BMP proporciona un canal de comunicación que no existía anteriormente. De esta manera, añade un enorme valor. 

En el futuro, el protocolo BMP puede implementarse en los nodos, por ejemplo, para ejecutar el ajuste de parámetros predefinidos en la fase de consenso.


### 5) ¿En qué se diferencia esto de una declaración pública de un minero?

Hay muchas diferencias, incluyendo las siguientes:

- Con el BMP, puedes verificar "más allá de toda duda" la cantidad de hashpower asociada a cada acción.
- Todas las acciones de BMP se firman en cadena "para siempre".
- El BMP permite a los mineros hablar y votar con hashpower con la comodidad y profundidad de una red social moderna, incluso a través de chat en vivo y votaciones.
- El BMP permite que todos los mineros participen, incluso los más pequeños. No sólo las piscinas.
- El BMP también permite la delegación de un porcentaje arbitrario de hashpower a cualquier dirección del BCH.

Todas estas son innovaciones significativas introducidas en el BMP por primera vez que pueden hacer la diferencia.


### 6) ¿Cuál es el problema de raíz que el BMP está tratando de resolver?

El problema de fondo es principalmente político: un grupo de humanos tiene que ponerse de acuerdo de antemano, y luego actuar juntos, sin la existencia de una autoridad central.

Es un problema político y la solución inicialmente sólo puede ser a través del diálogo y la diplomacia.

El consenso previo existe antes del consenso. Ocurre primero. Sólo cuando existe un pre-consenso, puede haber consenso.


### 7) ¿Qué es la delegación y cómo añade valor?

Hay acciones que permiten asignar un porcentaje de su propio hashpower a una dirección diferente para su uso en el chat de BMP y las funciones de votación. La BMP respeta esta decisión voluntaria del minero con exactitud. Esto es posible por primera vez gracias a BMP.


### 8) ¿Cómo se compara esto con una fundación?

El BMP puede ser considerado una "reunión de accionistas" o una fundación. Pero será una fundación on-chain (en cadena) y, por lo tanto, indestructible y estable a largo plazo.


### 9) ¿Cómo puedo, como no minero, apoyar la señal del BMP y animar a los mineros a usarla?

Infórmate leyendo la información que aparece a continuación. Comparta esta información ampliamente. Anime a los mineros a participar.


<br  />


## Entorno de test

* x86_64 GNU/Linux CentOS 7.8
* PHP 8
* MariaDB 5.5
* MySQL 5
* Firefox 67
* Chrome 74
* Bitcoin Unlimited 1.9.0
* P2Pool 17.0
* Trezor Model T (recomendado).
* Trezor One (parcialmente funcional, debido a un limite de OP_RETURN).


## Problemas conocidos

* Actualizar cuando se reorganiza la cadena.
* Internacionalización en Chino y Español.
* Más soporte para las carteras de hardware.
* Ataques clásicos como el IRC en el chat.
* Pruebas automáticas.
* Especificación formal.
* El poder absoluto corrompe absolutamente.


## Más información
- [Why Bitcoin Cash Needs the BMP?](https://read.cash/@JavierGonzalez/why-bitcoin-cash-need-the-bmp-1a6ab975)
- [为什么比特币现金需要BMP系统?](https://read.cash/@JavierGonzalez/bmp-6bc8ea63)
- [¿Por qué Bitcoin Cash necesita el BMP?](https://read.cash/@JavierGonzalez/por-que-bitcoin-cash-necesita-el-bmp-e6a746a3)
- [https://twitter.com/askthebmp](https://twitter.com/askthebmp)
- [https://read.cash/@AskTheBMP](https://read.cash/@AskTheBMP)
- [Code Github](https://github.com/JavierGonzalez/BMP)


[Javier González González](https://twitter.com/JavierGonzalez)<br />
gonzo@virtualpol.com<br />
BMP Architect
