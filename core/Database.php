<?php
namespace Core;

use PDO;
/*
class Database {
    private static ?PDO $connection = null;
    
    public static function init(): void {
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}";
        self::$connection = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    
    public static function query(string $sql, array $params = []): \PDOStatement {
        $stmt = self::$connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public static function resultSet(\PDOStatement $stmt): array {
        return $stmt->fetchAll();
    }    
}
    */

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $pdo;
    private $stmt;
    private $error;

    /**
     * Database constructor
     */
    public function __construct($host = null, $dbname = null, $username = null, $password = null, $charset = 'utf8mb4')
    {
        // Use provided parameters or environment variables/config
        $this->host = $host ?? $_ENV['DB_HOST'] ?? 'localhost';
        $this->dbname = $dbname ?? $_ENV['DB_NAME'] ?? 'database';
        $this->username = $username ?? $_ENV['DB_USER'] ?? 'root';
        $this->password = $password ?? $_ENV['DB_PASS'] ?? '';
        $this->charset = $charset;

        $this->connect();
    }

    /**
     * Establish database connection
     */
    private function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            throw new Exception("Database connection failed: " . $this->error);
        }
    }

    /**
     * Prepare a query
     */
    public function query($query)
    {
        try {
            $this->stmt = $this->pdo->prepare($query);
            return $this;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Bind parameters to prepared statement
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }

    /**
     * Execute prepared statement
     */
    public function execute($params = [])
    {
        try {
            if (!empty($params)) {
                return $this->stmt->execute($params);
            }
            return $this->stmt->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Fetch all results as associative array
     */
    public function fetchAll($fetchMode = PDO::FETCH_ASSOC)
    {
        $this->execute();
        return $this->stmt->fetchAll($fetchMode);
    }

    /**
     * Fetch single result as associative array
     */
    public function fetch($fetchMode = PDO::FETCH_ASSOC)
    {
        $this->execute();
        return $this->stmt->fetch($fetchMode);
    }

    /**
     * Fetch single column value
     */
    public function fetchColumn($column = 0)
    {
        $this->execute();
        return $this->stmt->fetchColumn($column);
    }

    /**
     * Get row count
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Get last inserted ID
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Begin transaction
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        return $this->pdo->rollback();
    }

    /**
     * Select data from table
     */
    public function select($table, $columns = '*', $where = '', $orderBy = '', $limit = '')
    {
        $sql = "SELECT {$columns} FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        if (!empty($orderBy)) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if (!empty($limit)) {
            $sql .= " LIMIT {$limit}";
        }

        $this->query($sql);
        return $this;
    }

    /**
     * Insert data into table
     */
    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        
        $this->query($sql);
        
        foreach ($data as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        
        return $this->execute();
    }

    /**
     * Update data in table
     */
    public function update($table, $data, $where, $whereParams = [])
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $set);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        
        $this->query($sql);
        
        // Bind data parameters
        foreach ($data as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        
        // Bind where parameters
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->execute();
    }

    /**
     * Delete data from table
     */
    public function delete($table, $where, $whereParams = [])
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->execute();
    }

    /**
     * Check if record exists
     */
    public function exists($table, $where, $whereParams = [])
    {
        $sql = "SELECT COUNT(*) FROM {$table} WHERE {$where}";
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchColumn() > 0;
    }

    /**
     * Count records in table
     */
    public function count($table, $where = '', $whereParams = [])
    {
        $sql = "SELECT COUNT(*) FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchColumn();
    }

    /**
     * Execute raw SQL query
     */
    public function raw($sql, $params = [])
    {
        $this->query($sql);
        return $this->execute($params);
    }

    /**
     * Get all records from a table with pagination
     */
    public function paginate($table, $page = 1, $perPage = 10, $where = '', $whereParams = [], $orderBy = '')
    {
        $offset = ($page - 1) * $perPage;
        
        // Get total count
        $totalSql = "SELECT COUNT(*) FROM {$table}";
        if (!empty($where)) {
            $totalSql .= " WHERE {$where}";
        }
        
        $this->query($totalSql);
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        $total = $this->fetchColumn();
        
        // Get paginated data
        $sql = "SELECT * FROM {$table}";
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        if (!empty($orderBy)) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $sql .= " LIMIT {$perPage} OFFSET {$offset}";
        
        $this->query($sql);
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        $data = $this->fetchAll();
        
        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total)
        ];
    }

    /**
     * Perform JOIN operations
     */
    public function join($table1, $table2, $on, $type = 'INNER', $select = '*', $where = '', $whereParams = [])
    {
        $sql = "SELECT {$select} FROM {$table1} {$type} JOIN {$table2} ON {$on}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this;
    }

    /**
     * Bulk insert data
     */
    public function bulkInsert($table, $data)
    {
        if (empty($data)) {
            return false;
        }

        $columns = array_keys($data[0]);
        $columnList = implode(', ', $columns);
        
        $placeholders = [];
        foreach ($data as $index => $row) {
            $rowPlaceholders = [];
            foreach ($columns as $column) {
                $rowPlaceholders[] = ":{$column}_{$index}";
            }
            $placeholders[] = '(' . implode(', ', $rowPlaceholders) . ')';
        }
        
        $sql = "INSERT INTO {$table} ({$columnList}) VALUES " . implode(', ', $placeholders);
        
        $this->query($sql);
        
        foreach ($data as $index => $row) {
            foreach ($row as $column => $value) {
                $this->bind(":{$column}_{$index}", $value);
            }
        }
        
        return $this->execute();
    }

    /**
     * Get table schema/structure
     */
    public function getTableSchema($table)
    {
        $sql = "DESCRIBE {$table}";
        $this->query($sql);
        return $this->fetchAll();
    }

    /**
     * Drop table
     */
    public function dropTable($table)
    {
        $sql = "DROP TABLE IF EXISTS {$table}";
        return $this->raw($sql);
    }

    /**
     * Truncate table
     */
    public function truncateTable($table)
    {
        $sql = "TRUNCATE TABLE {$table}";
        return $this->raw($sql);
    }

    /**
     * Get database tables list
     */
    public function getTables()
    {
        $sql = "SHOW TABLES";
        $this->query($sql);
        return $this->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Search in table with LIKE operator
     */
    public function search($table, $column, $searchTerm, $additionalWhere = '', $whereParams = [])
    {
        $sql = "SELECT * FROM {$table} WHERE {$column} LIKE :search";
        
        if (!empty($additionalWhere)) {
            $sql .= " AND {$additionalWhere}";
        }
        
        $this->query($sql);
        $this->bind(':search', '%' . $searchTerm . '%');
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchAll();
    }

    /**
     * Get random records
     */
    public function random($table, $limit = 1, $where = '', $whereParams = [])
    {
        $sql = "SELECT * FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $sql .= " ORDER BY RAND() LIMIT {$limit}";
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchAll();
    }

    /**
     * Get minimum value from column
     */
    public function min($table, $column, $where = '', $whereParams = [])
    {
        $sql = "SELECT MIN({$column}) FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchColumn();
    }

    /**
     * Get maximum value from column
     */
    public function max($table, $column, $where = '', $whereParams = [])
    {
        $sql = "SELECT MAX({$column}) FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchColumn();
    }

    /**
     * Get average value from column
     */
    public function avg($table, $column, $where = '', $whereParams = [])
    {
        $sql = "SELECT AVG({$column}) FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchColumn();
    }

    /**
     * Get sum of column values
     */
    public function sum($table, $column, $where = '', $whereParams = [])
    {
        $sql = "SELECT SUM({$column}) FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchColumn();
    }

    /**
     * Group by with having clause
     */
    public function groupBy($table, $columns, $groupBy, $having = '', $havingParams = [], $orderBy = '')
    {
        $sql = "SELECT {$columns} FROM {$table} GROUP BY {$groupBy}";
        
        if (!empty($having)) {
            $sql .= " HAVING {$having}";
        }
        
        if (!empty($orderBy)) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        $this->query($sql);
        
        foreach ($havingParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchAll();
    }

    /**
     * Get distinct values
     */
    public function distinct($table, $column, $where = '', $whereParams = [])
    {
        $sql = "SELECT DISTINCT {$column} FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        
        foreach ($whereParams as $key => $value) {
            $this->bind($key, $value);
        }
        
        return $this->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Execute multiple queries within a transaction
     */
    public function transaction($queries)
    {
        try {
            $this->beginTransaction();
            
            foreach ($queries as $query) {
                if (is_array($query)) {
                    $this->query($query['sql']);
                    if (isset($query['params'])) {
                        $this->execute($query['params']);
                    } else {
                        $this->execute();
                    }
                } else {
                    $this->raw($query);
                }
            }
            
            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Get error message
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get PDO instance
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * Get prepared statement
     */
    public function getStatement()
    {
        return $this->stmt;
    }

    /**
     * Close database connection
     */
    public function close()
    {
        $this->pdo = null;
        $this->stmt = null;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->close();
    }
}

?>