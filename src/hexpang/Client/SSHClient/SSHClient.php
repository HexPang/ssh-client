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
    var $pkey;
    var $error;
    var $host;
    var $port;
    var $user;
    var $password;
    
    public function __construct($host,$port,$user,$password = "")
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    function ping($host,$port = 22,$waitTimeoutInSeconds = 10){
        $succ = false;
        if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){
            $succ = true;
            fclose($fp);
        }
        return $succ;
    }

    public function disconnect(){
        $this->cmd('exit');
        return true;
    }

    public function connect(){
        if(!$this->Ping($this->host,$this->port)){
            return false;
        }
        $this->handle = @ssh2_connect($this->host,$this->port);
        if(!$this->handle){
            return false;
        }
        return true;
    }

    public function authorizeWithPK($publicKeyFile,$privateKeyFile,$passphrase = ''){
      if(!$this->handle) return false;
      return @ssh2_auth_pubkey_file( $this->handle, $this->user, $publicKeyFile, $privateKeyFile, $passphrase);
    }

    public function authorize(){
        if(!$this->handle) return false;
        return @ssh2_auth_password( $this->handle, $this->user, $this->password );
    }
    // public function PublicKeyInit(){
    //     $this->pkey = ssh2_publickey_init($this->handle);
    //     return $this->pkey;
    // }
    // public function PublicKeyList(){
    //     return ssh2_publickey_list($this->pkey);
    // }

    public function scp_send($local_file,$remote_file,$create_mode = 0644){
      return $this->handle ? ssh2_scp_send($this->handle, $local_file, $remote_file, $create_mode) : false;
    }

    public function scp_recv($remote_file,$local_file){
      return $this->handle ? ssh2_scp_recv($this->handle, $remote_file, $local_file) : false;
    }

    public function cmd($command){
        if(!$this->handle) return false;
        $stream = @ssh2_exec($this->handle, $command);
        if($stream){
            $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
            stream_set_blocking($stream, true);
            stream_set_blocking($errorStream, true);
            $response = stream_get_contents( $stream );
            $this->$error = stream_get_contents( $errorStream );
            fclose( $stream );
            fclose( $errorStream );
            return $response;
        }else{
            return null;
        }
    }
}
