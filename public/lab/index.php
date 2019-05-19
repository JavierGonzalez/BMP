
<html>
<head>
<title>BMP</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">
<script src="https://unpkg.com/ionicons@4.5.5/dist/ionicons.js"></script>
<link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
<style type="text/css">


@import "bourbon";
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600);

body{
  font-family: "Lato";
  font-size: 100%; 
	overflow-y: scroll; 
 font-family: sans-serif; 
 -ms-text-size-adjust: 100%; 
 -webkit-text-size-adjust: 100%; 
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale; 
  text-rendering: optimizeLegibility;
  background-color: #fefefe;
}
a{
  text-decoration: none;
  @include transition(all 0.6s ease);
  
  &:hover{
     @include transition(all 0.6s ease);
  }
}

.app{
  height: 100vh;
}
/* -------------
Sidebar
----------------*/
.sidebar {
  position: absolute;
  //width: 33.3333%;
  width: 17em;
  height: 100%;
  top: 0;
  overflow:hidden;
  background-color: #19222a;
  -webkit-transform: translateZ(0);
  visibility: visible;
  -webkit-backface-visibility: hidden;
  
  header{
    background-color: #09f;
    width: 100%;
    display:block;
    padding: 0.75em	1em;
  }
}

/* -------------
Sidebar Nav
----------------*/
.sidebar-nav {
  position: fixed;
  //width: 13em;
  background-color: #19222a;
  height: 100%;
  font-weight: 400; 
  font-size: 1.2em;
  overflow: auto;
  padding-bottom: 6em;
  z-index: 9;
  overflow: hidden;
  -webkit-overflow-scrolling: touch;
 
  
  ul{
    list-style:none;
    display: block;
    padding: 0;
    margin: 0;
    
    li{
      margin-left: 0;
      padding-left: 0;
      //min-width: 13em;
      display:inline-block;
      width: 100%;
      
      a{
        color: rgba(255,255,255,0.9);
        font-size: 0.75em;
        padding: 1.05em	1em;
        position: relative;
        display:block;
        
        &:hover{
          background-color: rgba(0,0,0,0.9);
          @include transition(all 0.6s ease);
        }
      }
/* -------------
Sidebar: icons
----------------*/
      i{
        font-size: 1.8em;
        padding-right: 0.5em;
        width: 9em;
        display: inline;
        vertical-align:middle;
      }  
    }
  }

/* -------------
Chev elements
----------------*/ 
  & > ul > li > a:after {
    content: '\f125';
    font-family: ionicons;
    font-size: 0.5em;
    width: 10px;
    color: #fff;
    position: absolute;
    right: 0.75em;
    top: 45%;
  }
/* -------------
Nav-Flyout
----------------*/
  & .nav-flyout {
    position: absolute;
    background-color: #080D11;
    z-index: 9;
    left: 2.5em;
    top: 0;
    height: 100vh;
    @include transform(translateX(100%));
    @include transition(all 0.5s ease);
    
    a:hover{
      background-color: rgba(255,255,255, 0.05)
    }
  }

/* -------------
Hover
----------------*/
  & ul > li:hover{
      .nav-flyout{
      @include transform(translateX(0));
        @include transition(all 0.5s ease);
    }
  }
}




</style>




</head>
<body>


<section class="app">
  <aside class="sidebar">
         <header>
        Menu
      </header>
    <nav class="sidebar-nav">
 
      <ul>
        <li>
          <a href="#"><i class="ion-bag"></i> <span>Shop</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-color-filter-outline"></i>Derps</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-clock-outline"></i>Times</a>
            </li>
            <li>
              <a href="#"><i class="ion-android-star-outline"></i>Hates</a>
            </li>
            <li>
              <a href="#"><i class="ion-heart-broken"></i>Beat</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-settings"></i> <span class="">Controls</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-alarm-outline"></i>Watch</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-camera-outline"></i>Creeper</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-chatboxes-outline"></i>Hate</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-cog-outline"></i>Grinder</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-briefcase-outline"></i> <span class="">Folio</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-flame-outline"></i>Burn</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-lightbulb-outline"></i>Bulbs</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-location-outline"></i>Where You</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-locked-outline"></i>On Lock</a>
            </li>
             <li>
              <a href="#"><i class="ion-ios-navigate-outline"></i>Ghostface</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-analytics-outline"></i> <span class="">Graphicals</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-timer-outline"></i>Timers</a>
            </li>
            <li>
              <a href="#"><i class="ion-arrow-graph-down-left"></i>You Lose</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-partlysunny-outline"></i>Stormy</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-timer-outline"></i>Lookie Look</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-game-controller-a-outline"></i>Dork Mfer</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-paper-outline"></i> <span class="">Papers</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-filing-outline"></i>File Cab</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-information-outline"></i>Infos</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-paperplane-outline"></i>Planes</a>
            </li>
            <li>
              <a href="#"><i class="ion-android-star-outline"></i>Shop</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-navigate-outline"></i> <span class="">Ass Finder</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-flame-outline"></i>Burn</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-lightbulb-outline"></i>Bulbs</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-location-outline"></i>Where You</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-locked-outline"></i>On Lock</a>
            </li>
             <li>
              <a href="#"><i class="ion-ios-navigate-outline"></i>Ghostface</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-medical-outline"></i> <span class="">Cocaine</span></a>
        </li>
      </ul>
    </nav>
  </aside>
</section>










</body>
</html>

<?php exit;





























exit;





$hash = '0000000000000000013821c4378e842401ac54371a8afa81777327266bf418af';


$block = get_block($hash); 

print_r2($block);

foreach ($block['tx'] AS $txid)
    print_r2(get_raw_transaction($txid));


















exit;

// echo "/".bin2hex('.Zasdada||OWOKdkogx.')."/";
/*

load:
serializedTx: "0100000001cfc23df6def230ff07741658605df1bf747371e99be920fe2e18c5ae6f6b6d0f010000006b483045022100f878c64bca23812d28673d329a8c42faeeda2ecb3752bfbd804b87e3d313f24b022009707fb86fa9c46af7b37fd286b8195b4d96a703941692d090927266d82ec3bf41210399ce523c30063ae3279461d478ad12119a6311f15698b4f6864177b1c5f22c1300000000030000000000000000166a142e5a6173646164617c7c4f574f4b646b6f67782ee8030000000000001976a914cdd92e467dc1f54451ad257a7471a229e20b2b8e88acb99c2e03000000001976a914a4c82e1986695ed36e7cd8e31e947022ea9c1d1e88ac00000000"
signatures: ["3045022100f878c64bca23812d28673d329a8c42faeeda2ecb…af7b37fd286b8195b4d96a703941692d090927266d82ec3bf"]
txid: "30835fd669f4fd04066ef2f006556f0d029877d1ef75901a9c46ce7ac650b119"
__proto__: Obj


Enter (popup)
-- Esperar 10 sec
Cick (elegir cuenta)
Boton (send TX)
Confirm OP_RETURN en Trezor
Confirm TX en Trezor
Confirm value y fee en Trezor

Acción hecha!

*/

exit;
?>



<!DOCTYPE html>
<html>
<head>
<title>BMP</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<script src="https://connect.trezor.io/7/trezor-connect.js"></script>


</head>
<body>

Hello!



<script type="text/javascript">

var TrezorConnect = window.TrezorConnect;

TrezorConnect.manifest({
    email: 'gonzo@virtualpol.com',
    appUrl: 'https://bmp.virtualpol.com'
});



result = TrezorConnect.composeTransaction({
    outputs: [
        { amount: "1000", address: "qrxajtjx0hql23z345jh5ar35g57yzet3cypzvyfxr" },
        { type: "opreturn", dataHex: "2e5a6173646164617c7c4f574f4b646b6f67782e" }
    ],
    coin: "bch",
    push: true
});


console.log(result);

</script>

</body>
</html>



<?php



/* WORKS
var result = TrezorConnect.signMessage({
    path: "m/44'/0'/0'",
    message: "example messagezzz"
});


payload:
address: "184FkypGiToPEXYKRRdGyCRK5Hp1kFpVFH"
signature: "IAL7B4oNp2z73Ml0c8daMXH+pjkKOYGdDDYqF6epycbRORsll9306Xk9LftWfDhePv14zGOx01DfJa5q4U9MSM8="
__proto__: Object

*/



exit;


print_r2(op_return_decode('6a026d0320515b8ffeff983580bef3bb7f5fc0f82c2672b030aa8d78708d917cadde2ea7914cb654696d6520746f2064656369646520736f6d657468696e672e20225468652044657363656e7422206c6f6f6b73206d6f7265206c696b65206d79207468696e672c206275742022446f6e6e6965204461726b6f22206861732062657474657220726576696577732e2049207468696e6b20736f6f6e6572206f72206c6174657220492077696c6c20776174636820626f74682e203230306b2073617420676f657320746f20626f7468206f6620796f752e205468782e'));

//print_r2(get_block_info(582865));


// 77sdfsadfasdfsdafs/\
// 12cgsvJoYHFwsJ86FkKTgWWwXsWPbRqdhj
// bitcoincash:qqgm07gv7qnrazwu5w8jgcp2nx0p96s87sfgrm6f6k
print_r2($b->getrawtransaction('120283b1b1405aafdfab6c14f1c5820dc30c8a51dcbc0ee5618a2db2ed743142', 1));
// bitcoincash:qqgm07gv7qnrazwu5w8jgcp2nx0p96s87sfgrm6f6k




// holamundos
// qrxajtjx0hql23z345jh5ar35g57yzet3cypzvyfxr
// bitcoincash:qrxajtjx0hql23z345jh5ar35g57yzet3cypzvyfxr
// 1KmRhJwA44rQtgMeToVJwGRPoi89sXKF2w
print_r2($b->getrawtransaction('21880f3e68b0f22eea03a383b4573acb2e80414b76ad8efe5e1a92e312d8bbc5', 1));
// bitcoincash:qz3uveflvz5cj8fsx0hj7na7f6xcnm8qtyhsmyjdvz



print_r2($b->getrawtransaction('60b147d3c3e037882617f4d755bd481d71e51f4d3eb7501ce9ed50431abc24f2', 1));

print_r2($b->getrawtransaction('fc68765dec0674c531dec5e2aa53087814d642fe8720d886162a90b8618a284c', 1));

/*
crono();

print_r2(hex2bin('687474703a2f2f7669727475616c706f6c2e636f6d2f4d696e6572735f6172655f7468655f6578656375746976655f706f7765725f6f665f426974636f696e5f454e2e706466'));
*/

crono();

/*
[asm] => OP_RETURN 621      __________687474703a2f2f7669727475616c706f6c2e636f6d2f4d696e6572735f6172655f7468655f6578656375746976655f706f7765725f6f665f426974636f696e5f454e2e706466
[hex] => 6a026d0246687474703a2f2f7669727475616c706f6c2e636f6d2f4d696e6572735f6172655f7468655f6578656375746976655f706f7765725f6f665f426974636f696e5f454e2e706466



[asm] => OP_RETURN 621 4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c6974
[hex] => 6a026d0237    4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c6974
[type] => nulldata




OP_RETURN 6d02 687474703a2f2f7669727475616c706f6c2e636f6d2f4d696e6572735f6172655f7468655f6578656375746976655f706f7765725f6f665f426974636f696e5f454e2e706466

jmFhttp://virtualpol.com/Miners_are_the_executive_power_of_Bitcoin_EN.pdf

6a02
6d02   <--- Post memo
46
687474703a2f2f7669727475616c706f6c2e636f6d2f4d696e6572735f

*/

exit;

