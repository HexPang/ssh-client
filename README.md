# SSH Client For PHP
SSH Client for PHP.

| Build Status |
| ---- |
| [![Build Status](https://circleci.com/gh/HexPang/ssh-client.png?circle-token=7b09b960cbb1ddff17c8d93ccf7db44834569514)]|

## Install With Composer
> composer require hexpang/ssh-client

## Namespace
> hexpang\Client\SSHClient

## Require
> [SSH2](https://pecl.php.net/package/ssh2)

## Usage

```
require_once 'path_to/vendor/autoload.php';
use hexpang\Client\SSHClient\SSHClient;
$client = new SSHClient($host,$port,$username,$password);
if($client->ping($host,$port,10)){
  if($client->Connect() && $client->Authorize()){
    var_dump($client->Execute('ls -l'));
  }else{
    echo "Oops.";
  }  
}else{
  echo "Ping Timeout!";
}
```

## Method
| Method | Description | Usage |
| ------ | ----------- | ----- |
| Ping | Check port | $ssh->ping($host,$port,$timeOut)
| Connect | Connect to server | $ssh->Connect() |
| Authorize | Authorize | $ssh->Authorize() |
| Disconnect | Disconnect | $ssh->Disconnect() |
| Execute | Execute command and response result for an array[ Response,Error ] | $ssh->Execute($command) |
