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
  if($client->connect() && $client->authorize()){
    var_dump($client->cmd('ls -l'));
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
| ping | Check port | $ssh->ping($host,$port,$timeOut)
| connect | Connect to server | $ssh->connect() |
| authorize | Authorize | $ssh->authorize() |
| authorizeWithPK | Authorize With Public Key | $ssh->authorizeWithPK('id_rsa.pub','id_rsa','passphrase') |
| cmd | Execute command and response result for an array[ Response,Error ] | $ssh->cmd($command) |
| scp_send | Send file via SCP Protocol | $client->scp_send($local_file,$remote_file,$create_mode = 644) |
| scp_recv | Receive file via SCP Protocol | $client->scp_recv($remote_file,$local_file) |
| disconnect | Disconnect | $ssh->disconnect() |
