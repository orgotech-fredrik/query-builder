<?php
class DB
{
    private static $db;

    public static function init()
    {
        self::$db = new PDO( "mysql:dbname=querybuilder;host=127.0.0.1", "root", "root" );
    }

    private static function table_exists( $tablename )
    {
        $check = self::$db->prepare( "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = :TABLE_NAME" );
        $check->execute( array( ':TABLE_NAME' => $tablename ) );

        if( $check->fetch()[ 0 ] > 0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getConnection()
    {
        return self::$db;
    }

    public static function table( $tablename )
    {
        if( self::table_exists( $tablename ) )
        {
            return new QueryBuilder( $tablename );
        }
    }
}
?>
