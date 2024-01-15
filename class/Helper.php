<?php

/**
 * Classe com metodos estáticos
 */
class Helper{

  /**
   * Sobe Arquivo
   * @param  file  $arquivo    - Pode ser uma imagem ou qualquer outro
   *                             tipo de arquivo
   * @param  string $diretorio - Caminho da pasta onde o arquivo
   *                             será armazenado
   * @return string || false     - nome do arquivo
   */
public static function sobeArquivo($arquivo,$diretorio = '../imagens/'){
    $arquivo = $arquivo;
    // pegar apenas o nome original do arquivo
    $nome_arquivo = $arquivo['name'];
      // verificar se algum arquivo foi enviado
      if(trim($nome_arquivo)!= '') {
          // pegar a extensao do arquivo         
          $extensao = explode('.', $nome_arquivo);
          // gerar nome         
          $novo_nome = date('YmdHis').rand(0,1000).'.'.end($extensao);         

          // montar o destino onde o arquivo será armazenado        
          $destino = $diretorio.$novo_nome;                  
          $ok = move_uploaded_file($arquivo['tmp_name'],$destino);
          // verificar se o upload foi realizado
          if($ok) {
            return $novo_nome;            
          } else {
            return false;
          }

      } else {
        return false;
      }
  }

  /**
     * Transforma a data no padrão do Brasil
     *
     * @param Date $data
     * @return string
     */
    public static function dataBrasil(string$data = null)
    {
      $data = $data;
      if(is_null($data)){
        $erro = '<b class="text-danger">Error</b>';
        return $erro;
      }
      $date = new DateTime($data);
      return $date->format('d/m/Y H:i');
    }

  /**
     * Transforma a data no padrão do Brasil
     *
     * @param Date $data
     * @return string
     */
    public static function diaBrasil(string$data = null)
    {
      $data = $data;
      if(is_null($data)){
        $erro = '<b class="text-danger">Error</b>';
        return $erro;
      }
      $date = new DateTime($data);
      return $date->format('d/m/Y');
    }
  
    /**
     * =======================================
     *  CONTROLE DE ACESSO
     * =======================================
     */

     /**
      * Verifica se existe a 
      * variavel de sessão logado
      *
      * @return bool
      */      
     public static function logado()
     {
       if(!isset($_SESSION['logado']) ){
        header('location:login.php?falha');
       }
     }

     public static function logadotrocar()
     {
       if(!isset($_SESSION['trocar']) ){
        header('location:logout.php');
       }
     }

     public static function logadoescolar()
     {
       if(!isset($_SESSION['logado']) ){
        header('location:../login.php?falha');
       }
     }

     /**
      * Verifica se existe a 
      * variavel de sessão logado
      *
      * @return bool
      */      
     public static function logadoadmin()
     {
       if(!isset($_SESSION['logado']) ){
          header('location:../login.php?falha');
       }else{
          if($_SESSION['nv_acesso'] < 3){
            header('location:../logout.php?falha');
          }
       }
     }

     /**
      * Criptografa um valor
      *
      * 05/05/2022
      * @param string $valor
      * @return string
      */
     public static function criptografar(string $valor)
     {
       //Um valor qualquer para ser usado como
       //chave na criptografia
       $salt = 'Jot@'; 

       //Retorna o valor recebido comp parâmetro,
      //usando a função CRYPT e o SALT
       return crypt($valor, $salt);
     }

     public static function data($data = null)
     {
      $data_atual = new DateTime(date('d-m-Y H:i'));
      $data = new DateTime($data);
  
      // Resgata diferença entre as datas
      $d = date_diff($data_atual, $data);
      if($d->i < 1 and $d->h == 0 and $d->d == 0 and $d->m == 0 and $d->y == 0){
        print("Agora mesmo");
      }elseif($d->h == 0 and $d->d == 0 and $d->m == 0 and $d->y == 0){
        print("há ".$d->format('%I')." minuto(s)");
      }elseif($d->h > 0 and $d->d == 0 and $d->m == 0 and $d->y == 0){
        print("há ".$d->format('%h')." hora(s)");
      }elseif($d->d > 0 and $d->m == 0 and $d->y == 0){
        print("há ".$d->format('%d')." dia(s)");
      }elseif($d->m > 0 and $d->y == 0){
        print("há ".$d->format('%m')." mes(es)");
      }elseif($d->y > 0){
        print("há ".$d->format('%y')." ano(s)");
      }
     }

    //  public static function excexpiradas(int $tdv)
    //  {
    //     $data_atual = new DateTime(date('d-m-Y H:i'));
    //     $data = new()
    //  }

    public static function generateauth(){
      $length = 50;

      $randomletter = substr(str_shuffle("abcdefgijklmnopqrstuvwxyz1234567890"), 0, $length);
      
      return $randomletter;
    }

    public static function generatetoken()
    {
      $length = 100;

      $randomletter = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefgijklmnopqrstuvwxyz1234567890"), 0, $length);

      return $randomletter;
    }

}

?>