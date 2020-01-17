<?php
 class Database{
     public static function getConnection(){
         $envPath = realpath(dirname(__FILE__).'/../env.ini');
         $env     = parse_ini_file($envPath);

         $db = "(DESCRIPTION = 
                    (ADDRESS_LIST = 
                        (ADDRESS =
                             (PROTOCOL = TCP)
                             (HOST = ".$env['host'].")
                             (PORT = 1521))
                        )
                        (CONNECT_DATA =
                            (SERVICE_NAME = ".$env['database'].")
                        )
                )
            ";
         $oConBD=OCILogon ($env['username'],$env['password'], $banco);
     
         if ($oConBD == false){
             echo( "Você não está conectado na Base de Dados!!!");
         }

     }
     public static function runDDL($ddl){
         
        // $banco = "(DESCRIPTION = (ADDRESS_LIST=(ADDRESS = (PROTOCOL = TCP)(HOST = austa-scan.austa.local)(PORT = 1521)))(LOAD_BALANCE = yes)(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = teste_ha) (FAILOVER_MODE =(TYPE = SELECT) (METHOD = BASIC)(RETRIES = 180) (DELAY = 5))))";
        $banco = "(DESCRIPTION =
                        (ADDRESS_LIST =
                            (ADDRESS = 
                                (PROTOCOL = TCP)
                                (HOST = 192.168.10.36)
                                (PORT = 1521)
                            )
                        )
                        (CONNECT_DATA =
                            (SERVICE_NAME = teste_ha)
                        )
                    )
                    ";
        $conn = OCILogon ("usr","password", $banco);
        $stmt = oci_parse($conn, $ddl);
        oci_execute($stmt) or die ($ddl);
        oci_close($conn);
    }
     public static function runQuery($query){
         
        // $banco = "(DESCRIPTION = (ADDRESS_LIST=(ADDRESS = (PROTOCOL = TCP)(HOST = austa-scan.austa.local)(PORT = 1521)))(LOAD_BALANCE = yes)(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = teste_ha) (FAILOVER_MODE =(TYPE = SELECT) (METHOD = BASIC)(RETRIES = 180) (DELAY = 5))))";
        $banco = "(DESCRIPTION =
                        (ADDRESS_LIST =
                            (ADDRESS = 
                                (PROTOCOL = TCP)
                                (HOST = 192.168.10.36)
                                (PORT = 1521)
                            )
                        )
                        (CONNECT_DATA =
                            (SERVICE_NAME = teste_ha)
                        )
                    )
                    ";
        $conn = OCILogon ("usr","password", $banco);
        $stmt = oci_parse($conn, $query);
        oci_execute($stmt) or die ($query);

        $ncols = oci_num_fields($stmt);
        $nCount = 1;
        while ($row = oci_fetch_assoc($stmt)){
            for ($i = 1; $i <= $ncols; $i++) 
            {
                $field									= oci_field_name($stmt, $i);
                $result[$nCount][strtolower($field)] 	= Trim(OCIResult($stmt,$field));
            }
            $nCount++;
        }
        oci_free_statement($stmt);
        oci_close($conn);
        return $result;
    }

 }//end class Database