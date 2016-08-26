<?php

/**
 * Created by PhpStorm.
 * User: hexpang
 * Date: 16/8/23
 * Time: 21:05
 */
namespace hexpang\Client\SSHClient;

class SSHClient
{
    var $handle;
    var $host;
    var $port;
    var $user;
    var $password;
    public function __construct($host,$port,$user,$password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    function Ping($host,$port = 22,$waitTimeoutInSeconds = 10){
        $succ = false;
        if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){
            $succ = true;
            fclose($fp);
        }
        return $succ;
    }
    public function Disconnect(){
        $this->Execute('exit');
        return true;
    }
    public function Connect(){
        if(!$this->Ping($this->host,$this->port)){
            return false;
        }
        $this->handle = @ssh2_connect($this->host,$this->port);
        if(!$this->handle){
            return false;
        }
        return true;
    }
    public function AuthorizeWithPublicKey($publicKeyFile,$privateKeyFile,$passphrase = ''){
      if(!$handle) return false;
      return @ssh2_auth_pubkey_file( $this->handle, $this->user, $publicKeyFile, $privateKeyFile, $passphrase);
    }
    public function Authorize(){
        if(!$handle) return false;
        return @ssh2_auth_password( $this->handle, $this->user, $this->password );
    }
    function Execute($command){
        if(!$handle) return false;
        $stream = @ssh2_exec($this->handle, $command);
        if($stream){
            $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
            stream_set_blocking($stream, true);
            stream_set_blocking($errorStream, true);
            $response = stream_get_contents( $stream );
            $errorInfo = stream_get_contents( $errorStream );
            fclose( $stream );
            fclose( $errorStream );
            return [$response,$errorInfo];
        }else{
            return null;
        }
    }

    protected static function getFacadeAccessor() {
        return 'SSH';
    }
}
