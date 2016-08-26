# SSH Client For PHP
SSH Client for PHP.

| Build Status |
| ---- |
| [![Build Status](https://circleci.com/gh/HexPang/ssh-client.png?circle-token=7b09b960cbb1ddff17c8d93ccf7db44834569514)]|

## Install With Composer
> composer require hexpang/ssh-client

## Usage

```
use SSH;
$ssh = new SSH($host,$port,$username,$password);
```

## Method
| Method | Description | Usage |
| ------ | ----------- | ----- |
| Ping | Check port | $ssh->ping($host,$port,$timeOut)
| Connect | Connect to server | $ssh->Connect() |
| Authorize | Authorize | $ssh->Authorize() |
| Disconnect | Disconnect | $ssh->Disconnect() |
| Execute | Execute command and response result for an array[ Response,Error ] | $ssh->Execute($command) |
